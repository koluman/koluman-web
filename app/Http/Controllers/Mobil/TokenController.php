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
           
                $newToken = Auth::refresh();
                $responseData = [
                    "success" => 1,
                    "token" => [
                        "value" => $newToken,
                        "expires_in" => Auth::factory()->getTTL() * 60,
                    ],
                    "message" => "Refresh token oluşturuldu",
                ];
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
        return response()->json($newToken);
    }


    
}
