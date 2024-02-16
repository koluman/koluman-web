<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class LoginController extends Controller
{
    public function userlogin(LoginRequest $request)
    {
        try {
            $userPhone = $request->user_phone;
            $user = User::where('user_phone', $userPhone)->first();

            if ($user) {
                Auth::guard('api')->login($user);
                $accessToken = JWTAuth::fromUser($user);
                $expiresInSeconds = Auth::factory()->getTTL() * 60;
                $now = Carbon::now();
                $expirationDate = $now->addSeconds($expiresInSeconds);

                $responseData = [
                    "success" => 1,
                    "token" => [
                        "originaltoken" => $accessToken,
                        "expires_in" => $expiresInSeconds,
                        "expires_time" => $expirationDate->toDateTimeString()
                    ],
                    "user" => [
                        "user_id" => $user->user_id,
                        "user_mail" => $user->user_mail,
                        "user_name" => $user->user_name,
                        "user_phone" => $user->user_phone,
                        "user_image_url" => $user->user_image_url,
                    ],
                    "message" => "Login İşlemi başarılı",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "token" => [
                        "originaltoken" => "",
                        "expires_in" => 0,
                        "expires_time" => ""
                    ],
                    "user" => [
                        "user_id" => "",
                        "user_mail" => "",
                        "user_name" => "",
                        "user_phone" => "",
                        "user_image_url" => "",
                    ],
                    "message" => "Kullanıcı bilgisi bulunamadı",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "token" => [
                    "originaltoken" => "",
                    "expires_in" => 0,
                    "expires_time" => ""

                ],
                "user" => [
                    "user_id" => "",
                    "user_mail" => "",
                    "user_name" => "",
                    "user_phone" => "",
                    "user_image_url" => "",
                ],
                "message" => $e->getMessage(),
            ];
        }

        return response()->json($responseData);
    }

    public function userlogout(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                JWTAuth::invalidate($token);
                Auth::guard('api')->logout();
                User::where('user_id', $u->user_id)->update(['user_notification_token' => ""]);
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
    public function userregister(RegisterRequest $request)
    {
        try {


            $user_identity = $request->user_identity;
            $user_phone = $request->user_phone;
            $user_name = $request->user_name;

            $existingUser = User::where('user_phone', $user_phone)->first();
            if ($existingUser) {

                $responseData = [
                    "success" => 0,
                    "token" => [
                        "originaltoken" => "",
                        "expires_in" => 0,
                        "expires_time" => ""

                    ],
                    "user" => [
                        "user_id" => "",
                        "user_mail" => "",
                        "user_name" => "",
                        "user_phone" => "",
                        "user_image_url" => "",
                    ],
                    "message" => "Bu kullanıcı daha önce kayıt edilmiş, lütfen giriş yapınız",
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
                Auth::guard('api')->login($user);
                $accessToken = JWTAuth::fromUser($user_id);
                $expiresInSeconds = Auth::factory()->getTTL() * 60;
                $now = Carbon::now();
                $expirationDate = $now->addSeconds($expiresInSeconds);
                                $responseData = [
                    "success" => 1,
                    "token" => [
                        "originaltoken" => $accessToken,
                        "expires_in" => $expiresInSeconds,
                        "expires_time" => $expirationDate->toDateTimeString()
                    ],
                    "user" => [
                        "user_id" => $user->user_id,
                        "user_mail" => $user->user_mail,
                        "user_name" => $user->user_name,
                        "user_phone" => $user->user_phone,
                        "user_image_url" => $user->user_image_url,
                    ],
                    "message" => "Login İşlemi başarılı",
                ];
            }
        } catch (\Exception $e) {

            $responseData = [
                "success" => 0,
                "token" => [
                    "originaltoken" => "",
                    "expires_in" => 0,
                    "expires_time" => ""

                ],
                "user" => [
                    "user_id" => "",
                    "user_mail" => "",
                    "user_name" => "",
                    "user_phone" => "",
                    "user_image_url" => "",
                ],
                "message" =>  $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
    public function sendcode(Request $request)
    {
        try {
            $user_phone=$request->user_phone;
            if ($user_phone) {
                $responseData = [
                    "success" => 1,
                    "message" => "Doğrulama kodunuz telefon numaranıza gönderilmiştir.",
                    "timemilis" =>floor(microtime(true) * 1000),
                    "code"=>rand(111111, 999999)
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Sisteme ait öyle bir telefon numarası bulunamadı.",
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
