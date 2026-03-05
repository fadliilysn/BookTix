<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            'webhook/midtrans',
        ]);

        $middleware->web(append: [
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->redirectGuestsTo(function ($request) {
            // Kalau akses /admin/* tapi belum login, ke admin login
            if ($request->is('admin/*')) {
                return route('admin.login');
            }
            return route('login');
        });

        $middleware->redirectUsersTo(function (Request $request) {
            if (auth()->check() && !auth()->user()->hasVerifiedEmail()) {
                return route('verification.notice');
            }

            if (auth()->check() && auth()->user()->role === 'admin') {
                return route('admin.dashboard');
            }

            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
