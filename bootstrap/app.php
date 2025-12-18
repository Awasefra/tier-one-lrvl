<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {

            if (! $request->expectsJson()) {
                return null;
            }

            // 404 - model not found
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'meta' => [
                        'success' => false,
                        'message' => 'Resource not found',
                    ],
                    'data' => null,
                ], 404);
            }

            // HTTP errors (403, 401, etc)
            if ($e instanceof HttpExceptionInterface) {
                return response()->json([
                    'meta' => [
                        'success' => false,
                        'message' => $e->getMessage() ?: 'Request failed',
                    ],
                    'data' => null,
                ], $e->getStatusCode());
            }

            // fallback 500
            return response()->json([
                'meta' => [
                    'success' => false,
                    'message' => 'Internal server error',
                ],
                'data' => null,
            ], 500);
        });
    })->create();
