<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        /*if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
    
            foreach ($roles as $role) {
                if ($user->backuser_role === $role) {
                    return $next($request);
                }
            }
    
            // If the user does not have the required role, return a 403 error
            abort(403, 'Unauthorized action.');
        }
   
        
        // Giriş yapmamışsa ana sayfaya yönlendir
        return redirect('/'); */
        $this->authenticate($request);

        // Kullanıcıyı al
        $user = auth('web')->user();

        /*foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        // Kullanıcının yetkisi yoksa 403 hatası döndür
        return abort(403, 'Unauthorized action.');*/

        dd($user);
    }
    // CheckRole middleware içinde kullanım örneği
    public function authenticate($request)
    {
      
        if (!auth('web')->check()) {
            abort(401, 'Unauthorized');
        }
    }
}
