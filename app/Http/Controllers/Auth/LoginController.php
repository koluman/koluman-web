<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::where('user_mail', $email)->first();

            if ($user && Hash::check($password, $user->user_password)) {
                Auth::login($user, true);
                $user->role = $user->user_role;
                $token = $user->createToken('api-token', ['role:' . $user->role]);
                $user['token'] = $token->plainTextToken;

                // Kullanıcının dil tercihini kontrol et
                $preferredLanguage = Session::put('lang', $user->user_language);                ; 
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
