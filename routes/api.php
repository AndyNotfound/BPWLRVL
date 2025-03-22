<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\AuthController;


// Authenticated routes
Route::group(['middleware' => ['auth:api']], function () {
    Route::middleware(['role:owner'])->group(function () {
        // Owner authenticated
    });

    Route::middleware(['role:admin'])->group(function () {
        // Admin authenticated
    });

    Route::middleware(['role:client'])->group(function () {
        // Client authenticated
        Route::get('/test', [TestController::class, 'index']);
    });
});

// Unauthenticated routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/register', [AuthController::class, 'register']);
});

/*
    use App\Http\Controllers\UserController;
    Route::post('/users/{userId}/assign-role', [UserController::class, 'assignRoleToUser']);
*/