<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestDriveAddRequest;
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
                ->get(['appointment.*','users.*','showroom.*']);

            $lastWeek = Carbon::now()->subWeek(); // Şu anki tarihten bir hafta önceki tarih
            $currentDateTime = now(); // Şuanki tarih ve saat
            $lastWeek = now()->subWeek(); // Geçen haftanın başlangıcı
            $testlastDrives = Appointment::where('appointment_date', '>=', $lastWeek)
                ->where(function ($query) use ($currentDateTime) {
                    $query->where('appointment_date', '>', now()->toDateString()) // Bugünden sonraki randevular
                        ->orWhere(function ($query) use ($currentDateTime) {
                            $query->where('appointment_date', '=', now()->toDateString())
                                ->where('appointment_time', '>', now()->toTimeString()); // Bugünkü randevular, ancak şuanki saatinden sonraki saatte olanlar
                        });
                })
                ->orderBy('appointment_date', 'desc')
                ->join('users', 'appointment.user_id', '=', 'users.user_id')
                ->join('showroom', 'appointment.car_id', '=', 'showroom.car_id')
                ->get(['appointment.*', 'users.*', 'showroom.*']);

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

    public function addtestdriveappointment(TestDriveAddRequest $request)
    {
        try {
            $car_id = $request->car_id;
            $appointment_time = $request->appointment_time;
            $user_id = $request->user_id;
            $appointment_date = $request->appointment_date;

            $affectedRows = Appointment::insertGetId([
                'user_id' => $user_id,
                'car_id' => $car_id,
                'appointment_time' => $appointment_time,
                'state' => 0,
                'appointment_date' => $appointment_date
            ]);
            if ($affectedRows > 0) {
                $responseData = [
                    "sonuc" => $affectedRows,
                    "success" => 1,
                    "message" => "Test sürüş randevusu oluşturuldu",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Test sürüş randevusu oluşturulamadı , lütfen tekrar deneyiniz",
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
    public function updatetestdriveappointment(Request $request)
    {
        try {
            $car_id = $request->car_id;
            $appointment_time = $request->appointment_time;
            $user_id = $request->user_id;
            $appointment_date = $request->appointment_date;
            $appointment_id = $request->appointment_id;

            $affectedRows = Appointment::where('appointment_id', $appointment_id)
            ->update([
                'user_id' => $user_id,
                'car_id' => $car_id,
                'appointment_time' => $appointment_time,
                'state' => 0,
                'appointment_date' => $appointment_date
            ]);
            if ($affectedRows > 0) {
                $responseData = [
                    "sonuc" => $affectedRows,
                    "success" => 1,
                    "message" => "Test sürüş randevusu güncellendi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Test sürüş randevusu güncellenemedi , lütfen tekrar deneyiniz",
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
    public function testdriveschedules(Request $request)
    {
        try {
            $selectedDate =  $request->selectedDate;
            $selectedCar =  $request->selectedCar;

            $schedules = Appointment::where('car_id', $selectedCar)
                ->where('appointment_date', '=', $selectedDate)
                ->get();
            if (!$schedules->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "schedules" => $schedules,
                    "message" => "Arabaya ait randevu listesi getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Arabaya ait randevu listesi getirelemedi",
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
