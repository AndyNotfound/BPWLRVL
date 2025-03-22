<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::group(['middleware' => ['auth:api']], function() {
    Route::middleware(['role:owner'])->group(function () {
        // Owner role
    });

    Route::middleware(['role:admin'])->group(function () {
        // Admin role
    });
    
    Route::middleware(['role:client'])->group(function () {
        // Client role
        Route::get('/test', [TestController::class, 'index']);
    });
});

Route::post('/login', [AuthController::class, 'login']);

// Route::post('/users/{userId}/assign-role', [UserController::class, 'assignRoleToUser']);