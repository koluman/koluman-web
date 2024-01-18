<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log; // Log tipini ekleyin
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtVerify
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            Log::error('JWT Exception: ' . $e->getMessage()); // Log tipini doğru şekilde kullanın
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
