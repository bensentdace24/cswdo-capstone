<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Only allow admin (user_type = 1)
        if ((int) Auth::user()->user_type !== 1) {
            abort(403);
        }

        return $next($request);
    }
}



