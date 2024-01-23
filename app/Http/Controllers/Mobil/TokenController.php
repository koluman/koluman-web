<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenController extends Controller
{
    public function refresh(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            if (JWTAuth::check($token)) {
                // Token süresi dolmadıysa mevcut token'ı döndür
                $responseData = [
                    "success" => 1,
                    "message" => "Token süresi dolmadığı için mevcut token kullanıldı",
                    "token" => $token,
                ];
            } else {
                // Token süresi dolmuşsa, mevcut kullanıcıyı al ve yeni token oluştur
                $user = JWTAuth::setToken($token)->authenticate();
                $newToken = JWTAuth::fromUser($user);
                $responseData = [
                    "success" => 1,
                    "message" => "Token süresi doldu, yeni token oluşturuldu",
                    "token" => $newToken,
                ];
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            // Token süresi dolduğunda TokenExpiredException yakalanır
            $user = JWTAuth::setToken($token)->authenticate();
            $newToken = JWTAuth::fromUser($user);
            $responseData = [
                "success" => 1,
                "message" => "Token süresi doldu, yeni token oluşturuldu",
                "token" => $newToken,
            ];
        } catch (\Exception $e) {
            // Diğer hataları kontrol et
            $responseData = [
                "success" => 0,
                "token" => [
                    "value" => "",
                    "expires_in" => 0,
                ],
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
}
