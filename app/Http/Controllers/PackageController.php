<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Packages;
use App\Models\Itineraries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PackageController extends Controller
{
    use ValidatesRequests;
    private $crudController;

    public function __construct()
    {
        $this->crudController = new globalCRUDController();
    }

    private function getFilteredPackages(Request $request, string $filterField)
    {
        try {
            $perPage = $request->input('per_page', 10);

            $packages = Packages::where($filterField, 1)->paginate($perPage);
            $packageIds = $packages->pluck('Oid');

            $popularCounts = DB::table('travel_transactions')
                ->select('Packages', DB::raw('COUNT(*) as total'))
                ->whereIn('Packages', $packageIds)
                ->groupBy('Packages')
                ->pluck('total', 'Packages');

            $threshold = 5;

            $packages->getCollection()->transform(function ($package) use ($popularCounts, $threshold) {
                $package->isPopular = ($popularCounts[$package->Oid] ?? 0) >= $threshold;
                return $package;
            });

            return response()->json([
                'success' => true,
                'data' => $packages
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve packages.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function list(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $packages = Packages::paginate($perPage);

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

    public function favorites(Request $request)
    {
        return $this->getFilteredPackages($request, 'isFavorites');
    }

    public function seasonal(Request $request)
    {
        return $this->getFilteredPackages($request, 'isSeasonal');
    }

    public function custom(Request $request)
    {
        return $this->getFilteredPackages($request, 'isCustomItineraries');
    }

    public function mustsee(Request $request)
    {
        return $this->getFilteredPackages($request, 'isMustSee');
    }

    public function show(Request $request, $Oid)
    {
        try {
            $packages = Packages::findOrFail($Oid);

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

    public function save(Request $request, $Oid = null)
    {
        try {
            DB::transaction(function () use ($Oid, $request, &$data) {
                $payload = $request->all();
                $payload['CreateBy'] = Auth::user()['user_id'];
                $data = $this->crudController->save($payload, "Packages", $Oid);
            });

            return response()->json([
                'success' => true,
                'message' => "Package is successfully saved",
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save',
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

    public function stats(Request $request)
    {
        try {
            $userCount = User::count();
            $itinerariesCount = Itineraries::count();
            $packageCount = Packages::count();

            return response()->json([
                'stats' => [
                    'userCount' => $userCount,
                    'itinerariesCount' => $itinerariesCount,
                    'packageCount'  => $packageCount,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve package statistics.',
            ], 500);
        }
    }
}
