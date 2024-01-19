<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  
    public function dashboard(Request $request)
    {
        return view('admin.dashboard');
    }
    public function users(Request $request)
    {
        return view('admin.users');
    }
}
