<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BackUser;
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
            $email = $request->input('email');
            $password = $request->input('password');

            $user = BackUser::where('backuser_mail', $email)->first();

            if (!$user || !Hash::check($password, $user->backuser_password)) {
                return back()->with('error', __('Kullanıcı adı veya şifre hatalı.'));
            }

            // Kullanıcının rol bilgisini al
            $userRole = $user->backuser_role;
            $token = JWTAuth::fromUser($user);
            Session::put('role', $userRole);

            // Token bilgilerini kullanıcıya ekle
            $user['token'] = $token;
            $user['role'] = $userRole;
            // Kullanıcıyı web guard ile oturum aç

            // JWT token oluştur

            // Kullanıcının dil tercihini kontrol et
            $preferredLanguage = Session::put('lang', $user->backuser_language);
            App::setLocale($preferredLanguage);
            Auth::guard('api')->login($user);
         
                        // Yönlendirme
            if (Auth::check()) {
                $redirectRoute = match ($userRole) {
                    'admin' => 'admin.dashboard',
                    'ajans' => 'ajans.dashboard',
                    default => 'user.dashboard',
                };
                return redirect()->route($redirectRoute);
            }
            return back()->with('error', 'Giriş yapılamadı.');

        } catch (\Exception $e) {
            // Laravel'in doğal hata mekanizmasını kullan
            return back()->with('error', $e->getMessage());
        }
    }


    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('signin');
    }
}
