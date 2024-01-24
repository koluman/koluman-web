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
            return response()->json(['success'=>1,'message' => 'Kullanıcı token bilgisi getirildi','token' => $token]);
        } else {
            return response()->json(['success'=>0,'message' =>'Kullanıcı girişi yapılmamış','token' => '']);
        }
    }
    public function getBasicToken()
    {
        if (Auth::guard('web')->check()) {
            $token ="a29sdW1hbjprb2x1bWFuMjAyNA==";
            return response()->json(['success'=>1,'message' => 'Token bilgisi getirildi','token' => $token]);
        } else {
            return response()->json(['success'=>0,'message' =>'Tokenbilgisi gelmedi','token' => '']);
        }
    }
}
