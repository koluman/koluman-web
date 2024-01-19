<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $userPhone = $request->user_phone;
            $user = User::where('user_phone', $userPhone)->first();
            if ($user) {
                Auth::guard('api')->login($user);
                $token = JWTAuth::fromUser($user);
                $u = JWTAuth::setToken($token)->authenticate();
                $responseData = [
                    "success" => 1,
                    "token" => $token,
                    'user' => $user,
                    "message" => "Login İşlemi başarılı",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "token" => "",
                    'user' => "",
                    "message" => "Login İşlemi başarısız",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "token" => "",
                'user' => "",
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }

    public function testsurus(Request $request)
    {
        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = JWTAuth::setToken($token)->authenticate();
        return response()->json(['user' => $user, 'success' => 'Başarılı'], 200);
    }
}
