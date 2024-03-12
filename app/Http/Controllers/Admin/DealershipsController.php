<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealerShips;
use Illuminate\Http\Request;

class DealershipsController extends Controller
{
    public function dealerships(Request $request)
    {
        return view('admin.dealerships');
    }
    public function getdealerships(Request $request)
    {
        try {
            $dealerships = DealerShips::with('company')->get();
            if (!$dealerships->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "dealerships" => $dealerships,
                    "message" => "Şubeler listesi getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "dealerships" => "",
                    "message" => "Şubeler listesi bulunamadı",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "shoowroom" => "",
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
    public function adddealership(Request $request)
    {
        try {
            $dealership_name = $request->dealership_name;
            $company_id = $request->company_id;
            $dealership_city = $request->dealership_city;
            $dealership_phone = $request->dealership_phone;
            $dealership_latitude = $request->dealership_latitude;
            $dealership_longitude = $request->dealership_longitude;
            $dealership_description = $request->dealership_description;
            $dealership_address = $request->dealership_address;
            $sPath = "";
            if ($request->hasFile('dealership_image_url')) {
                $s = $request->file('dealership_image_url');
                $sName = time() . '.' . $s->getClientOriginalExtension();
                $s->move(public_path('upload/dealerships'), $sName);
                $sPath = 'https://mobiloby.app/koluman/web/public/upload/dealerships/' . $sName;
            } else {
                $sPath = "";
            }
           
            $sonuc = DealerShips::create([
                'dealership_name' => $dealership_name,
                'company_id' => $company_id,
                'dealership_city' => $dealership_city,
                'dealership_phone' => $dealership_phone,
                'dealership_latitude' => $dealership_latitude,
                'dealership_longitude' => $dealership_longitude,
                'dealership_description' => $dealership_description,
                'dealership_address' => $dealership_address,
                'dealership_image_url' => $sPath,

            ]);
            if ($sonuc) {
                $responseData = [
                    "success" => 1,
                    "message" => "Şube başarılı bir şekilde kayıt edilmiştir.",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Şube eklenemedi lütfen tekrar deneyiniz.",
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
    public function updatedealership(Request $request)
    {
        try {
            $dealership_name = $request->dealership_name;
            $company_id = $request->company_id;
            $dealership_city = $request->dealership_city;
            $dealership_phone = $request->dealership_phone;
            $dealership_latitude = $request->dealership_latitude;
            $dealership_longitude = $request->dealership_longitude;
            $dealership_description = $request->dealership_description;
            $dealership_address = $request->dealership_address;
            $dealership_id = $request->dealership_id;
            $sPath = "";
            if ($request->hasFile('dealership_image_url')) {
                $s = $request->file('dealership_image_url');
                $sName = time() . '.' . $s->getClientOriginalExtension();
                $s->move(public_path('upload/dealerships'), $sName);
                $sPath = 'https://mobiloby.app/koluman/web/public/upload/dealerships/' . $sName;
                $affectedRows = DealerShips::where('dealership_id', $dealership_id)
                    ->update([
                        'dealership_name' => $dealership_name,
                        'company_id' => $company_id,
                        'dealership_city' => $dealership_city,
                        'dealership_phone' => $dealership_phone,
                        'dealership_latitude' => $dealership_latitude,
                        'dealership_longitude' => $dealership_longitude,
                        'dealership_description' => $dealership_description,
                        'dealership_address' => $dealership_address,
                        'dealership_image_url' => $sPath,
                    ]);
            } else {
                $affectedRows = DealerShips::where('dealership_id', $dealership_id)
                    ->update([
                        'dealership_name' => $dealership_name,
                        'company_id' => $company_id,
                        'dealership_city' => $dealership_city,
                        'dealership_phone' => $dealership_phone,
                        'dealership_latitude' => $dealership_latitude,
                        'dealership_longitude' => $dealership_longitude,
                        'dealership_description' => $dealership_description,
                        'dealership_address' => $dealership_address
                    ]);
            }
            if ($affectedRows > 0) {
                $responseData = [
                    "success" => 1,
                    "message" => "Şube detayları güncellendi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Şube detayları güncellenemedi , lütfen tekrar deneyiniz",
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
    public function deletedealership(Request $request)
    {
        try {
            $id = $request->id;
            $h = DealerShips::where('dealership_id', $id)->first();
            if ($h) {
                $h->delete();
                $responseData = [
                    "success" => 1,
                    "message" => "Şube başarıyla silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Şube başarıyla silinemedi!",
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
    public function deletealldealership(Request $request)
    {
        try {
            $ids_array = $request->ids_array;
            /*$h = DealerShips::where('dealership_id', $id)->first();
            if ($h) {
                $h->delete();
                $responseData = [
                    "success" => 1,
                    "message" => "Şube başarıyla silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Şube başarıyla silinemedi!",
                ];
            }*/
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }

        return response()->json($ids_array);
    }
}
