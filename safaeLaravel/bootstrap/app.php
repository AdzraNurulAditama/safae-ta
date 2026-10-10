<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // =========================
        // AKTIFKAN CORS (WAJIB UNTUK FLUTTER WEB)
        // =========================
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);

        // =========================
        // ALIAS MIDDLEWARE CUSTOM
        // =========================
        $middleware->alias([
            'admin.api' => \App\Http\Middleware\AdminApi::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
