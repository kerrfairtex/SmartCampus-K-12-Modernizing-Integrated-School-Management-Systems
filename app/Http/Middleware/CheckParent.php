<?php

namespace App\Http\Middleware;

use Closure;

class CheckParent
{
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->hasRole('parent')) {
            return $next($request);
        }
        return redirect('home');
    }
}
