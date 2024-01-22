<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\TestDrive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TestDriveController extends Controller
{
    public function testdriveadd(Request $request)
    {
        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $u = JWTAuth::setToken($token)->authenticate();
        try {
            if ($u) {
                $car_id = $request->car_id;
                $drive_time = $request->drive_time;
                $user_id = $u->user_id;

                $affectedRows = TestDrive::insert([
                    'user_id' => $user_id,
                    'car_id' => $car_id,
                    'drive_time' => $drive_time,
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
    public function testdriveget(Request $request)
    {
        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);
        $u = JWTAuth::setToken($token)->authenticate();
        try {
            if ($u) {
                $lastWeek = Carbon::now()->subWeek(); // Şu anki tarihten bir hafta önceki tarih
                $testDrives = TestDrive::where('auto_date', '>=', $lastWeek)->get();
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

    public function deleteTestDrive(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            if ($token) {
                $drive_id = $request->drive_id;
                $testDrive = TestDrive::where('drive_id', $drive_id)->first();
                if ($testDrive) {
                    $testDrive->delete();
                    $responseData = [
                        "success" => 1,
                        "message" => "Test sürüşü başarıyla silindi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Belirtilen drive_id ile eşleşen test sürüşü bulunamadı",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
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
    public function updateTestDrive(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            if ($token) {
                $drive_id = $request->drive_id;
                $testDrive = TestDrive::where('drive_id', $drive_id)->first();
                if ($testDrive) {
                    $testDrive->drive_time = $request->input('drive_time'); 
                    $testDrive->car_id = $request->input('car_id'); 
                    $testDrive->save();
                    $responseData = [
                        "success" => 1,
                        "message" => "Test sürüşü başarıyla güncellendi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "message" => "Belirtilen drive_id ile eşleşen test sürüşü bulunamadı",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
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
