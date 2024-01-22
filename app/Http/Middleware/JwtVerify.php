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
    }*/
    public function handle($request, Closure $next)
    {


        try {
            $token = $request->header('Authorization');
            Log::info('Received Token: ' . $token);

            if (!$token) {
                $errorData = [
                    "success" => 401,
                    "message" => "Token bilgisi bulunamadı!!",
                ];
                $request->attributes->add(['errorData' => $errorData]);
                return $next($request);
            }
            // Token türünü kontrol et ve uygun işlemi yap
            if ($this->isBearerToken($token)) {
                // Bearer token için işlemler
                $token = $this->extractToken($token);
                $user = JWTAuth::setToken($token)->authenticate();
            } elseif ($this->isBasicAuthToken($token)) {
                // Basic Auth token için işlemler
                $credentials = $this->extractBasicCredentials($token);
                if (!$this->authenticateBasicToken($credentials['username'], $credentials['password'])) {
                    return response()->json(['error' => 'Unauthorized. Invalid Basic Auth credentials.'], 401);
                }
            } else {
                // Diğer durumlar için gerekli işlemleri ekleyebilirsiniz.
                return response()->json(['error' => 'Unauthorized. Invalid token type.'], 401);
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized. Invalid token.'], 401);
        }
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
