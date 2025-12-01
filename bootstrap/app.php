<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

    // ===== Aliases =====
    $middleware->alias([
        'auth'              => \App\Http\Middleware\Authenticate::class,
        'dashboard.access'  => \App\Http\Middleware\DashboardAccessMiddleware::class,
        'dashboard.locales' => \App\Http\Middleware\DashboardLocaleMiddleware::class,
        'api.locales'       => \App\Http\Middleware\ApiLocalesMiddleware::class,
        'frontend.locales'  => \App\Http\Middleware\FrontendLocaleMiddleware::class,
        'frontend.auth'     => \App\Http\Middleware\AuthenticateFrontEnd::class,
        'frontend.guest'    => \App\Http\Middleware\RedirectToFrontendIfAuth::class,
        'frontend.login'    => \App\Http\Middleware\ForntendLoginMiddleware::class,

        'isAdmin'           => \App\Http\Middleware\isAdmin::class,
        'isUser'            => \App\Http\Middleware\isUser::class,
        'isWasher'          => \App\Http\Middleware\isWasher::class,
    ]);


    // ===== Groups =====
    $middleware->group('web', [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    $middleware->group('api', [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        'throttle:api',
        'api.locales',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ]);

    $middleware->group('dashboard', [
        'auth',
        'dashboard.access',
        'dashboard.locales',
    ]);
})

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
