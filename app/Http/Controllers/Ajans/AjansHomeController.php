<?php

namespace App\Http\Controllers\Ajans;

use App\Http\Controllers\Controller;
use App\Models\Showroom;
use Illuminate\Http\Request;

class AjansHomeController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('ajans.dashboard');
    }
    public function gallery(Request $request, $id = null)
    {
        $shoowroomdetail = Showroom::select(
            'showroom.car_id',
            'showroom.company_id',
            'showroom.step1',
            'showroom.step2',
            'showroom.step3',
            'showroom.step4',
            'showroom.step5',
            'showroom.car_name',
            'showroom.car_description',
            'showroom.car_image_url',
            'showroom.isTestdrive',
            'companies.company_name',
            'showroom_gallery.gallery_id',
            'showroom_gallery.created_at',
            'showroom_gallery.updated_at',
            'showroom_gallery.car_img_url'
        )
            ->join('companies', 'showroom.company_id', '=', 'companies.company_id')
            ->leftJoin('showroom_gallery', 'showroom.car_id', '=', 'showroom_gallery.car_id')
            ->where('showroom.car_id', $request->car_id)
            ->get();

            $groupedShowroomDetail = (object)[
                'gallery' => $shoowroomdetail->map(function ($item) {
                    return [
                        'gallery_id' => $item->gallery_id,
                        'car_img_url' => $item->car_img_url,
                    ];
                })->toArray(),
            ];
       
dd($groupedShowroomDetail);
        //return view('ajans.gallery',compact('shoowroomdetail'));
    }
}
