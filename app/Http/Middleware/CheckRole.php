<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        dd($user);
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
