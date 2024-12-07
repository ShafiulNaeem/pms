<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\CheckAdminRoleMiddleware;
use App\Http\Middleware\CheckUserRoleMiddleware;

Route::group(['prefix' => 'api'], function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    # route for user
    Route::middleware(['auth:api', CheckUserRoleMiddleware::class])->group(function () {
        # route for product
        Route::get('/products', [ProductController::class, 'index']);
    });

    # route for admin
    Route::middleware(['auth:api', CheckAdminRoleMiddleware::class])->group(function () {
        Route::group(['prefix' => 'admin'], function () {
            # route for product
            Route::group(['prefix' => 'product'], function () {
                Route::get('/', [ProductController::class, 'index']);
                Route::get('/{id}', [ProductController::class, 'show']);
                Route::post('/', [ProductController::class, 'store']);
                Route::put('/{id}', [ProductController::class, 'update']);
                Route::delete('/{id}', [ProductController::class, 'destroy']);
            });
        });
    });
});
