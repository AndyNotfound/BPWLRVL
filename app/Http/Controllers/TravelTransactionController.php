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
            $isSelectAll = $perPage == "-1";

            $query = TravelTransaction::with(['package', 'details']);

            $result = $isSelectAll ? $query->get() : $query->paginate($perPage);
            $collection = $isSelectAll ? $result : $result->getCollection();

            $data = $collection->map(function ($item) {
                $detail = $item->details->first();
                $package = $item->package;

                return [
                    'Oid' => $item->Oid,
                    'TravelTransactionCode' => $item->Code,
                    'TravelTransactionStatus' => $detail->Status ?? 'N/A',
                    'TravelTransactionGuestName' => $detail->Name ?? 'N/A',
                    'TravelPackageOid' => $package->Oid ?? 'N/A',
                    'TravelPackageName' => $package->Name ?? 'N/A',
                    'TravelPackagePrice' => $package->isCustomItineraries ? $item->Price : $package->Price ?? 'N/A',
                    'TravelPackageFlexible' => $package->isCustomItineraries ?? false,
                    'TravelPackageDateStart' => $detail->EnterDate ?? 'N/A',
                    'TravelPackageDateEnd' => $detail->ExitDate ?? 'N/A',
                ];
            });

            $response = [
                'success' => true,
                'data' => [
                    'current_page' => $isSelectAll ? 1 : $result->currentPage(),
                    'per_page' => $isSelectAll ? $data->count() : $result->perPage(),
                    'total' => $isSelectAll ? $data->count() : $result->total(),
                    'data' => $data,
                ],
            ];

            return response()->json($response);
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

            if($travelTransaction->package->isCustomItineraries) {
                $itineraryIds = explode(', ', $travelTransaction->details[0]->Itineraries ?? '');
                
                $travelTransaction->Itineraries = collect($itineraryIds)
                    ->map(fn($id) => Itineraries::findOrFail($id))
                    ->all();
            }

            return response()->json([$travelTransaction]);
        } catch (\Exception $e) {
            dd($e);
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

    public function adminStats(Request $request)
    {
        try {
            $totalClients = User::whereRelation('roleObj', 'name', 'client')->count();
            $totalTransactions = TravelTransaction::count();
            $totalPaidTransactions = TravelTransaction::whereRelation('details', 'Status', 'Paid')->count();
            $totalUnpaidTransactions = TravelTransaction::whereHas('details', function ($query) {
                $query->whereIn('Status', ['Entry', 'Process']);
            })->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'totalClients' => $totalClients,
                    'totalTransactions' => $totalTransactions,
                    'totalPaidTransactions' => $totalPaidTransactions,
                    'totalUnpaidTransactions' => $totalUnpaidTransactions
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve package stats.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function userTravelTransactions(Request $request) {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not authenticated.',
                ], 401);
            }

            $data = TravelTransaction::with(['details', 'package'])->where('CreateBy', $user->user_id)->get();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user travel transactions.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
