<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $this->authenticate($request);
    
        // Kullanıcıyı al
        $user = auth('web')->user();
    
        if (!$user) {
            // Kullanıcı oturumu açık değilse, 401 hatası döndür
            abort(401, 'Unauthorized');
        }
    
        // Kullanıcının yetkilerini kontrol et
        foreach ($roles as $role) {
            // Kullanıcının rolü, verilen rollerden birine eşitse, middleware'ı geç
            if (isset($user['role']) && $user['role'] === $role) {
                return $next($request);
            }
        }
    
        // Kullanıcının yetkisi yoksa 403 hatası döndür
        return abort(403, 'Unauthorized action.');
    }
    
    // CheckRole middleware içinde kullanım örneği
    public function authenticate($request)
    {
      
        if (!auth('web')->check()) {
            abort(401, 'Unauthorized');
        }
    }
}
