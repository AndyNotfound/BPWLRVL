<?php

namespace App\Http\Controllers;

use App\Models\review;
use App\Models\TravelTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    private $crudController;

    public function __construct()
    {
        $this->crudController = new globalCRUDController;
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);

            $data = review::leftJoin('packages', 'reviews.Packages', '=', 'packages.Oid')
                ->leftJoin('users', 'reviews.CreateBy', '=', 'users.user_id')
                ->select('reviews.*', 'users.username', 'packages.name as PackageName')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Reviews.',
            ], 500);
        }
    }

    public function listGlobal(Request $request)
    {
        try {
            $reviewsLimit = $request->input('reviewsLimit', 10);
            $packagesLimit = $request->input('packagesLimit', 5);
            $topPackages = Review::select('Packages')
                ->selectRaw('count(*) as total_reviews')
                ->groupBy('Packages')
                ->orderByDesc('total_reviews')
                ->limit($packagesLimit)
                ->pluck('Packages');

            $reviews = Review::whereIn('Packages', $topPackages)
                ->leftJoin('packages', 'reviews.Packages', '=', 'packages.Oid')
                ->leftJoin('users', 'reviews.CreateBy', '=', 'users.user_id')
                ->select(
                    'reviews.*',
                    'users.username',
                    'packages.name as PackageName'
                )
                ->orderBy('reviews.Packages')
                ->orderByDesc('reviews.CreatedAt')
                ->get()
                ->groupBy('PackageName')
                ->map(function ($group) use ($reviewsLimit) {
                    return $group->take($reviewsLimit);
                });

            return response()->json([
                'success' => true,
                'data' => $reviews,
            ]);
        } catch (\Exception $e) {
            dd($e);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Reviews.',
            ], 500);
        }
    }

    public function list(Request $request, $package)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $isSelectAll = $perPage == '-1';

            $query = review::where('Packages', $package)
                ->leftJoin('packages', 'reviews.Packages', '=', 'packages.Oid')
                ->leftJoin('users', 'reviews.CreateBy', '=', 'users.user_id')
                ->select('reviews.*', 'users.username', 'packages.name as PackageName');

            $result = $isSelectAll ? $query->get() : $query->paginate($perPage);
            $collection = $isSelectAll ? $result : $result->getCollection();

            return response()->json([
                'success' => true,
                'data' => $collection,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Reviews.',
            ], 500);
        }
    }

    public function show(Request $request, $Oid)
    {
        try {
            $data = review::findOrFail($Oid)
                ->leftJoin('packages', 'reviews.Packages', '=', 'packages.Oid')
                ->leftJoin('users', 'reviews.CreateBy', '=', 'users.user_id')
                ->select('reviews.*', 'users.username', 'packages.name as PackageName')->get();

            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Reviews.',
            ], 500);
        }
    }

    public function canReview(Request $request, $packageId)
    {
        try {
            $userId = Auth::user()['user_id'];

            // Check if the user has booked this package
            $hasBooked = TravelTransaction::where('Packages', $packageId)
                ->where('CreateBy', $userId)
                ->exists();

            return response()->json([
                'success' => true,
                'canReview' => $hasBooked,
                'message' => $hasBooked ? 'User can review this package' : 'User must book this package before reviewing',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check review eligibility.',
            ], 500);
        }
    }

    public function save(Request $request, $Oid = null)
    {
        try {
            // Get the package ID from the request
            $packageId = $request->input('Packages');
            $userId = Auth::user()['user_id'];

            // Check if the user has booked this package
            $hasBooked = TravelTransaction::where('Packages', $packageId)
                ->where('CreateBy', $userId)
                ->exists();

            if (! $hasBooked) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only review packages that you have booked.',
                ], 403);
            }

            DB::transaction(function () use ($Oid, $request, &$data) {
                $payload = $request->all();
                $payload['CreateBy'] = Auth::user()['user_id'];
                $data = $this->crudController->save($payload, 'review', $Oid);
            });

            return response()->json([
                'success' => true,
                'message' => 'Review is successfully saved',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save Review.',
            ], 500);
        }
    }
}
