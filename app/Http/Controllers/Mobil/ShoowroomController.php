<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\Showroom;
use App\Models\ShowroomCategories;
use Illuminate\Http\Request;

class ShoowroomController extends Controller
{
    public function getshowroomcars(Request $request)
    {
        try {
            $shoowroom = Showroom::where('company_id', $request->company_id)
                ->select('car_id', 'company_id', 'step1', 'step2', 'step3', 'step4', 'step5', 'car_name', 'car_description', 'car_image_url', 'isTestdrive')->get();
            if (!$shoowroom->isEmpty()) {
                $shoowroomcategories = ShowroomCategories::where('company_id', $request->company_id)
                ->select('id', 'company_id', 'category_name','category_img_url')->get();

                $responseData = [
                    "success" => 1,
                    "shoowroomcategories"=>$shoowroomcategories,
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
    public function getshowroomdetail(Request $request)
    {
        try {
            $shoowroomdetail = Showroom::select(
                'showroom.car_id',
                'showroom.company_id',
                'showroom.step1',
                'showroom.step2',
                'showroom.step3',
                'showroom.step4',
                'showroom.step5',
                'showroom.car_name',
                'showroom.car_description',
                'showroom.car_image_url',
                'showroom.isTestdrive',
                'companies.company_name',
                'showroom_gallery.gallery_id',
                'showroom_gallery.car_img_type',
                'showroom_gallery.created_at',
                'showroom_gallery.updated_at',
                'showroom_gallery.car_img_url'
            )
                ->join('companies', 'showroom.company_id', '=', 'companies.company_id')
                ->leftJoin('showroom_gallery', 'showroom.car_id', '=', 'showroom_gallery.car_id')
                ->where('showroom.car_id', $request->car_id)
                ->get();
    
            // Boş kontrolü
            if (!$shoowroomdetail->isEmpty()) {
                // Gruplandırma işlemi
                $groupedShowroomDetail = (object)[
                    'car_id' => $shoowroomdetail[0]->car_id,
                    'company_id' => $shoowroomdetail[0]->company_id,
                    'step1' => $shoowroomdetail[0]->step1,
                    'step2' => $shoowroomdetail[0]->step2,
                    'step3' => $shoowroomdetail[0]->step3,
                    'step4' => $shoowroomdetail[0]->step4,
                    'step5' => $shoowroomdetail[0]->step5,
                    'car_name' => $shoowroomdetail[0]->car_name,
                    'car_description' => $shoowroomdetail[0]->car_description,
                    'car_image_url' => $shoowroomdetail[0]->car_image_url,
                    'isTestdrive' => $shoowroomdetail[0]->isTestdrive,
                    'company_name' => $shoowroomdetail[0]->company_name,
                    'gallery' => $shoowroomdetail->map(function ($item) {
                        return [
                        
                            'gallery_id' => $item->gallery_id,
                            'car_img_url' => $item->car_img_url,
                            'car_img_type' => $item->car_img_type,

                        ];
                    })->toArray(),
                ];
    
                $responseData = [
                    "success" => 1,
                    "shoowroomdetail" => $groupedShowroomDetail,
                    "message" => "Araba detay bilgileri getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Araba detay bilgisi bulunamadı",
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
