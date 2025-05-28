<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Packages;
use App\Models\TravelTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelTransactionController extends Controller
{
    use ValidatesRequests;

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

    public function show(Request $request, $Oid)
    {
        try {
            $travelTransaction = TravelTransaction::with('details')->findOrFail($Oid);

            return response()->json([$travelTransaction]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Travel Transaction Not Found',
            ], 500);
        }
    }

    public function save(Request $request, $Oid)
    {
        try {
            DB::transaction(function () use ($Oid, $request, &$data) {});
            return response()->json([$data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed To Save/Update Travel Transaction',
            ], 500);
        }
    }
}
