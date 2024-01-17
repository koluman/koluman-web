<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function getallusers(Request $request)
    {
        try {
            $usersall = User::orderBy('id', 'desc')->get();

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

            $user = User::create([
                'user_id' => $user_id,
                'user_name' => $user_name,
                'user_phone' => $user_phone,
                'user_role' => $user_role,
                'user_password' => Hash::make(mt_rand(100000, 999999)),
                'user_register_date' => Carbon::now('Europe/Istanbul'),
                'user_mail' => $user_mail,
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
            $affectedRows = User::where('user_id', $user_id)
                ->update([
                    'user_name' => $user_name,
                    'user_phone' => $user_phone,
                    'user_role' => $user_role,
                    'user_mail' => $user_mail
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
            $existingUser = User::where([
                'user_id' => $user_id,
            ])->first();
            if ($existingUser) {
                User::where('user_id', $user_id)->delete();
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

            $deleteusers = User::whereIn('user_id', $user_ids)->delete();
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
