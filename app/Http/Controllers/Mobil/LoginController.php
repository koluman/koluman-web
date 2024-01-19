<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
   
        public function test(Request $request)
        {
            $credentials = $request->only('user_phone', 'user_password');
    
            if (Auth::guard('api')->attempt($credentials)) {
                // Başarılı giriş
                $user = Auth::guard('api')->user();
                return response()->json(['success' => 'Giriş başarılı'], 200);
            } else {
                $error = 'Giriş başarısız: ' . $credentials['user_phone'];
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
