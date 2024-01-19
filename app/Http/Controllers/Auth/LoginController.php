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
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $credentials = $request->only('email', 'password');

            $user = BackUser::where('backuser_mail', $credentials['email'])->first();

            if (!$user || !Hash::check($credentials['password'], $user->backuser_password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials',
                ], 401);
            }

            $token = Auth::guard('web')->login($user);

            $user = Auth::guard('web')->user();

            // Kullanıcının rol bilgisini al
            $userRole = $user->backuser_role;

            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ],
                'role' => $userRole,  // Rol bilgisini response'a ekleyebilirsiniz
            ]);
        } catch (\Exception $e) {
            // Laravel'in doğal hata mekanizmasını kullan
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('signin');
    }
}
