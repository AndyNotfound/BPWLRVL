<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TravelTransactionController;
use App\Http\Controllers\UserController;

/* TODO: 
    1. Add middleware for role-based access control [DONE]
    2. Ensure role-based middleware working as expected [DONE]
*/

// Authentication
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');

    Route::middleware(['auth:api', 'refresh_token'])->group(function () {
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// Travel Packages Management
Route::prefix('/packages')->group(function () {
    Route::get('/list', [PackageController::class, 'list']);
    Route::get('/favorites', [PackageController::class, 'favorites']);
    Route::get('/seasonal', [PackageController::class, 'seasonal']);
    Route::get('/custom', [PackageController::class, 'custom']);
    Route::get('/mustsee', [PackageController::class, 'mustsee']);
    Route::get('/stats', [PackageController::class, 'stats']);

    Route::get('/{Oid}', [PackageController::class, 'show']);

    Route::middleware(['auth:api', 'role:admin', 'refresh_token'])->group(function () {
        Route::delete('{Oid}', [PackageController::class, 'delete']);
    });
});

// User Management
Route::prefix('/user')->group(function () {
    Route::middleware(['auth:api', 'role:admin', 'refresh_token'])->group(function () {
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/active', [UserController::class, 'toggleUserAccountStatus']);
        Route::post('/assign-role/{userId}', [UserController::class, 'assignRoleToUser']);
    });
});

// Cart Management
Route::prefix('/cart')->group(function () {
    Route::post('/create', [CartController::class, 'create']);
    Route::post('/create-payment/{Oid}', [CartController::class, 'createPayment']);
    
    Route::middleware(['auth:api', 'refresh_token'])->group(function () {
        Route::post('/update-payment', [CartController::class, 'updatePayment']);
        /* TODO:
            Ubah callback nya di xendit lagi berarti?
            Karena url nya dari /callback-payment ke cart/callback-payment
        */
        Route::post('/callback-payment', [CartController::class, 'updatePayment']);
    });
});

// Travel Transaction Management
Route::prefix('/travel-transaction')->group(function () {
    Route::middleware(['auth:api', 'role:admin', 'refresh_token'])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('/list', [TravelTransactionController::class, 'list']);
            Route::get('{Oid}', [TravelTransactionController::class, 'show']);
            Route::post('{Oid}', [TravelTransactionController::class, 'save']);
        });
    });
});

// Itineraries Management
Route::prefix('/itineraries')->group(function () {
    Route::get('/combosource', [ComboController::class, 'itineraries']);
});


// Default Xendit Callback URL, see TODO above
Route::post('/Callback-Payment', [CartController::class, 'updatePayment']);