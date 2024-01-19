<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{

    public function test(Request $request)
    {
        $userPhone = $request->user_phone;
        $user = User::where('user_phone', $userPhone)->first();
        if ($user) {
            Auth::guard('api')->login($user);
            $token = JWTAuth::fromUser($user);
            return response()->json(['token' => $token, 'user' => $user, 'success' => 'Giriş başarılı'], 200);
        } else {
            $error = 'Giriş başarısız: ' . $userPhone;
            return response()->json(['error' => $error], 401);
        }
    }

    public function decodeToken(Request $request)
    {
        $token = $request->header('Authorization');

        try {
            // Token'ı çöz
            $decodedToken = JWTAuth::setToken($token)->getPayload();
    
            // Token'ın doğruluğunu kontrol et
            $isValid = JWTAuth::checkOrFail();
    
            // Payload'dan user_id'yi al
            $userId = $decodedToken->get('user_id');
    
            return response()->json(['user_id' => $userId], 200);
        } catch (\Exception $e) {
            // Hata durumunda
            return response()->json(['error' => 'Geçersiz token: ' . $e->getMessage()], 401);
        }
    }
}
