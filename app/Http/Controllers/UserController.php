<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getapiusers(Request $request)
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
}
