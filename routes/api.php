<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TravelTransactionController;
use App\Http\Controllers\UserController;

/* TODO: 
    1. Add middleware for role-based access control
    2. Ensure role-based middleware working as expected
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
    Route::middleware(['auth:api', 'refresh_token'])->group(function () {
        Route::post('/create', [CartController::class, 'create']);
        Route::post('/update-payment', [CartController::class, 'updatePayment']);
        Route::post('/create-payment/{Oid}', [CartController::class, 'createPayment']);
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

/*-------- Private routes --------*/

Route::group(['middleware' => ['auth:api', 'refresh_token']], function () {
    /*  Authentication
        Route::prefix('/auth')->group(function () {
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::post('/logout', [AuthController::class, 'logout']);
        });
    */

    /*  User 
        Route::prefix('/user')->group(function () {
            Route::post('/update', [UserController::class, 'update']);
            Route::post('/active', [UserController::class, 'toggleUserAccountStatus']);
            // Route::post('{userId}/assign-role', [UserController::class, 'assignRoleToUser']);
        });
    */

    /*  
        Route::prefix('/packages')->group(function () {
                // Why is viewing the package list and detail restricted to authenticated users?
                // Route::get('/list', [PackageController::class, 'list']);
                // Route::get('{Oid}', [PackageController::class, 'show']);
            Route::delete('{Oid}', [PackageController::class, 'delete']);
        });
    */

    /*
        Route::prefix('/cart')->group(function () {
            Route::post('/create', [CartController::class, 'create']);
            Route::post('/Update-Payment', [CartController::class, 'updatePayment']);
            Route::post('/Create-Payment/{Oid}', [CartController::class, 'createPayment']);
        });
    */

    /*  Travel Transaction
        Route::prefix('/admin')->group(function () {
            Route::prefix('/travelTransaction')->group(function () {
                Route::get('/list', [TravelTransactionController::class, 'list']);
                Route::get('{Oid}', [TravelTransactionController::class, 'show']);
                Route::post('{Oid}', [TravelTransactionController::class, 'save']);
            });
        });
    */

    /*  Unused Role based middleware?
        Route::middleware(['role:owner'])->group(function () {});
        Route::middleware(['role:admin'])->group(function () {});
        Route::middleware(['role:client'])->group(function () {});
    */
});

/*-------- Public routes --------*/

/*  Authentication
    Route::prefix('/auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
    });
*/

/*  Travel Packages
    Route::prefix('/packages')->group(function () {
        Route::get('/list', [PackageController::class, 'list']);
        Route::get('/{Oid}', [PackageController::class, 'show']);
    });
*/

/*  Homepage Travel Packages List
    Route::prefix('/homepage')->group(function () {
        Route::get('/favorites', [PackageController::class, 'favorites']);
        Route::get('/seasonal', [PackageController::class, 'seasonal']);
        Route::get('/custom', [PackageController::class, 'custom']);
        Route::get('/mustsee', [PackageController::class, 'mustsee']);
    });
*/

Route::post('/Callback-Payment', [CartController::class, 'updatePayment']);

/*  Itineraries
    Route::prefix('/combosource')->group(function () {
        Route::get('/itineraries', [ComboController::class, 'itineraries']);
    });
*/