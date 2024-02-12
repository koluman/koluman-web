<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use Illuminate\Http\Request;

class ShoowroomController extends Controller
{
    
    public function shoowroom(Request $request)
    {
        return view('ajans.list');
    }
    public function shoowroomdetail(Request $request)
    {
        return view('ajans.detail');
    }

}
