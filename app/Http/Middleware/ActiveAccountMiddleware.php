<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ActiveAccountMiddleware
{
    /**
     * Handle an incoming request.
     * Only checks if user is active when they are authenticated.
     * If not authenticated, proceeds normally.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Try to get the authenticated user from JWT token
            $user = JWTAuth::parseToken()->authenticate();

            // If user is authenticated, check if account is active
            if ($user && ! $user->is_active) {
                return response()->json([
                    'message' => 'Account deactivated.',
                    'error' => 'ACCOUNT_DEACTIVATED',
                ], Response::HTTP_FORBIDDEN);
            }
        } catch (JWTException $e) {
            // No valid token found - this is fine for optional auth
            // Just proceed to the next middleware/controller
        }

        return $next($request);
    }
}
