<?php

namespace App\Http\Controllers\Sigorta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SigortaHomeController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('sigorta.dashboard');
    }
    public function sigorta(Request $request)
    {
        return view('admin.sigorta');
    }
}
