<?php

namespace App\Http\Controllers;

use App\Models\Itineraries;
use App\Models\Role;
use App\Models\User;
use App\Models\Packages;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TravelTransaction;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\TravelTransactionDetail;
use Tymon\JWTAuth\Exceptions\JWTException;
use function PHPUnit\Framework\throwException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CartController extends Controller
{
    use ValidatesRequests;

    private $crudController;

    public function __construct()
    {
        $this->crudController = new globalCRUDController();
    }

    public function create(Request $request)
    {
        try {
            $data = null;
            DB::transaction(function () use ($request, &$data) {
                $user = Auth::user();
                $user_id = $user->user_id ?? null;
                if (!isset($request->Packages)) throw new \Exception('Packages field is required.');
                $package = Packages::findOrFail($request->Packages);
                if ($package->MaxCapacity < $request->totalPax) throw new \Exception('Package availability cannot meet the existing supply, the remaining package availability is ' . $package->MaxCapacity);
                $data = TravelTransaction::create([
                    "Oid" => (string) Str::uuid(),
                    "CreateBy" => $user_id,
                    "Packages" => $request->Packages,
                    "Code" => "PKG - " . strtoupper(Str::random(7))
                ]);
                $data->save();

                if ($request->has('Itineraries')) {
                    $Itineraries = gettype($request->Itineraries) == "string" ? [$request->Itineraries] : $request->Itineraries;
                    $trvTransationDetail = $this->detailSaving($request, $user_id, $data, $package, $Itineraries);
                } else $trvTransationDetail = $this->detailSaving($request, $user_id, $data, $package);

                $data->Detail = $trvTransationDetail;

                $package->save();
                $data->Package = $package;
            });

            if (!$request->isCustomItineraries) $this->crudController->sendEmail($data, 'emails.bookingInvoice', 'Invoice');
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create cart.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function detailSaving($request, $user_id, $data, $package, $Itineraries = null)
    {
        if ($Itineraries) {
            $Price = 0;
            foreach ($Itineraries as $itinerary) {
                $itineraryObj = Itineraries::findOrFail($itinerary);
                $trvTransationDetail = TravelTransactionDetail::create([
                    "Oid" => (string) Str::uuid(),
                    "CreateBy" => $user_id,
                    "TravelTransaction" => $data->Oid,
                    "TotalPax" => $request->totalPax ?? 1,
                    "Name" => $request->firstName . " " . $request->lastName,
                    "Email" => $request->Email,
                    "Status" => "Entry",
                    "PhoneNumber" => $request->PhoneNumber,
                    "EnterDate" => $request->EnterDate,
                    "ExitDate" => $request->ExitDate,
                    "isCustomItineraries" => $request->isCustomItineraries ?? 0,
                    "Itineraries" => $itinerary
                ]);
                $trvTransationDetail->Description = "The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price";
                $trvTransationDetail->save();
                $Price += $trvTransationDetail->TotalPax * $itineraryObj->Price;
                $package->MaxCapacity -= $trvTransationDetail->TotalPax;
            }
            $Price += $trvTransationDetail->TotalPax * $package->Price;
            $trvTransationDetail->Price = $Price;
        } else {
            $trvTransationDetail = TravelTransactionDetail::create([
                "Oid" => (string) Str::uuid(),
                "CreateBy" => $user_id,
                "TravelTransaction" => $data->Oid,
                "TotalPax" => $request->totalPax ?? 1,
                "Name" => $request->firstName . " " . $request->lastName,
                "Email" => $request->Email,
                "Status" => "Entry",
                "PhoneNumber" => $request->PhoneNumber,
                "EnterDate" => $request->EnterDate,
                "ExitDate" => $request->ExitDate,
                "isCustomItineraries" => $request->isCustomItineraries ?? 0,
                "Itineraries" => null
            ]);
            $trvTransationDetail->Description = "The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price";
            $trvTransationDetail->save();
            $trvTransationDetail->Price = $trvTransationDetail->TotalPax * $package->Price;
            $package->MaxCapacity -= $trvTransationDetail->TotalPax;
        }
    }

    public function updatePayment(Request $request)
    {
        try {
            DB::transaction(function () use ($request, &$data) {
                $data = TravelTransaction::with(['details', 'packages'])->where('Code', $request->external_id)->first();
                if (!$data) throw new \Exception("Travel Transaction doesn't exist.");
                $data->Price = $request->amount;
                $trvTransationDetail = $data->details[0];
                $trvTransationDetail->Status = $request->status;

                if (strtolower($request->status) == "paid") $this->crudController->sendEmail($data, 'emails.bookingConfirmation', 'Confirmation');
                unset($data->Price);

                $trvTransationDetail->save();
                $data->save();
            });
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve packages.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function createPayment(Request $request, $Oid)
    {
        try {
            DB::transaction(function () use ($Oid, &$data) {
                $data = TravelTransaction::with(['details', 'packages'])->findOrFail($Oid);
                $qrCode = paymentProcess($data, "QR");
                $data->save();
                if (!is_array($qrCode) && $qrCode->getData(true)['success'] == false) throw new \Exception($qrCode->getData()->error);
                $data->PaymentLink = $qrCode['invoice_url'];
            });

            return response()->json([$data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment process failed',
                'error' => $e->getMessage()
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
                'message' => "Package is successfully deleted"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete package',
            ], 500);
        }
    }
}
