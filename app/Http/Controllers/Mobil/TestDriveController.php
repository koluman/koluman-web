<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestDriveAddRequest;
use App\Http\Requests\TestDriveDeleteRequest;
use App\Http\Requests\TestDriveGetRequest;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class TestDriveController extends Controller
{
    public function addtestdriveappointment(TestDriveAddRequest $request)
    {
        try {

            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                $car_id = $request->car_id;
                $appointment_time = $request->appointment_time;
                $user_id = $u->user_id;
                $appointment_date=$request->appointment_date;

                $affectedRows = Appointment::insert([
                    'user_id' => $user_id,
                    'car_id' => $car_id,
                    'appointment_time' => $appointment_time,
                    'state' => 0,
                    'appointment_date'=>$appointment_date
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
                    "message" => "Bir hata oluştu, lütfen tekrar deneyiniz.",
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
    public function getusertestdriveappointment(Request $request)
    {
        try {

            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                $today = Carbon::now()->toDateString();
                $testDrives = Appointment::select('appointment.appointment_id', 'appointment.car_id', 'appointment.appointment_time', 'appointment.appointment_date', 'appointment.user_id', 'appointment.state', 'c.car_name')
                    ->join('showroom as c', 'appointment.car_id', '=', 'c.car_id')
                    ->where('appointment.user_id', $u->user_id)
                    ->where('appointment.appointment_date', '>=', $today)
                    ->first();
                if ($testDrives) {
                    $responseData = [
                        "success" => 1,
                        "userAppointment" => $testDrives,
                        "message" => "Test sürüş randevu listesi getirildi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Test sürüş randevu listesi bulunamadı",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Bir hata oluştu, lütfen tekrar deneyiniz.",
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
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                $appointment_id = $request->appointment_id;
                $testDrive = Appointment::where('appointment_id', $appointment_id)->first();
                if ($testDrive->user_id == $u->user_id) {
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
            } else {
                $responseData = [
                    "success" => 0,
                    "testDrives" => "",
                    "message" => "Bir hata oluştu, lütfen tekrar deneyiniz.",
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

    public function testdrivegetcarschedule(TestDriveGetRequest $request)
    {

        try {
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                $lastWeek = Carbon::now()->subWeek(); // Şu anki tarihten bir hafta önceki tarih
                $testDrivescar = Appointment::where('car_id', $request->car_id)
                    ->where('auto_date', '>=', $lastWeek)->get();
                if (!$testDrivescar->isEmpty()) {
                    $responseData = [
                        "success" => 1,
                        "testDrivescar" => $testDrivescar,
                        "message" => "Arabaya ait randevu listesi getirildi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Arabaya ait randevu listesi getirelemedi",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Bir hata oluştu, lütfen tekrar deneyiniz.",
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
