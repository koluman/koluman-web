<?php

namespace App\Http\Controllers\Ajans;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Companies;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{
    
    public function announcements(Request $request)
    {
        return view('ajans.announcements');
    }
    public function announcementsdetail(Request $request)
    {
        return view('ajans.announcementsdetail');
    }
    
    public function addannouncement(Request $request)
    {
        try {
            $announcement_id = $request->announcement_id;
            $announcement_title = $request->announcement_title;
            $announcement_state = $request->announcement_state;
            $announcement_description = $request->announcement_description;
          
            /*$announcementPath = "";
            if ($request->hasFile('announcement_img_url')) {
                $announcement = $request->file('announcement_img_url');
                $announcementName = time() . '.' . $announcement->getClientOriginalExtension();
                $announcement->move(public_path('upload/announcement'), $announcementName);
                $announcementPath = 'https://mobiloby.app/koluman/web/public/upload/announcement/' . $announcementName;
            } else {
                $announcementPath = "";
            }
            $result = Announcement::create([
                'announcement_title' => $announcement_title,
                'announcement_description' => $announcement_description,
                'announcement_state' => $announcement_state,
                'announcement_date' => Carbon::now('Europe/Istanbul'),
                'announcement_image_url' => $announcementPath, // Dosyanın URL'sini kaydet
            ]);
            if ($result) {
                $responseData = [
                    "result" => $result,
                    "success" => 1,
                    "message" => "Başarılı bir şekilde eklendi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Başarılı bir şekilde oluşturulamadı, lütfen tekrar deneyiniz",
                ];
            }*/
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }
        return response()->json($request->file('announcement_img_url'));
    }
    public function updateannouncement(Request $request)
    {
        try {
            $announcement_id = $request->announcement_id;
            $announcement_title = $request->announcement_title;
            $announcement_state = $request->announcement_state;
            $announcement_description = $request->announcement_description;
            $announcementPath = "";

            if ($request->hasFile('announcement_img_url')) {
                $announcement = $request->file('announcement_img_url');
                $announcementName = time() . '.' . $announcement->getClientOriginalExtension();
                $announcement->move(public_path('upload/announcement'), $announcementName);
                $announcementPath = 'https://mobiloby.app/koluman/web/public/upload/announcement/' . $announcementName;
                $affectedRows = announcement::where('announcement_id', $announcement_id)
                    ->update([
                        'announcement_title' => $announcement_title,
                        'announcement_description' => $announcement_description,
                        'announcement_state' => $announcement_state,
                        'announcement_date' => Carbon::now('Europe/Istanbul'),
                        'announcement_image_url' => $announcementPath, 
                    ]);
            } else {
                $affectedRows = announcement::where('announcement_id', $announcement_id)
                    ->update([
                        'announcement_title' => $announcement_title,
                        'announcement_description' => $announcement_description,
                        'announcement_state' => $announcement_state,
                        'announcement_date' => Carbon::now('Europe/Istanbul'),
                    ]);
            }
            if ($affectedRows > 0) {
                $responseData = [
                    "success" => 1,
                    "message" => "Güncelleme işlemi başarılı",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Güncelleme işlemi başarısız , lütfen tekrar deneyiniz",
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
    public function deleteannouncementimg(Request $request)
    {
        try {

            $announcement_id = $request->announcement_id;

            $affectedRows = Announcement::where('announcement_id', $announcement_id)
                ->update([
                    'announcement_image_url' => "",
                ]);
            if ($affectedRows > 0) {
                $responseData = [
                    "announcement" => $affectedRows,
                    "success" => 1,
                    "message" => "Resim silindi",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Resim silinemedi",
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
