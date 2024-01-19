<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
      
    
        $user = Auth::user();
        dd($request,$next, $roles);
        // Kullanıcı modelinde role alanının olup olmadığını ve dolu mu kontrol et
    }
}
