<?php

namespace App\Http\Controllers;

use App\Models\Itineraries;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItinerariesController extends Controller
{
    use ValidatesRequests;

    private $crudController;

    public function __construct()
    {
        $this->crudController = new globalCRUDController;
    }

    public function list(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 10);
            $isSelectAll = $perPage == '-1';

            $result = $isSelectAll ? Itineraries::get() : Itineraries::paginate($perPage);
            $collection = $isSelectAll ? $result : $result->getCollection();

            return response()->json([
                'success' => true,
                'data' => $collection,
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
                'data' => $Itineraries,
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
                if (! isset($payload['Code'])) {
                    $payload['Code'] = 'IT - '.Str::random(8);
                }
                $data = $this->crudController->save($payload, 'Itineraries', $Oid);
            });

            return response()->json([
                'success' => true,
                'message' => 'Itineraries is successfully saved',
                'data' => $data,
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
                $package = Itineraries::findOrFail($Oid);
                $package->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Itinerary is successfully deleted',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete itinerary',
            ], 500);
        }
    }
}
