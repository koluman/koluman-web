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
        $credentials = $request->only('user_phone');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = JWTAuth::user();

        return $this->respondWithToken($token, $user);
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
