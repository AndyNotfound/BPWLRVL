<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ComboController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TravelTransactionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\OptionalJwtAuth;
use Tymon\JWTAuth\Http\Middleware\AuthenticateOptional;

// Authentication
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    Route::middleware(['auth:api', 'refresh_token'])->group(function () {
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// Travel Packages Management
Route::prefix('/packages')->group(function () {
    // Client side
    Route::get('/favorites', [PackageController::class, 'favorites']);
    Route::get('/seasonal', [PackageController::class, 'seasonal']);
    Route::get('/custom', [PackageController::class, 'custom']);
    Route::get('/mustsee', [PackageController::class, 'mustsee']);
    Route::get('/stats', [PackageController::class, 'stats']);

    Route::get('/list', [PackageController::class, 'list']);
    Route::get('/{Oid}', [PackageController::class, 'show']);
    
    Route::middleware(['auth:api', 'role:admin', 'refresh_token'])->group(function () {
        Route::post('/save/{Oid?}', [PackageController::class, 'save']);
        Route::delete('{Oid}', [PackageController::class, 'delete']);
        
        Route::prefix('/admin')->group(function () {
            Route::get('/stats', [PackageController::class, 'adminStats']);
            Route::get('/top-packages', [PackageController::class, 'topPackages']);
        });
    });
});

// User Management
Route::prefix('/user')->group(function () {
    Route::get('/list', [UserController::class, 'list']);
    Route::middleware(['auth:api', 'refresh_token'])->group(function () {
        Route::get('/{userId}', [UserController::class, 'show']);

        Route::post('/active', [UserController::class, 'toggleUserAccountStatus']);
        Route::middleware(['role:admin', 'refresh_token'])->group(function () {
            Route::post('/update', [UserController::class, 'update']);
            Route::post('/assign-role/{userId}', [UserController::class, 'assignRoleToUser']);
        });
    });
});

// Cart Management
Route::prefix('/cart')->group(function () {
    Route::post('/create-payment/{Oid}', [CartController::class, 'createPayment']);
    Route::post('/create', [CartController::class, 'create'])->middleware(OptionalJwtAuth::class);

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
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/list', [TravelTransactionController::class, 'userTravelTransactions']);
    });
    Route::middleware(['auth:api', 'role:admin', 'refresh_token'])->group(function () {
        Route::prefix('/admin')->group(function () {
            Route::get('/sales-overview', [TravelTransactionController::class, 'salesOverview']);
            Route::get('/weekly-earnings', [TravelTransactionController::class, 'weeklyStats']);

            Route::get('/stats', [TravelTransactionController::class, 'adminStats']);
            Route::get('/list', [TravelTransactionController::class, 'list']);
            Route::get('{Oid}', [TravelTransactionController::class, 'show']);
            Route::post('/save/{Oid?}', [TravelTransactionController::class, 'save']);
        });
    });
});

// Itineraries Management
Route::prefix('/itineraries')->group(function () {
    Route::get('/list', [ItinerariesController::class, 'list']);
    Route::get('/{Oid}', [ItinerariesController::class, 'show']);
    Route::get('/combosource', [ComboController::class, 'itineraries']);

    Route::middleware(['auth:api', 'role:admin', 'refresh_token'])->group(function () {
        Route::post('/save/{Oid?}', [ItinerariesController::class, 'save']);
        Route::delete('{Oid}', [ItinerariesController::class, 'delete']);
    });
});


// Review Management
Route::prefix('/review')->group(function () {
    Route::get('/', [ReviewController::class, 'index']);
    Route::get('/list', [ReviewController::class, 'listGlobal']);
    Route::get('/list/{Package}', [ReviewController::class, 'list']);
    Route::middleware(['auth:api', 'refresh_token'])->group(function () {
        Route::post('/save/{Oid?}', [ReviewController::class, 'save']);
        Route::get('/{Oid}', [ReviewController::class, 'show']);
        Route::middleware(['role:admin', 'refresh_token'])->group(function () {});
    });
});


// Default Xendit Callback URL, see TODO above
Route::post('/Callback-Payment', [CartController::class, 'updatePayment']);
