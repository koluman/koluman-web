<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Showroom;
use Illuminate\Http\Request;

class ShoowroomController extends Controller
{

    public function shoowroom(Request $request)
    {
        $companies = Companies::select('company_id', 'company_name', 'company_image_url')->get();

        foreach ($companies as $company) {
            $showrooms = $company->showrooms;
            $carCount = 0;

            foreach ($showrooms as $showroom) {
                $step1Values[] = $showroom->step1;
                $carCount += $showroom->cars->count(); // Her bir showroom'daki araba sayısını topla
            }

            $company->setAttribute('showroomCount', $showrooms->count()); 
            $company->setAttribute('carCount', $carCount); 
        }

        $uniqueStep1Values = array_unique($step1Values);

        return view('ajans.list', compact('companies', 'uniqueStep1Values'));
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
}
