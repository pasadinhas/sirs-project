<?php

namespace ShuttleCli\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class BusDriver
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
        if ( ! Cache::has('session.key'))
        {
            return redirect('/')->with('error', 'You must log in in order to view that page.');
        }
        return $next($request);
    }
}
