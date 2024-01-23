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
            $token = $request->header('Authorization');
            $token = str_replace('Bearer ', '', $token);
            $token = JWTAuth::getToken();

            $newToken = JWTAuth::refresh($token);
            return response()->json(['token' => $newToken]);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

    }
}
