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
            dd($email);
            //$credentials = $request->only('email', 'password');
           // $user = BackUser::where('backuser_mail', $credentials['email'])->first();

            /*if (!$user || !Hash::check($credentials['password'], $user->backuser_password)) {
                $responseData = [
                    "success" => 0,
                    "message" => "Kullanıcı bilgileri yanlış, giriş işlemi başarısız.",
                    'token' => "",
                    'user' => "",
                    'redirectRoute' => "",
                ];
            }

            $token = JWTAuth::fromUser($user);
            $user = Auth::guard('web')->user();

            // Kullanıcının rol bilgisini al
            $userRole = $user->backuser_role;
            $preferredLanguage = Session::put('lang', $user->backuser_language);
            App::setLocale($preferredLanguage);
            $redirectRoute = match ($userRole) {
                'admin' => 'admin.dashboard',
                'ajans' => 'ajans.dashboard',
                default => 'user.dashboard',
            };
            $responseData = [
                'status' => '1',
                'message' => 'Giriş İşlemi başalarılı.',
                'token' => $token,
                'user' => $user,
                'redirectRoute' => $redirectRoute,
            ];*/
        } catch (\Exception $e) {
            $responseData = [
                'status' => '0',
                'message' => $e->getMessage(),
                'token' => "",
                'user' => "",
                'redirectRoute' => "",
            ];
        }
        //return response()->json($responseData);
    }


    public function logout()
    {
        try {
            $token = JWTAuth::getToken();
            if ($token) {
                JWTAuth::invalidate($token);
                Auth::guard('web')->logout();
                Session::flush();
                $responseData = [
                    "success" => 1,
                    "message" => "Logout işlemi başarılı",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "message" => "Token bulunamadı, Logout işlemi başarısız",
                ];
            }
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "message" => $e->getMessage(),
            ];
        }
    }
}
