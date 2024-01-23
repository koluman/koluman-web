<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenController extends Controller
{
    public function refresh(Request $request)
    {
        try {

            $user = Auth::guard('api')->user();

            // Yeni bir refresh token ve JWT token oluştur
           /* $refreshToken = JWTAuth::fromUser($user, ['exp' => now()->addMinutes(30)->timestamp]);
            $newToken = JWTAuth::refresh($request->bearerToken());
            $responseData = [
                "success" => 1,
                "token" => [
                    "value" => $newToken,
                    "expires_in" => Auth::factory()->getTTL() * 60,
                ],
                "message" => "Refresh token oluşturuldu",
            ];*/
        } catch (\Exception $e) {
            $responseData = [
                "success" => 0,
                "token" => [
                    "value" => "",
                    "expires_in" => 0,
                ],
                "message" => $e->getMessage(),
            ];
        }
        return response()->json(Auth::guard('api'));
    }
}
