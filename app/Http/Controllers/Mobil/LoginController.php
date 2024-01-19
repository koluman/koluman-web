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
        return response(JWTAuth::setToken($token)->authenticate());

        /*try {
            $user = JWTAuth::setToken($token)->authenticate();
            return response()->json(['user_id' => $user->user_id], 200);
        } catch (\Exception $e) {
            // Hatanın detayını loglamak için
            Log::error('Token çözme hatası: ' . $e->getMessage());
            // Hata mesajını ekrana yazdırmak için
            return response()->json(['error' => 'Geçersiz token: ' . $e->getMessage()], 401);
        }*/
    }
}
