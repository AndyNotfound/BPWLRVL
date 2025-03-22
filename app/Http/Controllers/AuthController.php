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

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('client');

        $token = JWTAuth::fromUser($user);

        $roles = $user->getRoleNames();

        return response()->json(
            [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $roles,
                ],
            ], 
            201
        );
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(
                    [
                        'error' => 'Unauthorized'
                    ], 
                    401
                );
            }

            $user = JWTAuth::user();

            $roles = $user->getRoleNames();

            return response()->json(
                [
                    'token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'roles' => $roles
                    ],
                ]
            );
        } catch (JWTException $e) {
            return response()->json(
                [
                    'error' => 'Could not create token'
                ], 
                500
            );
        }
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(
            [
                'message' => 'Successfully logged out'
            ]
        );
    }

    public function refresh(Request $request)
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            $user = JWTAuth::user();

            if (!$user) {
                return response()->json(
                    [
                        'error' => 'User not found'
                    ], 
                    404
                );
            }

            $roles = $user->getRoleNames();
            return response()->json(
                [
                    'token' => $newToken,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'roles' => $roles
                    ]
                ]
            );
        } catch (JWTException $e) {
            return response()->json(
                [
                    'error' => 'Could not refresh token'
                ], 
                500
            );
        }
    }
}
