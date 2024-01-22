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
        $error = null;
    
        if (!$token) {
            $error = ['success' => 401, 'messages' => 'Geçersiz. Token bulunamadı.'];
        } else {
            // Token tipini kontrol et
            if ($this->isBearerToken($token)) {
                // Bearer token için işlemler
                try {
                    $token = $this->extractToken($token);
                    $user = JWTAuth::setToken($token)->authenticate();
    
                    if (!$user) {
                        $error = ['success' => 401, 'messages' => 'Geçersiz. Bearer Auth kimlik doğrulama yapılamadı.'];
                    }
                } catch (\Exception $e) {
                    $error = ['success' => 401, 'messages' => $e->getMessage()];
                }
            } elseif ($this->isBasicAuthToken($token)) {
                // Basic Auth token için işlemler
                $credentials = $this->extractBasicCredentials($token);
                if (!$this->authenticateBasicToken($credentials['username'], $credentials['password'])) {
                    $error = ['success' => 401, 'messages' => 'Geçersiz. Basic Auth kimlik doğrulama yapılamadı.'];
                }
            } else {
                // Diğer durumlar için gerekli işlemleri ekleyebilirsiniz.
                $error = ['success' => 401, 'messages' => 'Geçersiz. Token tipi yanlış.'];
            }
        }
    
        if ($error) {
            return response()->json($error);
        }
    
        // Hata yoksa devam et
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
        // Gerçek uygulamanızda bu adımları uygun bir şekilde gerçekleştirin
        return $username === 'koluman' && $password === 'koluman2024';
    }
}
