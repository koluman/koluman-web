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
                    $errorData = [
                        "success" => 401,
                        "message" => "Geçersiz Temel Kimlik Doğrulama kimlik bilgileri.",
                    ];
                    $request->attributes->add(['errorData' => $errorData]);
                    return $next($request);
                }
            } else {
                // Eğer Basic Authentication tipinde bir token geldiyse burada uygun bir işlem yapabilirsiniz
                // Örneğin, bir hata mesajı dönebilir veya uygun bir HTTP durum koduyla yanıt verebilirsiniz
                $errorData = [
                    "success" => 401,
                    "message" => "Geçersiz token tipi!!",
                ];
                $request->attributes->add(['errorData' => $errorData]);
                return $next($request);
            }

            return $next($request);
        } catch (\Exception $e) {
            $errorData = [
                "success" => 401,
                "message" => $e->getMessage(),
            ];
            $request->attributes->add(['errorData' => $errorData]);
            return $next($request);        }
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
