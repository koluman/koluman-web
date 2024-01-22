<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\TestDrive;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function userlogin(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Basic ', '', $token);

            if ($token) {
                $userPhone = $request->user_phone;
                $user = User::where('user_phone', $userPhone)->first();
                if ($user) {
                    Auth::guard('api')->login($user);
                    $token = JWTAuth::fromUser($user);
                    $u = JWTAuth::setToken($token)->authenticate();
                    $reftoken = JWTAuth::parseToken()->refresh();
                    $responseData = [
                        "success" => 1,
                        "token" => $token,
                        "refreshtoken" => $reftoken,
                        'user' => $u,
                        "message" => "Login İşlemi başarılı",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "token" => "",
                        "refreshtoken" => "",
                        'user' => "",
                        "message" => "Login İşlemi başarısız",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
                    "token" => "",
                    "refreshtoken" => "",
                    'user' => "",
                    "message" => "Token bilgisi gelmedi, lütfen tokenı yollayınız",
                ];
            }
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
            $responseData = [
                "success" => 0,
                "token" => "",
                "refreshtoken" => "",
                'user' => "",
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);

    }
    public function userlogout(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Basic ', '', $token);
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
    public function userregister(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Basic ', '', $token);
            if ($token) {
            $user_identity = $request->user_identity;
            $user_phone = $request->user_phone;
            $user_name = $request->user_name;

            $existingUser = User::where('user_phone', $user_phone)->first();
            if ($existingUser) {
                $responseData = [
                    "success" => 0,
                    "message" => "Bu kullanıcı daha önce kayıt edilmiş, lütfen giriş yapınız",
                    "user" => "",
                    "token" => "",
                    "refreshtoken" => "",
                ];
            } else {
                $user_id = 'koluman_' . round(microtime(true) * 1000) . '_' . rand(100000, 999999);
                $user = User::create([
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'user_phone' => $user_phone,
                    'user_identity' => $user_identity,
                    'user_register_date' => Carbon::now('Europe/Istanbul'),
                ]);
                $token = JWTAuth::fromUser($user);
                $u = JWTAuth::setToken($token)->authenticate();
                $reftoken = JWTAuth::parseToken()->refresh();
                $responseData = [
                    "success" => 1,
                    "message" => "Kullanıcı Kayıt edildi",
                    "user" => $user,
                    "token" => $token,
                    "refreshtoken" => $reftoken,
                ];
            }
        } else {
            $responseData = [
                "success" => 0,
                "message" => "Token bulunamadı, Logout işlemi başarısız",
                "user" => "",
                "token" => "",
                "refreshtoken" => ""
            ];
        }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "message" => $e->getMessage(),
                "user" => "",
                "token" => "",
                "refreshtoken" => ""
            ];
        }
        return response()->json($responseData);
    }
}
