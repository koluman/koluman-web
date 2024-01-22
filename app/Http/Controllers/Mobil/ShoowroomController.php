<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\Showroom;
use Illuminate\Http\Request;

class ShoowroomController extends Controller
{
    public function getshowroom(Request $request)
    {
        try {
            $token = $request->header('Authorization');
            $token = str_replace('Basic ', '', $token);
            if ($token) {
                $shoowroom = Showroom::get();
                if (!$shoowroom->isEmpty()) {
                    $responseData = [
                        "success" => 1,
                        "shoowroom" => $shoowroom,
                        "message" => "Arabalar listesi getirildi",
                    ];
                } else {
                    $responseData = [
                        "success" => 0,
                        "shoowroom" => "",
                        "message" => "Arabalar listesi bulunamadı",
                    ];
                }
            } else {
                $responseData = [
                    "success" => 0,
                    "shoowroom" => "",
                    "message" => "Kullanıcı bilgisi gelmedi, lütfen tokenı yollayınız",
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
