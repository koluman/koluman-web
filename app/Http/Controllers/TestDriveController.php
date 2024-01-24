<?php

namespace App\Http\Controllers;

use App\Models\TestDrive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TestDriveController extends Controller
{
    public function testdrivegetall(Request $request)
    {
        try {

            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            if ($token) {
                $u = JWTAuth::setToken($token)->authenticate();
                $testDrives = TestDrive::join('users', 'test_drives.user_id', '=', 'users.user_id')
                    ->get(['test_drives.*', 'users.name', 'users.email']);
                if (!$testDrives->isEmpty()) {
                    $responseData = [
                        "success" => 1,
                        "testDrives" => $testDrives,
                        "message" => "Test sürüş randevu listesi getirildi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "testDrives" => "",
                        "message" => "Test sürüş randevu listesi bulunamadı",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
                    "testDrives" => "",
                    "message" => "Token bilgisi gelmedi, lütfen tokenı yollayınız",
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
