<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = Auth::user()->role;
        dd($userRole);
        /*if ($user) {
            foreach ($roles as $role) {
                if ($user->backuser_role === $role) {
                    return $next($request);
                }
            }

            // Yetkisi yoksa HTTP 403 hatası döndür
            abort(403, 'Unauthorized action.');
        }

        // Giriş yapmamışsa ana sayfaya yönlendir
        return redirect('/');*/
    }
}
