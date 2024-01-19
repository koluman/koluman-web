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

    public function testdriveadd(Request $request)
    {
        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $user = JWTAuth::setToken($token)->authenticate();
        try {
            if ($user) {
                
                $car_id=$request->car_id;
                $drive_time=$request->drive_time;
                $user_id=$user->user_id;

                $affectedRows = TestDrive::insert([
                    'user_id' => $user_id,
                    'car_id' => $car_id,
                    'drive_time'=>$drive_time,
                    'auto_date' => Carbon::now('Europe/Istanbul')
                ]);
                if ($affectedRows > 0) {
                    $responseData = [
                        "success" => 1,
                        "message" => "Test sürüş randevusu oluşturuldu",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Test sürüş randevusu oluşturulamadı , lütfen tekrar deneyiniz",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Kullanıcı bilgisi gelmedi, lütfen tokenı yollayınız",
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
