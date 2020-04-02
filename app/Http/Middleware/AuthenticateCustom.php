<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
          return redirect()->guest(route('sessions.create'));
        }

        return $next($request);
    }
}
