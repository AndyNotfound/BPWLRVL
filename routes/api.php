<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\AuthController;

// Authenticated routes
Route::group(['middleware' => ['auth:api', 'refresh_token']], function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/* 
    Assign role to user
    use App\Http\Controllers\UserController;
    Route::post('/users/{userId}/assign-role', [UserController::class, 'assignRoleToUser']);
*/