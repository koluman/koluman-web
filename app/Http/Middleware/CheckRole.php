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
        // Kullanıcının oturum açtığını kontrol et
        /*if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }
    
        // Kullanıcı modelinde role alanının olup olmadığını ve dolu mu kontrol et
        $user = auth()->user();
        if (!$user || !property_exists($user, 'backuser_role') || is_null($user->backuser_role)) {
            abort(403, 'Unauthorized');
        }
    
        // Verilen roller arasında kullanıcının rolü var mı kontrol et
        if (in_array($user->backuser_role, $roles)) {
            return $next($request);
        }
    
        // Yetki yoksa isteği reddet
        abort(403, 'Unauthorized');*/
        dd(auth()->user());
    }
    
    
}
