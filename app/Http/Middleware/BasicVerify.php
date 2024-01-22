<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log; // Log tipini ekleyin
use Illuminate\Support\Str; // Str sınıfını ekleyin

class BasicVerify
{
   
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['success' => 401, 'messages' => 'Geçersiz. Token bulunamadı.']);
        }
    
        // Token tipini kontrol et
        if ($this->isBasicAuthToken($token)) {
            // Basic Auth token için işlemler
            $credentials = $this->extractBasicCredentials($token);
            if (!$this->authenticateBasicToken($credentials['username'], $credentials['password'])) {
                return response()->json(['success' => 401, 'messages' => 'Geçersiz. Basic Auth kimlik doğrulama yapılamadı.']);
            }
        } else {
            // Diğer durumlar için gerekli işlemleri ekleyebilirsiniz.
            return response()->json(['success' => 401, 'messages' => 'Geçersiz. Token tipi yanlış.']);
        }
    
        return $next($request);
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
