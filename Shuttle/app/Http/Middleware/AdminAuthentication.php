<?php

namespace Shuttle\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class AdminAuthentication
{
    protected $auth;
    protected $user;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->user = $this->auth->user;
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

        if ( $this->user->isAdmin() ) {
            return $next($request);
        } else {
            return redirect('/');
        }

    }
}
