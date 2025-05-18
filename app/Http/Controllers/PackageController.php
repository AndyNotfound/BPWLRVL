<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackageController extends Controller
{
    use ValidatesRequests;

    public function list(Request $request) {
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

    public function favorites(Request $request) {
       try {
            $perPage = $request->input('per_page', 10);
            $packages = Packages::where('isFavorites', 1)->paginate($perPage);

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

    public function seasonal(Request $request) {
       try {
            $perPage = $request->input('per_page', 10);
            $packages = Packages::where('isSeasonal', 1)->paginate($perPage);

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

    public function custom(Request $request) {
       try {
            $perPage = $request->input('per_page', 10);
            $packages = Packages::where('isCustomItineraries', 1)->paginate($perPage);

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

    public function mustsee(Request $request) {
       try {
            $perPage = $request->input('per_page', 10);
            $packages = Packages::where('isMustSee', 1)->paginate($perPage);

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

    public function show(Request $request, $Oid) {
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

    public function delete(Request $request, $Oid) {
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
