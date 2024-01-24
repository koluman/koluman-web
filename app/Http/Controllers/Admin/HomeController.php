<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function testdrive(Request $request)
    {
        return view('admin.testdrive');
    }
    public function getApiToken()
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $token =session('api_token');;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Kullanıcı girişi yapılmamış'], 401);
        }
    }
}
