<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::prefix('auth')->group(function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('refresh-token', [UserController::class, 'refreshToken']);
});

Route::post('password/reset/link', [UserController::class, 'passwordResetLink']);
Route::post('password/reset', [UserController::class, 'resetPassword'])->name('password.reset');

// Secure routes within auth middleware
Route::middleware('auth:api')->group(function() {
    Route::get('me', [UserController::class, 'me']);
    //    Route::get('user', [UserController::class, 'getUsers']);
    Route::post('logout', [UserController::class, 'logout']);
});
