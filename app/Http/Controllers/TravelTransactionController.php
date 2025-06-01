<?php

namespace App\Http\Controllers;

use App\Models\Itineraries;
use App\Models\Role;
use App\Models\User;
use App\Models\Packages;
use App\Models\TravelTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelTransactionController extends Controller
{
    use ValidatesRequests;

    private $crudController;

    public function __construct()
    {
        $this->crudController = new globalCRUDController();
    }

    /* Different from requirement
        public function list(Request $request)
        {
            try {
                $perPage = $request->input('per_page', 10);
                $packages = TravelTransaction::paginate($perPage);

                return response()->json([
                    'success' => true,
                    'data' => $packages
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve packages.',
                ], 500);
            }
        }
    */

    public function list(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);

            $transactions = TravelTransaction::with(['package', 'details'])->paginate($perPage);

            $data = $transactions->getCollection()->transform(function ($item) {
                return [
                    'Oid' => $item->Oid,
                    'TravelTransactionCode' => $item->Code,
                    'TravelTransactionStatus' => $item->details->first()?->Status ?? 'N/A',
                    'TravelTransactionGuestName' => $item->details->first()?->Name ?? 'N/A',
                    'TravelPackageOid' => $item->package?->Oid ?? 'N/A',
                    'TravelPackageName' => $item->package?->Name ?? 'N/A',
                    'TravelPackagePrice' => $item->package?->Price ?? 'N/A',
                    'TravelPackageFlexible' => $item->package?->isCustomItineraries,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'current_page' => $transactions->currentPage(),
                    'per_page' => $transactions->perPage(),
                    'total' => $transactions->total(),
                    'data' => $data,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve travel transactions.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, $Oid)
    {
        try {
            $travelTransaction = TravelTransaction::with(['details', 'package'])->findOrFail($Oid);
            $itineraryIds = explode(', ', $travelTransaction->details[0]->Itineraries ?? '');

            $travelTransaction->Itineraries = collect($itineraryIds)
                ->map(fn($id) => Itineraries::findOrFail($id))
                ->all();
            return response()->json([$travelTransaction]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Travel Transaction Not Found',
            ], 500);
        }
    }

    public function save(Request $request, $Oid = null)
    {
        try {
            DB::transaction(function () use ($Oid, $request, &$data) {
                $payload = $request->all();
                $payload['CreateBy'] = Auth::user()['user_id'];
                $data = $this->crudController->save($payload, "TravelTransaction", $Oid);
            });
            return response()->json([
                'success' => true,
                'message' => "Travel Transaction is successfully saved",
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed To Save/Update Travel Transaction',
            ], 500);
        }
    }
}
