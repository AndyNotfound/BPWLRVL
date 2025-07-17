<?php

namespace App\Http\Controllers;

use App\Models\Itineraries;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

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
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
