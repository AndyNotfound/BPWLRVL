<?php

namespace App\Http\Controllers;

use App\Models\Itineraries;
use App\Models\Role;
use App\Models\User;
use App\Models\Packages;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItinerariesController extends Controller
{
    use ValidatesRequests;

    private $crudController;

    public function __construct()
    {
        $this->crudController = new globalCRUDController();
    }

    public function list(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $Itineraries = Itineraries::paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $Itineraries
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Itineraries.',
            ], 500);
        }
    }

    public function show(Request $request, $Oid)
    {
        try {
            $Itineraries = Itineraries::findOrFail($Oid);

            return response()->json([
                'success' => true,
                'data' => $Itineraries
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Itineraries.',
            ], 500);
        }
    }

    public function save(Request $request, $Oid = null)
    {
        try {
            DB::transaction(function () use ($Oid, $request, &$data) {
                $payload = $request->all();
                $payload['CreateBy'] = Auth::user()['user_id'];
                $payload['Role'] = Auth::user()['role'];
                $payload['CreateBy'] = Auth::user()['user_id'];
                if (!isset($payload['Code'])) $payload['Code'] = "IT - " . Str::random(8);
                $data = $this->crudController->save($payload, "Itineraries", $Oid);
            });

            return response()->json([
                'success' => true,
                'message' => "Itineraries is successfully saved",
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
}
