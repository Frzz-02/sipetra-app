<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Daftar middleware alias kamu di sini
        $middleware->alias([
            'penyedia' => \App\Http\Middleware\PenyediaMiddleware::class,
            'user'     => \App\Http\Middleware\UserMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Bisa kosong atau isi custom error handler
    })
    ->create();
