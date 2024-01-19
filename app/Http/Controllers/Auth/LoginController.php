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
    
            // Kullanıcıyı bul
            $user = BackUser::where('backuser_mail', $email)->first();
            dd($user);
            // Kullanıcı var mı ve şifre doğru mu?
            if ($user && Hash::check($password, $user->backuser_password)) {
                dd("dfgndkf");
                // Kullanıcı rolünü ayarla
                /*$user->role = $user->backuser_role;
    
                // Giriş işlemini gerçekleştir
                if (Auth::guard('web')->attempt(['backuser_mail' => $email, 'backuser_password' => $password])) {
                    // Giriş başarılıysa
                    $token = JWTAuth::fromUser($user);
                    $u = JWTAuth::setToken($token)->authenticate();
    
                    $user['token'] = $token;
                    $user['role'] = $user->role;
    
                    // Kullanıcının dil tercihini kontrol et
                    $preferredLanguage = Session::put('lang', $user->backuser_language);               
                    App::setLocale($preferredLanguage);
    
                    $redirectRoute = match ($user->role) {
                        'admin' => 'admin.dashboard',
                        'ajans' => 'ajans.dashboard',
                        default => 'user.dashboard',
                    };
                    return redirect()->route($redirectRoute);
                } else {
                    // Giriş başarısızsa
                    return back()->with('error', __('Kullanıcı adı veya şifre hatalı.'));
                }*/
            } else {
                // Kullanıcı bulunamadı veya şifre hatalıysa
                return back()->with('error', __('Kullanıcı adı veya şifre hatalı.'));
            }
        } catch (\Exception $e) {
            // İstisna durumları için
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
