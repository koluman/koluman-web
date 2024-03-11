<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function getannouncement(Request $request)
    {
        try {

            $announcement = Announcement::with('company')->get();
            if (!$announcement->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "announcement" => $announcement,
                    "message" => "Duyuru, haber ve kampanya listesi getirildi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "announcement" => "",
                    "message" => "Duyuru, haber ve kampanya listesi bulunamadı",
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
