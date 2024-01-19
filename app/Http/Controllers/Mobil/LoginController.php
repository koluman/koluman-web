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
            $u = JWTAuth::setToken($token)->authenticate();
            return response()->json(['token' => $token, 'user' => $user,'u'=>$u, 'success' => 'Giriş başarılı'], 200);
        } else {
            $error = 'Giriş başarısız: ' . $userPhone;
            return response()->json(['error' => $error], 401);
        }
    }

    public function testsurus(Request $request)
    {
        $token = $request->token;
        $u = JWTAuth::setToken($token)->authenticate();
        return response()->json(['u'=>$u, 'success' => 'başarılı'], 200);
    }
}
