<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class TestController extends Controller
{
    public function index()
    {   
        $users = User::all();
        return response()->json(['message' => 'List of resources', 'data' => $users]);
    }
}