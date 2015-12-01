<?php

namespace Shuttle\Http;

use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Shuttle\Http\Middleware\AdminAuthentication;
use Shuttle\Http\Middleware\Authenticate;
use Shuttle\Http\Middleware\DriverAuthentication;
use Shuttle\Http\Middleware\DriverOrManagerAuthentication;
use Shuttle\Http\Middleware\ManagerAuthentication;
use Shuttle\Http\Middleware\RedirectIfAuthenticated;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Shuttle\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //\Shuttle\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => Authenticate::class,
        'auth.basic' => AuthenticateWithBasicAuth::class,
        'guest' => RedirectIfAuthenticated::class,
        'driver' => DriverAuthentication::class,
        'manager' => ManagerAuthentication::class,
        'admin' => AdminAuthentication::class,
        'manager|driver' => DriverOrManagerAuthentication::class,
    ];
}
