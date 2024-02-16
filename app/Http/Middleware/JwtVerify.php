<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log; // Log tipini ekleyin
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str; // Str sınıfını ekleyin

class JwtVerify
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['success' => 401, 'messages' => 'Geçersiz. Token bulunamadı.']);
        }
    
        if ($this->isBearerToken($token)) {
            try {
                $token = $this->extractToken($token);
                $user = JWTAuth::setToken($token)->authenticate();
    
                if (!$user) {
                    return response()->json(['success' => 401, 'messages' => 'Geçersiz. Bearer Auth kimlik doğrulama yapılamadı.']);
                }
            } catch (\Exception $e) {
                return response()->json(['success' => 401,'messages' => $e->getMessage()],401);
            }
        }
        else if ($this->isBasicAuthToken($token)) {
            $credentials = $this->extractBasicCredentials($token);
            if (!$this->authenticateBasicToken($credentials['username'], $credentials['password'])) {
                return response()->json(['success' => 401, 'messages' => 'Geçersiz. Basic Auth kimlik doğrulama yapılamadı.']);
            }
        } else {
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

    private function isBasicAuthToken($token)
    {
        return Str::startsWith($token, 'Basic ');
    }

    private function extractBasicCredentials($token)
    {
        $tokenData = base64_decode(str_replace('Basic ', '', $token));
        list($username, $password) = explode(':', $tokenData);
        return compact('username', 'password');
    }

    private function authenticateBasicToken($username, $password)
    {
        return $username === 'koluman' && $password === 'koluman2024';
    }

}
