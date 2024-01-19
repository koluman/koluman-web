<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log; // Log tipini ekleyin
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtVerify
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Unauthorized. Token not provided.'], 401);
        }

        $token = str_replace('Bearer ', '', $token);

        try {
            $user = JWTAuth::setToken($token)->authenticate();
            return $next($request);
        } catch (\Exception $e) {
            // Token geçerli değilse
            return response()->json(['error' => 'Unauthorized. Invalid token.'], 401);
        }
    }
}
