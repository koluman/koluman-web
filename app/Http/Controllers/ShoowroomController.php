<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowroomAddRequest;
use App\Models\Companies;
use App\Models\Showroom;
use Illuminate\Http\Request;

class ShoowroomController extends Controller
{

    public function shoowroom(Request $request)
    {
        $companies = Companies::with(['showrooms', 'showrooms.cars'])->get();

        foreach ($companies as $company) {
            $carCount = 0;

            foreach ($company->showrooms as $showroom) {
                $carCount += $showroom->cars->count();
            }

            $company->setAttribute('carCount', $carCount);
        }

        return view('ajans.list', compact('companies'));
    }
    public function shoowroomdetail(Request $request)
    {
        return view('ajans.detail');
    }
    public function getshowroomcars(Request $request)
    {
        try {
            $shoowroom = Showroom::select('showroom.car_id', 'showroom.company_id', 'showroom.step1', 'showroom.step2', 'showroom.step3', 'showroom.step4', 'showroom.step5', 'showroom.car_name', 'showroom.car_description', 'showroom.car_image_url', 'showroom.isTestdrive', 'companies.company_name')
                ->join('companies', 'showroom.company_id', '=', 'companies.company_id')
                ->where('company_id',$request->company_id)
                ->get();

            if (!$shoowroom->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "showroomcars" => $shoowroom,
                    "message" => "Arabalar listesi getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Arabalar listesi bulunamadı",
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
    public function getshowroomcarid(Request $request)
    {
        try {
            $shoowroomid = Showroom::select('showroom.car_id', 'showroom.company_id', 'showroom.step1', 'showroom.step2', 'showroom.step3', 'showroom.step4', 'showroom.step5', 'showroom.car_name', 'showroom.car_description', 'showroom.car_image_url', 'showroom.isTestdrive', 'companies.company_name')
                ->join('companies', 'showroom.company_id', '=', 'companies.company_id')
                ->where('car_id', $request->car_id)
                ->get();

            if (!$shoowroomid->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "showroomcarid" => $shoowroomid,
                    "message" => "Arabalar listesi getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Arabalar listesi bulunamadı",
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
    public function addshowroom(ShowroomAddRequest $request)
    {
        try {
            $car_id = $request->car_id;
            $car_name = $request->car_name;
            $company_id = $request->company_id;
            $car_description = $request->car_description;
            $step1 = $request->filled('step1') ? $request->step1 : '';
            $step2 = $request->filled('step2') ? $request->step2 : '';
            $step3 = $request->filled('step3') ? $request->step3 : '';
            $step4 = $request->filled('step4') ? $request->step4 : '';
            $step5 = $request->filled('step5') ? $request->step5 : '';
            $state = $request->filled('state') ? $request->state : '';
            $showroomPath = "";
            if ($request->hasFile('car_img_url')) {
                $showroom = $request->file('car_img_url');
                $showroomName = time() . '.' . $showroom->getClientOriginalExtension();
                $showroom->move(public_path('upload/showroom'), $showroomName);
                $showroomPath = 'https://mobiloby.app/koluman/web/public/upload/showroom/' . $showroomName;
            } else {
                $showroomPath = "";
            }
            $result = Showroom::create([
                'car_name' => $car_name,
                'company_id' => $company_id,
                'step1' => $step1,
                'step2' => $step2,
                'step3' => $step3,
                'step4' => $step4,
                'step5' => $step5,
                'car_description' => $car_description,
                'isTestdrive' => $state,
                'car_image_url' => $showroomPath, // Dosyanın URL'sini kaydet
            ]);
            if ($result) {
                $responseData = [
                    "result" => $result,
                    "success" => 1,
                    "message" => "Araba başarılı bir şekilde eklendi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Araba başarılı bir şekilde oluşturulamadı, lütfen tekrar deneyiniz",
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
    public function updateshowroom(ShowroomAddRequest $request)
    {
        try {
            $car_id = $request->input('car_id');
            $car_name = $request->input('car_name');
            $company_id = $request->input('company_id');
            $step1 = $request->filled('step1') ? $request->step1 : '';
            $step2 = $request->filled('step2') ? $request->step2 : '';
            $step3 = $request->filled('step3') ? $request->step3 : '';
            $step4 = $request->filled('step4') ? $request->step4 : '';
            $step5 = $request->filled('step5') ? $request->step5 : '';
            $state = $request->filled('state') ? $request->state : '';
            $car_description = $request->car_description;
            $showroomPath = "";

            if ($request->hasFile('car_img_url')) {
                $showroom = $request->file('car_img_url');
                $showroomName = time() . '.' . $showroom->getClientOriginalExtension();
                $showroom->move(public_path('upload/showroom'), $showroomName);
                $showroomPath = 'https://mobiloby.app/koluman/web/public/upload/showroom/' . $showroomName;
                $affectedRows = Showroom::where('car_id', $car_id)
                    ->update([
                        'car_name' => $car_name,
                        'company_id' => $company_id,
                        'step1' => $step1,
                        'step2' => $step2,
                        'step3' => $step3,
                        'step4' => $step4,
                        'step5' => $step5,
                        'car_description' => $car_description,
                        'isTestdrive' => $state,
                        'car_image_url' => $showroomPath,
                    ]);
            } else {
                $affectedRows = Showroom::where('car_id', $car_id)
                    ->update([
                        'car_name' => $car_name,
                        'company_id' => $company_id,
                        'step1' => $step1,
                        'step2' => $step2,
                        'step3' => $step3,
                        'step4' => $step4,
                        'step5' => $step5,
                        'isTestDrive' => $state,
                    ]);
            }
            if ($affectedRows > 0) {
                $responseData = [
                    "success" => 1,
                    "message" => "İncelendi durumu güncellendi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "İncelendi durumu güncellenemedi , lütfen tekrar deneyiniz",
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
    public function deleteshowroomimage(Request $request)
    {
        try {

            $car_id = $request->car_id;

            $affectedRows = Showroom::where('car_id', $car_id)
                ->update([
                    'car_image_url' => "",
                ]);
            if ($affectedRows > 0) {
                $responseData = [
                    "showroom" => $affectedRows,
                    "success" => 1,
                    "message" => "Resim silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Resim silinemedi",
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

    public function deleteshowroom(Request $request)
    {
        try {
            $car_id = $request->car_id;
            $showroom = Showroom::where('car_id', $car_id)->first();
            if ($showroom) {
                $showroom->delete();
                $responseData = [
                    "success" => 1,
                    "message" => "Araba başarıyla silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Araba başarıyla silinemedi!",
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
