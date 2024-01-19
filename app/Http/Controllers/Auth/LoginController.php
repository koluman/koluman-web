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
                //Auth::login($user, true);
                $user->role = $user->backuser_role;

                Auth::login($user,true);
                $token = JWTAuth::fromUser($user);
                $u = JWTAuth::setToken($token)->authenticate();
              

                //$token = $user->createToken('api-token', ['role:' . $user->role]);
                $user['token'] = $token;
                $user['role'] = $user->role;

                // Kullanıcnın dil tercihini kontrol et
                $preferredLanguage = Session::put('lang', $user->backuser_language);                ; 
                App::setLocale($preferredLanguage);

                $redirectRoute = match ($user->role) {
                    'admin' => 'admin.dashboard',
                    'ajans' => 'ajans.dashboard',
                    default => 'user.dashboard',
                };
                return redirect()->route($redirectRoute);
            } else {
                return back()->with('error', __('Kullanıcı adı veya şifre hatalı.'));
            }
        } catch (\Exception $e) {
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
