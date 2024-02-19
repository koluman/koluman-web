<?php

namespace App\Http\Controllers\Ajans;

use App\Http\Controllers\Controller;
use App\Models\Companies;
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

}
