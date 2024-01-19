<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
       if (Auth::check()) {
            $user = Auth::user();
            foreach ($roles as $role) {
                if ($user->backuser_role === $role) {
                    return $next($request);
                }
            }
            // Yetkisi yoksa HTTP 403 hatası döndür
            abort(403, 'Unauthorized action.');
        }
        
        // Giriş yapmamışsa ana sayfaya yönlendir
        return redirect('/');
        
    }
}
