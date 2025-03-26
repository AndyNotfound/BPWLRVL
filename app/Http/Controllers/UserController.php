<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Spatie\Permission\Exceptions\RoleDoesNotExist;

class UserController extends Controller
{
    use ValidatesRequests;

    private function checkUniqueFields(Request $request, User $user, array $fields)
    {
        foreach ($fields as $field) {
            if ($request->filled($field)) {
                $exists = User::where($field, $request->$field)
                    ->where('user_id', '!=', $user->user_id)
                    ->exists();

                if ($exists) {
                    return response()->json(["error" => "The $field has already been taken."], 422)->throwResponse();
                }
            }
        }
    }
    public function update(Request $request)
    {
        $user = $request->user();

        $this->checkUniqueFields($request, $user, ['username', 'email', 'phone_number']);

        if ($request->filled('role')) {
            try {
                $role = Role::findByName(Str::lower($request->role), 'web');
                $user->syncRoles([$role]);
            } catch (RoleDoesNotExist $e) {
                return response()->json(['error' => 'Failed to assign role.'], 422);
            }
        }

        $user->update($request->except('role'));

        return response()->json([
            'message' => 'User updated successfully',
            'user' => [
                'id' => $user->user_id,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'username' => $user->username,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'is_active' => $user->is_active,
                'roles' => $user->getRoleNames(),
            ],
        ]);
    }

    public function destroy(Request $request) {
        $user = $request->user();
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function toggleUserAccountStatus (Request $request) {
        $user = $request->user();
        if($user->is_active) {
            $user->update(['is_active' => false]);
            return response()->json(['message' => 'User deactivated successfully']);
        } else {
            $user->update(['is_active' => true]);
            return response()->json(['message' => 'User activated successfully']);
        }
    }
}
