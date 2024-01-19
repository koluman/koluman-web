<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BackUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

            if ($user && Hash::check($password, $user->backuser_password)) {
                // Kullanıcının rol bilgisini al
                $userRole = $user->backuser_role;

                // Kullanıcıyı web guard ile oturum aç
                Auth::guard('web')->login($user, true);

                // JWT token oluştur
                $token = JWTAuth::fromUser($user);

                // Token bilgilerini kullanıcıya ekle
                $user['token'] = $token;
                $user['role'] = $userRole;

                // Kullanıcının dil tercihini kontrol et
                $preferredLanguage = Session::put('lang', $user->backuser_language);
                App::setLocale($preferredLanguage);

                $redirectRoute = match ($userRole) {
                    'admin' => 'admin.dashboard',
                    'ajans' => 'ajans.dashboard',
                    default => 'user.dashboard',
                };

                return redirect()->route($redirectRoute);
            } else {
                // Giriş başarısızsa
                return back()->with('error', __('Kullanıcı adı veya şifre hatalı.'));
            }
        } catch (\Exception $e) {
            // İstisna durumları için
            return back()->with('error', $e->getMessage());
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Session::flush();
        return redirect()->route('signin');
    }
}
