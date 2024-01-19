<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            // Gelen token'ı al
            $token = JWTAuth::getToken();

            // Token geçerli mi kontrol et
            $user = JWTAuth::setToken($token)->authenticate();

            if (!$user) {
                // Geçerli bir kullanıcı yoksa, 401 hatası döndür
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Diğer kontrolleri yapabilirsiniz...

            return $next($request);
        } catch (\Exception $e) {
            // İstisna durumları için
            return response()->json(['error' => $e->getMessage()], 500);
        }
    
    }
    
  
}
