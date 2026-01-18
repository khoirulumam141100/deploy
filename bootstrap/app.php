<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ApprovedMiddleware;
use App\Http\Middleware\WargaMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register custom middleware aliases
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'warga' => WargaMiddleware::class,
            'approved' => ApprovedMiddleware::class,
            // Legacy alias for backward compatibility
            'member' => WargaMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
