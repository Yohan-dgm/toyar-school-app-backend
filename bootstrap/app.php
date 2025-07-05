<?php

use App\Middleware\AuthGuard;
use App\Middleware\GlobalResponseMiddleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('api/general-entity-management')->group(base_path('modules/GeneralEntityManagement/routes.php'));
            Route::prefix('api/user-management')->group(base_path('modules/UserManagement/routes.php'));
            Route::middleware('api/calendar-management')->group(base_path('modules/CalendarManagement/routes.php'));

        },
    )
    ->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
        // ['prefix' => 'api', 'middleware' => ['api', 'auth:sanctum']],
        ['prefix' => 'api', 'middleware' => ['api', AuthGuard::class]],
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(GlobalResponseMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (AuthenticationException $e, Request $request) { // status code is always 401 because we check AuthenticationException class
            if ($request->is('api/*')) {
                return response()->json(
                    [
                        "status" => "authentication-required",
                        "message" => "",
                        "data" => null,
                        "metadata" => null,
                    ],
                    401
                );
            }
        });
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($request->is('api/*') && $e->getStatusCode() == 419) {
                return response()->json(
                    [
                        "status" => "authentication-required",
                        "message" => "tm",
                        "data" => null,
                        "metadata" => null,
                    ],
                    419
                );
            }
            if ($request->is('api/*') && $e->getStatusCode() == 429) {
                return response()->json(
                    [
                        "status" => "too-many-requests",
                        "message" => "Too many requests, please try again in a few minutes.",
                        "data" => null,
                        "metadata" => null,
                    ],
                    429
                );
            }
        });
    })
    ->create();
