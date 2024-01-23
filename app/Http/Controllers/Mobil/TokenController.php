<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenController extends Controller
{
    /*public function refresh(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            if ($token) {
                $u = JWTAuth::setToken($token)->authenticate();
                $user = User::where('user_id', $u->user_id)->first();
                $originalToken = JWTAuth::fromUser($user);
                $responseData = [
                    "success" => 1,
                    "token" => [
                        "value" => $originalToken,
                        "expires_in" => Auth::factory()->getTTL() * 60,
                    ],
                    "message" => "Refresh token oluşturuldu",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "token" => [
                        "value" => "",
                        "expires_in" => 0,
                    ],
                    "message" => "Token bilgisi gelmedi, lütfen tokenı yollayınız",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "token" => [
                    "value" => "",
                    "expires_in" => 0,
                ],
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($token);
    }*/

    public function refresh(Request $request)
    {
        // Kullanıcının refresh token'ını al
        $refreshToken = $request->input('refresh_token');

        if ($refreshToken) {
            try {
                // Refresh token'ın süresini kontrol et
                $payload = JWTAuth::setToken($refreshToken)->getPayload();
                $expiresAt = $payload['exp'];

                // Eğer refresh token'ın süresi geçmişse veya hala geçerli değilse
                if (time() >= $expiresAt) {
                    return response()->json(['error' => 'Refresh token has expired'], 401);
                }

                // Refresh token kullanılarak yeni bir token oluşturuluyor
                $newToken = JWTAuth::setToken($refreshToken)->refresh();

                // Yeni token kullanıcıya veriliyor
                return response()->json(['token' => $newToken, 'expires_in' => Auth::factory()->getTTL() * 60]);
            } catch (\Exception $e) {
                // Refresh token geçersizse veya hata oluşursa
                return response()->json(['error' => 'Invalid refresh token'], 401);
            }
        } else {
            return response()->json(['error' => 'Refresh token not provided'], 400);
        }
    }
}
