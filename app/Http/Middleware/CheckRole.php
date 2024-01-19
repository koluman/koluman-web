<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $token = JWTAuth::getToken();
            $user = JWTAuth::toUser($token);
            dd($user);
            // Diğer middleware işlemleri...
    
            //return $next($request);
        } catch (\Exception $e) {
            return abort(401, 'Unauthorized');
        }
    }
    
  
}
