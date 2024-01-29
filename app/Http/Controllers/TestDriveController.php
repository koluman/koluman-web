<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestDriveDeleteRequest;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestDriveController extends Controller
{
    public function testdrivegetall(Request $request)
    {
        try {
            $testDrives = Appointment::join('users', 'appointment.user_id', '=', 'users.user_id')
                ->join('showroom', 'appointment.car_id', '=', 'showroom.car_id')
                ->get(['appointment.*', 'users.user_name', 'users.user_phone', 'showroom.car_name']);

            $lastWeek = Carbon::now()->subWeek(); // Şu anki tarihten bir hafta önceki tarih
            $testlastDrives = Appointment::where('appointment_date', '>=', $lastWeek)
                ->orderBy('appointment_date', 'desc')
                ->get();

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
    public function deletetestdriveappointment(TestDriveDeleteRequest $request)
    {
        try {
            $appointment_id = $request->appointment_id;
            $testDrive = Appointment::where('appointment_id', $appointment_id)->first();
            if ($testDrive) {
                $testDrive->delete();
                $responseData = [
                    "success" => 1,
                    "message" => "Test sürüşü başarıyla silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Silmek istediğiniz randevu size ait değil!",
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
