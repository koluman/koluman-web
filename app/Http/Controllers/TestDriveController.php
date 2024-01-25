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
            $testDrives = TestDrive::join('users', 'test_drive.user_id', '=', 'users.user_id')
                ->join('showroom', 'test_drive.car_id', '=', 'showroom.car_id')
                ->get(['test_drive.*', 'users.user_name', 'users.user_phone', 'showroom.car_name']);

            $lastWeek = Carbon::now()->subWeek(); // Şu anki tarihten bir hafta önceki tarih
            $testlastDrives = TestDrive::where('auto_date', '>=', $lastWeek)->get();

            if (!$testDrives->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "testDrives" => $testDrives,
                    "testlastDrives" => $testlastDrives,
                    "message" => "Test sürüş randevu listesi getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "testDrives" => "",
                    "testlastDrives" => "",
                    "message" => "Test sürüş randevu listesi bulunamadı",
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
