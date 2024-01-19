<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\BackUser;
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

            $user = BackUser::where('backuser_mail', $email)->first();

            if ($user && Hash::check($password, $user->backuser_password)) {
                // Sanctum kullanımı
                $token = $user->createToken('api-token', ['role:' . $user->backuser_role])->plainTextToken;

                $user['token'] = $token;
                // Kullanıcının dil tercihini kontrol et
                $preferredLanguage = Session::put('lang', $user->backuser_language);
                App::setLocale($preferredLanguage);
                Auth::login($user);
                $redirectRoute = match ($user->backuser_role) {
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
