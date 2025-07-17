<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ValidatesRequests;

    private function determineRole(Request $request)
    {
        // Method 1: Check payload for origin
        if ($request->has('origin')) {
            $origin = $request->input('origin');
            switch ($origin) {
                case 'admin':
                    return 1;
                case 'client':
                    return 3;
                default:
                    return 3;
            }
        }

        // Method 2: Check Origin header
        $origin = $request->header('Origin');

        if ($origin) {
            if (strpos($origin, 'admin.batampesonawisata.com') !== false) {
                return 1;
            } elseif (strpos($origin, 'client.batampesonawisata.com') !== false) {
                return 3;
            }
        }

        // Method 3: Check Referer header as fallback
        $referer = $request->header('Referer');
        if ($referer) {
            if (strpos($referer, 'admin.batampesonawisata.com') !== false) {
                return 1;
            } elseif (strpos($referer, 'client.batampesonawisata.com') !== false) {
                return 3;
            }
        }

        return 3;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone_number' => 'nullable|string|max:20|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'origin' => 'nullable|string|in:admin,client', // Optional origin validation
        ], [
            'email.unique' => 'The email has already been taken.',
            'phone_number.unique' => 'The phone number has already been registered.',
            'username.unique' => 'The username has already been taken.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $role = $this->determineRole($request);

            $user = User::create([
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'password' => Hash::make($request->password),
                'role' => $role,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'User registered successfully!',
                'user' => $user,
                'assigned_role' => $role,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Registration failed. Please try again.'], 500);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = $request->input('login');
        $password = $request->input('password');

        $user = User::where('email', $loginField)
            ->orWhere('username', $loginField)
            ->orWhere('phone_number', $loginField)
            ->first();

        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (! Hash::check($password, $user->password)) {
            return response()->json(['error' => 'Wrong Password'], 404);
        }

        // Check if account is active
        if (! $user->is_active) {
            return response()->json(['error' => 'Account deactivated. Please contact support.'], 403);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->user_id,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'username' => $user->username,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'is_active' => $user->is_active,
                'role' => $user->role,
                'roles' => $user->roleObj,
            ],
        ]);
    }

    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh(Request $request)
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            $user = JWTAuth::user();

            if (! $user) {
                return response()->json([
                    'error' => 'User not found',
                ], 404);
            }

            return response()->json([
                'token' => $newToken,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'roles' => $user->roleObj,
                ],
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not refresh token',
            ], 500);
        }
    }
}
