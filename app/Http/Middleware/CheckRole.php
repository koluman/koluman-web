<?php
// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if the user is authenticated
        /*if (!Auth::check()) {
            return redirect()->route('signin');
        }

        // Retrieve the user's role from the session
        $userRole = session('role');

        // Check if the user has the required role
        if (!in_array($userRole, $roles)) {
            // Redirect or handle unauthorized access as needed
            return redirect()->route('signin')->with('error', 'Unauthorized access.');
        }

        return $next($request);*/
        dd( Auth::guard('api')->check() );
    }
}
