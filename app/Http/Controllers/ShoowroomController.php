<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use Illuminate\Http\Request;

class ShoowroomController extends Controller
{
    public function getshowroomcars(Request $request)
    {
        try {
            $shoowroom = Showroom::select('car_id', 'car_name', 'car_image_url','isTestdrive')->get();
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
    public function shoowroom(Request $request)
    {
        return view('ajans.list');
    }
    public function shoowroomdetail(Request $request)
    {
        return view('ajans.detail');
    }

}
