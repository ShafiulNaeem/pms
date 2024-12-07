<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Middleware\CheckAdminRoleMiddleware;
use App\Http\Middleware\CheckUserRoleMiddleware;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\PaymentController;

Route::group(['prefix' => 'api'], function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    # route for stripe 
    Route::get('/payment-success', [PaymentController::class, 'success'])->name('stripe.success');
    Route::get('/payment-failure', [PaymentController::class, 'fail'])->name('stripe.fail');

    # route for user
    Route::middleware(['auth:api', CheckUserRoleMiddleware::class])->group(function () {
        # route for product
        Route::get('/products', [ProductController::class, 'index']);
        # route for order
        Route::group(['prefix' => 'orders'], function () {
            Route::post('/', [OrderController::class, 'store']);
            Route::get('/', [OrderController::class, 'index']);
        });
        # route for payment
        Route::post('/pay', [PaymentController::class, 'pay']);
    });

    # route for admin
    Route::middleware(['auth:api', CheckAdminRoleMiddleware::class])->group(function () {
        Route::group(['prefix' => 'admin'], function () {
            # route for product
            Route::group(['prefix' => 'product'], function () {
                Route::get('list', [ProductController::class, 'index']);
                Route::get('show/{id}', [ProductController::class, 'show']);
                Route::post('store', [ProductController::class, 'store']);
                Route::put('update/{id}', [ProductController::class, 'update']);
                Route::delete('delete/{id}', [ProductController::class, 'destroy']);
            });
        });
    });
});
