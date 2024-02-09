<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
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
        $currentDate = Carbon::now()->toDateString();
        $appointments = Appointment::select('appointment_id', 'car_id', 'appointment_time', 'appointment_date', 'user_id', 'state', 'created_at', 'updated_at')
        ->where('state', 1)
        ->where('appointment_date', '<', $currentDate)
        ->get();
            dd($appointments);
        //return view('admin.testdrive');
    }
    public function getApiToken()
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $token = session('api_token');;
            return response()->json(['success' => 1, 'message' => 'Kullanıcı token bilgisi getirildi', 'token' => $token]);
        } else {
            return response()->json(['success' => 0, 'message' => 'Kullanıcı girişi yapılmamış', 'token' => '']);
        }
    }
    public function getBasicToken()
    {
        if (Auth::guard('web')->check()) {
            $token = "a29sdW1hbjprb2x1bWFuMjAyNA==";
            return response()->json(['success' => 1, 'message' => 'Token bilgisi getirildi', 'token' => $token]);
        } else {
            return response()->json(['success' => 0, 'message' => 'Tokenbilgisi gelmedi', 'token' => '']);
        }
    }
}
