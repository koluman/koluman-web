<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenController extends Controller
{
    public function refresh(Request $request)
    {

        try {
            // Mevcut kullanıcıyı al
            $user = JWTAuth::parseToken()->authenticate();
    
            // Token'ı yenile
            $refreshedToken = JWTAuth::refresh();
    
            return response()->json(['token' => $refreshedToken]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Token yenileme hatası'], 500);
        }

    }
}
