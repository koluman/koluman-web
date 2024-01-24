<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BackUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $user = BackUser::where('backuser_mail', $credentials['email'])->first();
            if (!$user || !Hash::check($credentials['password'], $user->backuser_password)) {
                $responseData = [
                    "success" => 0,
                    "message" => "Kullanıcı bilgileri yanlış, giriş işlemi başarısız.",
                    "token" => [
                        "originaltoken" => "",
                        "expires_in" => "",
                        "expires_time" => ""
                    ],                    
                    'user' => "",
                    'redirectRoute' => "",
                ];
            }

            Auth::guard('web')->login($user);
            $token = JWTAuth::fromUser($user);
            $userRole = $user->backuser_role;
            $preferredLanguage = Session::put('lang', $user->backuser_language);
            $expiresInSeconds = Auth::factory()->getTTL() * 60;
            $now = Carbon::now();
            $expirationDate = $now->addSeconds($expiresInSeconds);

            App::setLocale($preferredLanguage);
            $redirectRoute = match ($userRole) {
                'admin' => 'admindashboard',
                'ajans' => 'ajansdashboard',
                default => 'userdashboard',
            };
            $responseData = [
                'success' => 1,
                'message' => 'Giriş İşlemi başalarılı.',
                'user' => $user,
                'redirectRoute' => $redirectRoute,
                "token" => [
                    "originaltoken" => $token,
                    "expires_in" => $expiresInSeconds,
                    "expires_time" => $expirationDate->toDateTimeString()
                ],
            ];
        } catch (\Exception $e) {
            $responseData = [
                'success' => 0,
                'message' => $e->getMessage(),
                "token" => [
                    "originaltoken" => $token,
                    "expires_in" => $expiresInSeconds,
                    "expires_time" => $expirationDate->toDateTimeString()
                ],
                'user' => "",
                'redirectRoute' => "",
            ];
        }
        return response()->json($responseData);
    }


    public function logout()
    {
        try {
            Auth::guard('web')->logout();
            Session::flush();
            return redirect()->route("signin");
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }
}
