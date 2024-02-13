<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use Illuminate\Http\Request;

class ShoowroomController extends Controller
{

    public function shoowroom(Request $request)
    {
        return view('ajans.list');
    }
    public function shoowroomdetail(Request $request)
    {
        return view('ajans.detail');
    }
    public function getshowroomcars(Request $request)
    {
        try {
            $shoowroom = Showroom::select('showrooms.car_id', 'showrooms.company_id', 'showrooms.step1', 'showrooms.step2', 'showrooms.step3', 'showrooms.step4', 'showrooms.step5', 'showrooms.car_name', 'showrooms.car_description', 'showrooms.car_image_url', 'showrooms.isTestdrive', 'companies.company_name')
            ->join('companies', 'showrooms.company_id', '=', 'companies.company_id')
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
