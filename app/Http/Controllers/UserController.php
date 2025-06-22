<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UserController extends Controller
{
    use ValidatesRequests;

    public function show(Request $request, $Oid)
    {
        try {
            $data = User::findOrFail($Oid);
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function list(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 1);
            $isSelectAll = $perPage == "-1";

            // Paginate the users with their roles
            $query = User::with('roleObj');

            $result = $isSelectAll ? $query->get() : $query->paginate($perPage);
            $paginator = $isSelectAll ? $result : $result->getCollection();

            // Transform each item in the paginated collection
            $data = $paginator->map(function ($user) {
                return [
                    'user_id' => $user->user_id,
                    'role' => $user->role,
                    'role_name' => optional($user->roleObj)->name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'username' => $user->username,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'is_active' => $user->is_active,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $paginator
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve users.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


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

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function toggleUserAccountStatus(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $user->is_active = !$user->is_active;
        $user->save();
        $message = $user->is_active ? 'User activated successfully' : 'User deactivated successfully';

        return response()->json(['message' => $message]);
    }
}
