<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TravelTransactionController;
use App\Http\Controllers\UserController;

// Unauthenticated routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/Callback-Payment', [CartController::class, 'updatePayment']);

// Authenticated routes
Route::group(['middleware' => ['auth:api', 'refresh_token']], function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // User 
    Route::prefix('/user')->group(function () {
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/active', [UserController::class, 'toggleUserAccountStatus']);
    });

    Route::prefix('/homepage')->group(function () {
        Route::get('/favorites', [PackageController::class, 'favorites']);
        Route::get('/seasonal', [PackageController::class, 'seasonal']);
        Route::get('/custom', [PackageController::class, 'custom']);
        Route::get('/mustsee', [PackageController::class, 'mustsee']);
    });

    Route::prefix('/packages')->group(function () {
        Route::get('/list', [PackageController::class, 'list']);
        Route::get('{Oid}', [PackageController::class, 'show']);
        Route::get('{Oid?}', [PackageController::class, 'save']);
        Route::delete('{Oid}', [PackageController::class, 'delete']);
    });

    Route::prefix('/cart')->group(function () {
        Route::post('/create', [CartController::class, 'create']);
        Route::post('/Update-Payment', [CartController::class, 'updatePayment']);
        Route::post('/Create-Payment/{Oid}', [CartController::class, 'createPayment']);
    });

    Route::prefix('/admin')->group(function () {
        Route::prefix('/travelTransaction')->group(function () {
            Route::get('/list', [TravelTransactionController::class, 'list']);
            Route::get('{Oid}', [TravelTransactionController::class, 'show']);
            Route::post('{Oid}', [TravelTransactionController::class, 'save']);
        });
    });


    Route::middleware(['role:owner'])->group(function () {
    });

    Route::middleware(['role:admin'])->group(function () {
    });

    Route::middleware(['role:client'])->group(function () {
    });
});

Route::prefix('/combosource')->group(function () {
    Route::get('/itineraries', [ComboController::class, 'itineraries']);
});

/* 
    Assign role to user
    use App\Http\Controllers\UserController;
    Route::post('/users/{userId}/assign-role', [UserController::class, 'assignRoleToUser']);
*/