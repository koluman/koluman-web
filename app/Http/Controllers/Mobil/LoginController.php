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
            $token = JWTAuth::fromUser($user);
            return response()->json(['token' => $token, 'user' => $user, 'success' => 'Giriş başarılı'], 200);
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
