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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Exclude webhook endpoint from CSRF verification
        // Webhook dipanggil oleh server Mayar, bukan browser dengan session aktif
        $middleware->validateCsrfTokens(except: [
            'webhooks/mayar',
            'webhooks/mayar/boost',
        ]);

        // Trust all proxies (ngrok, load balancer, etc.)
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

