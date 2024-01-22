<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestDriveAddRequest;
use App\Http\Requests\TestDriveDeleteRequest;
use App\Http\Requests\TestDriveGetRequest;
use App\Models\TestDrive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class TestDriveController extends Controller
{
    public function testdriveadd(TestDriveAddRequest $request)
    {
        try {
           
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $u = JWTAuth::setToken($token)->authenticate();
            if ($u) {
                $car_id = $request->car_id;
                $drive_time = $request->drive_time;
                $user_id = $u->user_id;

                $affectedRows = TestDrive::insert([
                    'user_id' => $user_id,
                    'car_id' => $car_id,
                    'drive_time' => $drive_time,
                    'state' => 0,
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
        try {
           
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            if ($token) {
                $u = JWTAuth::setToken($token)->authenticate();
                $lastWeek = Carbon::now()->subWeek(); // Şu anki tarihten bir hafta önceki tarih
                $testDrives = TestDrive::where('user_id', $u->user_id)
                    ->where('auto_date', '>=', $lastWeek)
                    ->get();
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

    public function deleteTestDrive(TestDriveDeleteRequest $request)
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
  
    public function testdrivegetcar(TestDriveGetRequest $request)
    {

        try {
                $token = $request->header('Authorization');
                $token = str_replace('Bearer ', '', $token);
                if ($token) {
                    $u = JWTAuth::setToken($token)->authenticate();

                    $testDrivescar = TestDrive::where('car_id', $request->car_id)->get();
                    if (!$testDrivescar->isEmpty()) {
                        $responseData = [
                            "success" => 1,
                            "testDrivescar" => $testDrivescar,
                            "message" => "Arabaya ait randevu listesi getirildi",
                        ];
                    } else {
                        $responseData = [
                            "success" => 0,
                            "testDrivescar" => "",
                            "message" => "Arabaya ait randevu listesi getirelemedi",
                        ];
                    }
                } else {
                    $responseData = [
                        "success" => 0,
                        "testDrivescar" => "",
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
