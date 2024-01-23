<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
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
        
            $user = null; // $user değişkenini önce tanımlayın
            
            // Token süresi dolmuşsa
            if (JWTAuth::check($token)) {
                $user = JWTAuth::setToken($token)->authenticate();
                $refreshToken = JWTAuth::fromUser($user, Carbon::now()->addSeconds(3600)->format('Y-m-d H:i:s'));
                $responseData = [
                    "success" => 1,
                    "message" => "Token süresi doldu, yeni token oluşturuldu",
                    "token" => $refreshToken,
                ];
            } else {
                // Token süresi dolmadıysa mevcut token'ı döndür
                $originalToken = JWTAuth::fromUser($user, Carbon::now()->addSeconds(120)->format('Y-m-d H:i:s'));
                $responseData = [
                    "success" => 1,
                    "message" => "Token süresi dolmadığı için mevcut token kullanıldı",
                    "token" => $originalToken,
                ];
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            // Token süresi dolduğunda TokenExpiredException yakalanır
            $user = JWTAuth::setToken($token)->authenticate();
            $refreshToken = JWTAuth::fromUser($user, Carbon::now()->addSeconds(3600)->format('Y-m-d H:i:s'));
            $responseData = [
                "success" => 1,
                "message" => "Token süresi doldu, yeni token oluşturuldu",
                "token" => $refreshToken,
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
        
        
        return response()->json($responseData);
        
    }
}
