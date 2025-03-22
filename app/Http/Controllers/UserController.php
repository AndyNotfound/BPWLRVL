<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function assignRoleToUser(Request $request, $userId)
    {
        // Validate the incoming request
        $request->validate([
            'role_name' => 'required|string|exists:roles,name', // Ensure the role exists
        ]);

        // Find the user by ID
        $user = User::find($userId);

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Assign the role to the user
        $roleName = $request->input('role_name');
        $user->assignRole($roleName);

        // Return a success response
        return response()->json(['message' => "Role '{$roleName}' assigned to user successfully."]);
    }
}
