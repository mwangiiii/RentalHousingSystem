<?php

use App\Http\Middleware\CheckSuspended;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\LockScreenMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->append([LockScreenMiddleware::class]);
        $middleware->alias([
            'is-suspended'=>CheckSuspended::class
        ]);
        $middleware->validateCsrfTokens(except: [
            'tenant/payments/response'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
