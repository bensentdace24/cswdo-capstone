<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // ✅ If not logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        // ✅ If logged in but not staff
        if ((int) Auth::user()->user_type != 2) {
            return redirect()->route('login')->with('error', 'Access denied. Staff only.');
        }

        return $next($request);
    }
}
