<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\TestDrive;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function userlogin(Request $request)
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
                    'user' => $u,
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
    public function userlogout()
    {
        try {
            $token = JWTAuth::getToken();
            if ($token) {
                JWTAuth::invalidate($token);
                Auth::guard('api')->logout();
                $responseData = [
                    "success" => 1,
                    "message" => "Logout İşlemi başarılı",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Token bulunamadı, Logout işlemi başarısız",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }

        return response()->json($responseData);
    }
}
