<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
        public function test(Request $request)
        {
            $userPhone = $request->user_phone;
            $user = User::where('user_phone', $userPhone)->first();
    
            if ($user) {
                Auth::guard('api')->login($user);

                // Kullanıcıya dayalı olarak JWT token oluştur
                if (!$token = JWTAuth::attempt($userPhone)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            
                $user = JWTAuth::user();
            
                return $this->respondWithToken($token, $user);    
                // Oluşturulan token ile birlikte yanıtı döndür
            } else {
                $error = 'Giriş başarısız: ' . $userPhone;
                return response()->json(['error' => $error], 401);
            }
        }
    


    public function respondWithToken($token, $user)
    {
        $expiration = JWTAuth::factory()->getTTL() * 60;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration,
            'user' => $user,
        ]);
    }
}
