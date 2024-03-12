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
}
