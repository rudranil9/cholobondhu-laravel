<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'security.headers' => \App\Http\Middleware\SecurityHeaders::class,
            'user.active' => \App\Http\Middleware\CheckUserActive::class,
        ]);
        
        // Add security headers to all requests
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        
        // Check if authenticated users are still active on protected routes
        $middleware->web(append: [
            \App\Http\Middleware\CheckUserActive::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
