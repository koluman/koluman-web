<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestDriveController extends Controller
{
    public function addtestdrive(){
        return response()->json("test srüş ekleme fonksiyonu");
    }
}
