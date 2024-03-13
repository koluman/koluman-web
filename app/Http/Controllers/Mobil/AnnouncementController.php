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
            $announcements = Announcement::with('company:company_id,company_name')->get();
            $responseData = [
                "success" => 1,
                "announcement" => $announcements->map(function ($item) {
                    if ($item->company_id === -1) {
                        // Placeholder for announcements with company_id of -1
                        return [
                            "announcement_id" => $item->announcement_id,
                            "company_id" => -1,
                            "announcement_title" => $item->announcement_title,
                            "announcement_description" => $item->announcement_description,
                            "announcement_image_url" => $item->announcement_image_url,
                            "announcement_state" => $item->announcement_state,
                            "announcement_date" => $item->announcement_date,
                            "isActive" => $item->isActive,
                            "company_name" => "Genel",
                        ];
                    } else {
                        // Handle announcements with associated companies
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
                    }
                }),                    
                "message" => "Duyuru, haber ve kampanya listesi getirildi",
            ];
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "announcement" => "",
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($responseData);
    }
    
}
