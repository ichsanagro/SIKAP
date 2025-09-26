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
        // Alias bawaan bisa ada di sini, tambahkan alias 'role'
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Jika Anda ingin menambahkan global middleware atau group middleware, lakukan di sini juga.
        // $middleware->append(\App\Http\Middleware\Something::class);
        // $middleware->web( ... );
        // $middleware->api( ... );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
