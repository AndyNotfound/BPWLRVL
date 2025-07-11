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

    private function getFilteredPackages(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);

            $packages = Packages::inRandomOrder()->paginate($perPage);
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

    public function adminStats(Request $request)
    {
        try {
            $totalPackages = Packages::count();
            $customItinerariesCount = Packages::where('isCustomItineraries', 1)->count();
            $nonCustomItinerariesCount = Packages::where('isCustomItineraries', 0)->count();
            $totalItineraries = Itineraries::count();

            return response()->json([
                'success' => true,
                'data' => [
                    'totalPackages' => $totalPackages,
                    'totalCustomItineraries' => $customItinerariesCount,
                    'totalFixedItineraries' => $nonCustomItinerariesCount,
                    'totalItineraries' => $totalItineraries,
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

    public function list(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $isSelectAll = $perPage == "-1";
            $search = $request->input('search');

            $query = Packages::query();
            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('Name', 'like', '%' . $search . '%')
                        ->orWhere('Location', 'like', '%' . $search . '%');
                });
            }

            $result = $isSelectAll ? $query->get() : $query->paginate($perPage);
            $collection = $isSelectAll ? $result : $result->getCollection();

            // ✅ Parse itineraries string jadi array
            $collection->transform(function ($pkg) {
                $pkg->Itineraries = $pkg->Itineraries
                    ? array_map('trim', explode(',', $pkg->Itineraries))
                    : [];
                return $pkg;
            });

            return response()->json([
                'success' => true,
                'data' => $collection
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
        return $this->getFilteredPackages($request);
    }
    public function seasonal(Request $request)
    {
        return $this->getFilteredPackages($request);
    }
    public function custom(Request $request)
    {
        return $this->getFilteredPackages($request);
    }
    public function mustsee(Request $request)
    {
        return $this->getFilteredPackages($request);
    }

    public function show(Request $request, $Oid)
    {
        try {
            $packages = Packages::with(['reviews', 'reviews.creator'])->findOrFail($Oid);

            $arrayItineraries = [];

            if (!empty($packages->Itineraries)) {
                foreach (explode(", ", $packages->Itineraries) as $itineraryOid) {
                    $arrayItineraries[] = Itineraries::where("Oid", trim($itineraryOid))->first();
                }
                if ($arrayItineraries) {
                    $packages->Itineraries = $arrayItineraries;
                }
            }

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

                if (isset($payload['Itineraries'])) {
                    if (is_string($payload['Itineraries'])) {
                        $decoded = json_decode($payload['Itineraries'], true);

                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                            $payload['Itineraries'] = implode(', ', $decoded);
                        } else {
                            $cleaned = trim($payload['Itineraries'], "[]\"");
                            $payload['Itineraries'] = implode(', ', array_map('trim', explode(',', $cleaned)));
                        }
                    } elseif (is_array($payload['Itineraries'])) {
                        $payload['Itineraries'] = implode(', ', $payload['Itineraries']);
                    }
                }

                $data = $this->crudController->save($payload, "Packages", $Oid, $request);
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

    public function topPackages(Request $request)
    {
        try {
            $topPackages = DB::table('travel_transactions')
                ->select('Packages', DB::raw('COUNT(*) as total_orders'))
                ->whereNotNull('Packages')
                ->groupBy('Packages')
                ->orderByDesc('total_orders')
                ->limit(5)
                ->get();

            if ($topPackages->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No transactions found.',
                ], 404);
            }

            $packageDetails = Packages::whereIn('Oid', $topPackages->pluck('Packages'))->get();

            $icons = ['tabler-beach', 'tabler-plane-tilt', 'tabler-camera', 'tabler-luggage', 'tabler-brand-tripadvisor'];
            $colors = ['primary', 'info', 'success', 'warning', 'secondary'];

            $results = [];

            foreach ($packageDetails as $index => $pkg) {
                $transaction = $topPackages->firstWhere('Packages', $pkg->Oid);
                $views = $transaction ? $transaction->total_orders : 0;

                $results[] = [
                    'title' => $pkg->Title ?? $pkg->Name,
                    'bookings' => $views >= 1000 ? number_format($views / 1000, 1) . 'k' : (string) $views,
                    'icon' => $icons[$index % count($icons)],
                    'color' => $colors[$index % count($colors)],
                ];
            }

            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching top packages',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
