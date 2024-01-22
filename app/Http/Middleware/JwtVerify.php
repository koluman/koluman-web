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
            if (!$token) {
                $errorData = [
                    "status" => 401,
                    "message" => "Unauthorized. Token not provided.",
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
                    $errorData = [
                        "status" => 401,
                        "message" => "Unauthorized. Invalid Basic Auth credentials.",
                    ];
                    $request->attributes->add(['errorData' => $errorData]);
                    return $next($request);
                }
            } else {

                $errorData = [
                    "status" => 401,
                    "message" => "Unauthorized. Invalid token type.",
                ];
                $request->attributes->add(['errorData' => $errorData]);
                return $next($request);
            }

        } catch (\Exception $e) {
            $errorData = [
                "status" => 401,
                "message" => "Unauthorized. Invalid token.",
            ];
            $request->attributes->add(['errorData' => $errorData]);
            return $next($request);
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
