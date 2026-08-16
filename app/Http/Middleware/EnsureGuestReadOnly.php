<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureGuestReadOnly
{
    /**
     * A guest account may browse every section but never write:
     * block any non-read HTTP method (POST/PUT/PATCH/DELETE) globally.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'guest'
            && ! in_array($request->method(), ['GET', 'HEAD', 'OPTIONS'])) {
            abort(403, 'Read-only guest account: actions are disabled.');
        }

        return $next($request);
    }
}
