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
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Suppress broken pipe notices from Laravel's development server
        // This occurs when clients disconnect before the server finishes writing to stdout
        if (PHP_SAPI === 'cli-server') {
            set_error_handler(function ($errno, $errstr, $errfile, $errline) {
                // Suppress broken pipe errors (errno 32) from server.php
                if ($errno === E_NOTICE && strpos($errstr, 'Broken pipe') !== false) {
                    return true; // Suppress the error
                }
                return false; // Use default error handler for other errors
            }, E_NOTICE);
        }
    })->create();
