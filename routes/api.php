<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Authenticated routes
Route::group(['middleware' => ['auth:api', 'refresh_token']], function () {
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // User 
    Route::prefix('/user')->group(function () {
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/active', [UserController::class, 'toggleUserAccountStatus']);
    });

    Route::middleware(['role:owner'])->group(function () {
        // Owner authenticated
    });

    Route::middleware(['role:admin'])->group(function () {
        // Admin authenticated
    });

    Route::middleware(['role:client'])->group(function () {
        // Client authenticated
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