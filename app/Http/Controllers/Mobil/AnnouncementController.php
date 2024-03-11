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

            $announcement = Announcement::with('company:company_id,company_name')->get();
            if (!$announcement->isEmpty()) {
                $responseData = [
                    "success" => 1,
                    "announcement" => $announcement->map(function ($item) {
                        return [
                            "announcement_id" => $item->announcement_id,
                            "company_id" => $item->company_id,
                            "announcement_title" => $item->announcement_title,
                            "announcement_description" => $item->announcement_description,
                            "announcement_image_url" => $item->announcement_image_url,
                            "announcement_state" => $item->announcement_state,
                            "announcement_date" => $item->announcement_date,
                            "isActive" => $item->isActive,
                            "company_name" => $item->company->company_name,
                        ];
                    }),                    
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
