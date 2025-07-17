<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use App\Models\TravelTransaction;
use App\Models\TravelTransactionDetail;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{
    use ValidatesRequests;

    private $crudController;

    public function __construct()
    {
        $this->crudController = new globalCRUDController;
    }

    public function create(Request $request)
    {
        try {
            $data = null;
            DB::transaction(function () use ($request, &$data) {
                $user = Auth::user();
                $user_id = $user->user_id ?? null;
                if (! isset($request->Packages)) {
                    throw new \Exception('Packages field is required.');
                }
                $package = Packages::findOrFail($request->Packages);

                /*
                    if ($package->MaxCapacity < $request->totalPax) {
                        throw new \Exception('Package availability cannot meet the existing supply, the remaining package availability is ' . $package->MaxCapacity);
                    }
                */

                $data = TravelTransaction::create([
                    'Oid' => (string) Str::uuid(),
                    'CreateBy' => $user_id,
                    'Packages' => $request->Packages,
                    'Code' => 'PKG - '.strtoupper(Str::random(7)),
                    'Price' => ! $request->isCustomItineraries
                        ? ($request->totalPax ?? 1) * $package->Price
                        : 0,
                ]);
                $data->save();

                if ($request->has('Itineraries')) {
                    $itinerary = implode(', ', $request->Itineraries);
                }

                $trvTransationDetail = TravelTransactionDetail::create([
                    'Oid' => (string) Str::uuid(),
                    'CreateBy' => $user_id,
                    'TravelTransaction' => $data->Oid,
                    'TotalPax' => $request->totalPax ?? 1,
                    'Name' => $request->firstName.' '.$request->lastName,
                    'Email' => $request->Email,
                    'Status' => 'Entry',
                    'PhoneNumber' => $request->PhoneNumber,
                    'EnterDate' => $request->EnterDate,
                    'ExitDate' => $request->ExitDate,
                    'isCustomItineraries' => $request->isCustomItineraries ?? 0,
                    'Description' => 'The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price',
                    'Itineraries' => isset($itinerary) ? $itinerary : null,
                ]);

                $package->save();
                $data->Package = $package;
                $data->Detail = $trvTransationDetail;
            });

            if (! $request->isCustomItineraries) {
                $this->crudController->sendEmail($data, 'emails.bookingInvoice', 'Invoice');
            }

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create cart.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function updatePayment(Request $request)
    {
        try {
            DB::transaction(function () use ($request, &$data) {
                $data = TravelTransaction::with(['details', 'packages'])->where('Code', $request->external_id)->first();
                if (! $data) {
                    throw new \Exception("Travel Transaction doesn't exist.");
                }
                $data->Price = $request->amount;
                $trvTransationDetail = $data->details[0];
                $trvTransationDetail->Status = $request->status;

                if (strtolower($request->status) == 'paid') {
                    $this->crudController->sendEmail($data, 'emails.bookingConfirmation', 'Confirmation');
                }

                $trvTransationDetail->save();
                $data->save();
            });

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve packages.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function createPayment(Request $request, $Oid)
    {
        try {
            DB::transaction(function () use ($Oid, $request, &$data) {
                $data = TravelTransaction::with(['details', 'packages'])->findOrFail($Oid);
                $qrCode = paymentProcess($data, 'QR', $request);
                // dd($qrCode, $data);
                $data->Price = $qrCode['amount'];
                $data->save();
                if (! is_array($qrCode) && $qrCode->getData(true)['success'] == false) {
                    throw new \Exception($qrCode->getData()->error);
                }
                $data->PaymentLink = $qrCode['invoice_url'];
            });

            return response()->json([$data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment process failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Request $request, $Oid)
    {
        try {
            DB::transaction(function () use ($Oid) {
                $package = Packages::findOrFail($Oid);
                $package->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Package is successfully deleted',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete package',
            ], 500);
        }
    }
}
