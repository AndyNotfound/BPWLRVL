<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role, $guard = null)
    {
        $authGuard = Auth::guard($guard);
        $user = $authGuard->user();

        if (! $user) {
            return Response::json([
                'success' => false,
                'message' => 'Unauthorized. Authentication required.',
                'error' => 'You need to login first!',
            ], 401);
        }

        if (! method_exists($user, 'hasAnyRole')) {
            return Response::json([
                'success' => false,
                'message' => 'Server configuration error',
                'error' => 'Method hasAnyRole does not exist on user model',
            ], 500);
        }

        // Parse roles - handle comma-separated or pipe-separated roles
        $allowedRoles = $this->parseRoles($role);

        // Check if user has any of the required roles
        // Try to determine what the second parameter should be
        if (! $this->checkUserRoles($user, $allowedRoles)) {
            return Response::json([
                'success' => false,
                'message' => 'Forbidden. Insufficient permissions.',
                'error' => 'You do not have the required role to access this resource',
            ], 403);
        }

        return $next($request);
    }

    /**
     * Check if user has any of the required roles
     */
    protected function checkUserRoles($user, $allowedRoles)
    {
        // Get the user's role name
        $userRole = $user->roleObj ? $user->roleObj->name : null;

        // Check if user's role is in the allowed roles
        return in_array($userRole, $allowedRoles);
    }

    /**
     * Parse roles from string to array
     */
    protected function parseRoles($role)
    {
        if (is_array($role)) {
            return $role;
        }

        // Handle both comma-separated and pipe-separated roles
        if (strpos($role, ',') !== false) {
            return array_map('trim', explode(',', $role));
        }

        if (strpos($role, '|') !== false) {
            return array_map('trim', explode('|', $role));
        }

        return [$role];
    }

    /**
     * Specify the role and guard for the middleware.
     *
     * @param  array|string|\BackedEnum  $role
     * @param  string|null  $guard
     * @return string
     */
    public static function using($role, $guard = null)
    {
        $roleString = self::parseRolesToString($role);

        $args = is_null($guard) ? $roleString : "$roleString,$guard";

        return static::class.':'.$args;
    }

    /**
     * Convert array or string of roles to string representation.
     *
     * @return string
     */
    protected static function parseRolesToString(array|string|\BackedEnum $role)
    {
        // Convert Enum to its value if an Enum is passed
        if ($role instanceof \BackedEnum) {
            $role = $role->value;
        }

        if (is_array($role)) {
            $role = array_map(fn ($r) => $r instanceof \BackedEnum ? $r->value : $r, $role);

            return implode('|', $role);
        }

        return (string) $role;
    }
}
