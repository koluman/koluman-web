<?php

namespace App\Http\Controllers;

use App\Models\DealerShips;
use Illuminate\Http\Request;

class DealerShipsController extends Controller
{
    public function getdealerships(Request $request)
    {
        try {
            $columnsToSelect = ['dealership_id','dealership_name','dealership_city','dealership_address','dealership_latitude', 
                'dealership_longitude','dealership_phone','dealership_description','dealership_image_url'];
            $dealerships = DealerShips::select($columnsToSelect)->get();
    
            $dealerships = DealerShips::get();
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
}
