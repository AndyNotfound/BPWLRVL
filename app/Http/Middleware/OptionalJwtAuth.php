<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class OptionalJwtAuth
{
    public function handle($request, Closure $next)
    {
        try {
            // If token exists, try to parse and authenticate it
            if ($request->bearerToken()) {
                JWTAuth::parseToken()->authenticate();
            }
        } catch (\Exception $e) {
            // Silently ignore invalid or expired token — proceed as guest
        }

        return $next($request);
    }
}
