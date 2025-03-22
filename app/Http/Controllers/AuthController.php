<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Foundation\Validation\ValidatesRequests;


class AuthController extends Controller
{
    use ValidatesRequests;
    public function login(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Get the credentials
        $credentials = $request->only('email', 'password');

        try {
            // Attempt to verify the credentials and create a token
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // Something went wrong while attempting to encode the token
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // If successful, return the token
        return response()->json(compact('token'));
    }
}