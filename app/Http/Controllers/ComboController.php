<?php

namespace App\Http\Controllers;

use App\Models\Itineraries;
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

class ComboController extends Controller
{
    use ValidatesRequests;

    public function itineraries(Request $request)
    {
        try {
            $data = Itineraries::select('Oid', 'Name')->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create cart.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
