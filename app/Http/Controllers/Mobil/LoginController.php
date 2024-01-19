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

        if (!$token = JWTAuth::attempt($credentials)) {
            // Giriş başarısız
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Başarılı giriş
        return response()->json(['success' => 'Giriş başarılı', 'token' => $token], 200);
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
