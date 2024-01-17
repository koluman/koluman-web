<?php

namespace App\Http\Controllers\Ajans;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjansHomeController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('ajans.dashboard');
    }
}
