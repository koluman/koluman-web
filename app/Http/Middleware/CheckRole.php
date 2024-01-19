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
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }
    
        $user = auth()->user();
        dd($user, $roles);
        // Kullanıcı modelinde role alanının olup olmadığını ve dolu mu kontrol et
    }
}
