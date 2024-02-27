<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BackUsersController extends Controller
{
    public function getallusers(Request $request)
    {
        try {
            $usersall = BackUser::orderBy('id', 'desc')->get();
            if ($usersall->isEmpty()) {
                $responseData = [
                    "usersall" => "",
                    "success" => 0,
                    "message" => "Kullanıcı bilgileri bulunamadı",
                ];
            } else {
                $responseData = [
                    "usersall" => $usersall,
                    "success" => 1,
                    "message" => "Kullanıcı bilgileri getirildi",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "usersall" => "",
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
    public function adduser(Request $request)
    {
        try {
            $user_name = $request->userName;
            $user_phone = $request->userPhone;
            $user_role = $request->userRole;
            $user_mail = $request->userMail;
            $user_id = 'koluman_' . round(microtime(true) * 1000) . '_' . rand(100000, 999999);
            $existingUser = BackUser::where('backuser_phone', $user_phone)->first();
            if ($existingUser) {
                $responseData = [
                    "success" => 0,
                    "message" => "Bu kullanıcı daha önce kayıt edilmiş!",
                ];
            } else {
                $user = BackUser::create([
                    'backuser_id' => $user_id,
                    'backuser_name' => $user_name,
                    'backuser_phone' => $user_phone,
                    'backuser_role' => $user_role,
                    'backuser_password' => Hash::make(mt_rand(100000, 999999)),
                    'backuser_register_date' => Carbon::now('Europe/Istanbul'),
                    'backuser_mail' => $user_mail,
                ]);
                if ($user) {
                    $responseData = [
                        "success" => 1,
                        "message" => "Kullanıcı başarılı bir şekilde kayıt edilmiştir.",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Kullanıcı eklenemedi lütfen tekrar deneyiniz.",
                    ];
                }
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
    public function updateuser(Request $request)
    {
        try {
            $user_name = $request->userName;
            $user_phone = $request->userPhone;
            $user_role = $request->userRole;
            $user_mail = $request->userMail;
            $user_id = $request->userId;
            $existingUser = BackUser::where('backuser_phone', $user_phone)->first();
            if (!$existingUser) {
                $responseData = [
                    "success" => 1,
                    "message" => "Kullanıcı bulunamadı,lütfen tekrar deneyiniz",
                ];
            } else {
                $affectedRows = BackUser::where('backuser_id', $user_id)
                    ->update([
                        'backuser_name' => $user_name,
                        'backuser_phone' => $user_phone,
                        'backuser_role' => $user_role,
                        'backuser_mail' => $user_mail
                    ]);
                if ($affectedRows) {
                    $responseData = [
                        "success" => 1,
                        "message" => "Kullanıcı başarılı bir şekilde güncellenmiştir.",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Kullanıcı güncellenmedi lütfen tekrar deneyiniz.",
                    ];
                }
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
    public function deleteuser(Request $request)
    {
        try {
            $user_id = $request->userId;
            $existingUser = BackUser::where([
                'backuser_id' => $user_id,
            ])->first();
            if ($existingUser) {
                BackUser::where('backuser_id', $user_id)->delete();
                $responseData = [
                    "success" => 1,
                    "message" => "Kullanıcı başarılı bir şekilde silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Kullanıcı silinemedi lütfen tekrar deneyiniz",
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
    public function deleteusers(Request $request)
    {
        try {
            $user_ids = $request->userIds;
            $deleteusers = BackUser::whereIn('backuser_id', $user_ids)->delete();
            if ($deleteusers) {
                $responseData = [
                    "success" => 1,
                    "message" => "Kullanıcılar başarılı bir şekilde silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Kullanıcılar silinemedi lütfen tekrar deneyiniz",
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
