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
            'showroom_gallery.gallery_id',
            'showroom_gallery.car_img_url'
        )->leftJoin('showroom_gallery', 'showroom.car_id', '=', 'showroom_gallery.car_id')
        ->where('showroom.car_id', $request->id)
        ->get();
      
        return view('ajans.gallery',compact('shoowroomdetail'));
    }
}
