<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Packages;
use Illuminate\Http\Request;
use App\Models\TravelTransaction;
use App\Models\TravelTransactionDetail;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Laravel\Prompts\error;
use function PHPUnit\Framework\throwException;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CartController extends Controller
{
    use ValidatesRequests;

    public function create(Request $request)
    {
        try {
            $data = null;
            DB::transaction(function () use ($request, &$data) {
                $user = Auth::user();
                if (!isset($request->Packages)) throw new \Exception('Packages field is required.');
                $package = Packages::findOrFail($request->Packages);
                if ($package->MaxCapacity < $request->totalPax) throw new \Exception('Package availability cannot meet the existing supply, the remaining package availability is ' . $package->MaxCapacity);
                $data = TravelTransaction::create([
                    "Oid" => (string) Str::uuid(),
                    "CreateBy" => $user->user_id,
                    "Packages" => $request->Packages,
                    "Code" => "PKG - " . strtoupper(Str::random(7))
                ]);
                $data->save();

                $trvTransationDetail = TravelTransactionDetail::create([
                    "Oid" => (string) Str::uuid(),
                    "CreateBy" => $user->user_id,
                    "TravelTransaction" => $data->Oid,
                    "TotalPax" => $request->totalPax ?? 1,
                    "Name" => $request->firstName . " " . $request->lastName,
                    "Email" => $request->Email,
                    "PhoneNumber" => $request->PhoneNumber,
                    "EnterDate" => $request->EnterDate,
                    "ExitDate" => $request->ExitDate,
                    "isCustomItineraries" => $request->isCustomItineraries ?? 0,
                    "Itineraries" => isset($request->Itineraries) ? $request->Itineraries : null
                ]);
                $trvTransationDetail->Description = "The Price Is Shown Is Not Fix, Please Contact Our Admin To Discuss The Final Price";
                $trvTransationDetail->save();
                $data->Detail = $trvTransationDetail;

                $package->MaxCapacity -= $trvTransationDetail->TotalPax;
                $package->save();
            });

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

    public function updatePayment(Request $request)
    {
        try {
            DB::transaction(function () use ($request, &$data) {
                $data = TravelTransaction::with(['details', 'packages'])->where('Code', $request->external_id)->first();
                $trvTransationDetail = $data->details[0];
                $trvTransationDetail->Status = $request->status;
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
