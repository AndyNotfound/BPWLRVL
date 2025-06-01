<?php

namespace App\Http\Controllers;

use App\Models\review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    private $crudController;

    public function __construct()
    {
        $this->crudController = new globalCRUDController();
    }

    public function list(Request $request, $package)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $data = review::where('Packages', $package)
                ->leftJoin('packages', 'reviews.Packages', '=', 'packages.Oid')
                ->leftJoin('users', 'reviews.CreateBy', '=', 'users.user_id')
                ->select('reviews.*', 'users.username', 'packages.name as PackageName')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $data
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
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Reviews.',
            ], 500);
        }
    }

    public function save(Request $request, $Oid = null)
    {
        try {
            DB::transaction(function () use ($Oid, $request, &$data) {
                $payload = $request->all();
                $payload['CreateBy'] = Auth::user()['user_id'];
                $data = $this->crudController->save($payload, "review", $Oid);
            });

            return response()->json([
                'success' => true,
                'message' => "Review is successfully saved",
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to saved Review.',
            ], 500);
        }
    }
}
