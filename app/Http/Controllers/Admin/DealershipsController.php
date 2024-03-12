<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DealershipsController extends Controller
{
    public function dealerships(Request $request)
    {
        return view('dealerships');
    }
}
