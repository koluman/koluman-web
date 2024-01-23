<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log; // Log tipini ekleyin
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str; // Str sınıfını ekleyin

class JwtVerify
{
    /*public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['messages' => 'Unauthorized. Token not provided.'], 401);
        }

        $token = str_replace('Bearer ', '', $token);

        try {
            $user = JWTAuth::setToken($token)->authenticate();
            return $next($request);
        } catch (\Exception $e) {
            // Token geçerli değilse
            return response()->json(['messages' => 'Unauthorized. Invalid token.'], 401);
        }
    }*/
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['success' => 401, 'messages' => 'Geçersiz. Token bulunamadı.']);
        }
    
        // Token tipini kontrol et
        if ($this->isBearerToken($token)) {
            // Bearer token için işlemler
            /*try {
                $token = $this->extractToken($token);
                $user = JWTAuth::setToken($token)->authenticate();
    
                if (!$user) {
                    return response()->json(['success' => 401, 'messages' => 'Geçersiz. Bearer Auth kimlik doğrulama yapılamadı.']);
                }
            } catch (\Exception $e) {
                return response()->json(['messages' => $e->getMessage()],401);
            }*/
            return response()->json(['success' => 401, 'messages' => $token]);

        }  else {
            // Diğer durumlar için gerekli işlemleri ekleyebilirsiniz.
            return response()->json(['success' => 401, 'messages' => 'Geçersiz. Token tipi yanlış.']);
        }
    
        return $next($request);
    }
    

    private function extractToken($token)
    {
        return str_replace('Bearer ', '', $token);
    }

    private function isBearerToken($token)
    {
        return Str::startsWith($token, 'Bearer ');
    }


}
