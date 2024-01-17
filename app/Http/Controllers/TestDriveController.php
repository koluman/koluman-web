<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestDriveController extends Controller
{
    public function addtestdrive(){
        return response()->json("test srüş ekleme fonksiyonu");
    }
}
