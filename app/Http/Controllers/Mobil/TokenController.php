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
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            if ($token) {
                $refreshedToken = JWTAuth::refresh($token);
               
                $responseData = [
                    "success" => 1,
                    "token" => [
                        "value" => $refreshedToken,
                        "expires_in" => Auth::factory()->getTTL() * 60,
                    ],
                    "message" => "Refresh token oluşturuldu",
                ];
            } else {
                $responseData = [
                    "success" => 0,
                    "token" => [
                        "value" => "",
                        "expires_in" => 0,
                    ],
                    "message" => "Token bilgisi gelmedi, lütfen tokenı yollayınız",
                ];
            }
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
        return response()->json($token);
    }


    
}
