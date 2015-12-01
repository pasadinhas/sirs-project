<?php

namespace Shuttle\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;

class DriverOrManagerAuthentication
{
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/');
            }
        }

        $user = $this->auth->user();

        if ($user->isDriver() || $user->isManager() || $user->isAdmin()) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
