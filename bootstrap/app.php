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
        // Kerio Control gateway terminates TLS for ilm.uzkti.uz and forwards
        // plain HTTP to this app from its LAN-side interface. Trust it so
        // Laravel reads X-Forwarded-Proto/For/Host and generates correct
        // https:// URLs (assets, redirects) and the real client IP.
        $middleware->trustProxies(at: [
            '192.168.40.254',
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
