<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class admin
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status == 1) {
            return $next($request);
        }

        return redirect('/');
    }
}
