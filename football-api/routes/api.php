<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::prefix('auth')->group(function () {
    Route::post('register', \App\Http\Controllers\Api\User\RegisterPostController::class);
    Route::post('login', \App\Http\Controllers\Api\LoginPostController::class);
    Route::post('refresh-token', [UserController::class, 'refreshToken']);
});

Route::post('password/reset/link', [UserController::class, 'passwordResetLink']);
Route::post('password/reset', [UserController::class, 'resetPassword'])->name('password.reset');

// Secure routes within auth middleware
Route::middleware('auth:api')->group(function() {
//    Route::group(['middleware' => ['role:super_admin|admin']], function () {
//    });

    Route::prefix('competitions')->group(function () {
        Route::get('/', \App\Http\Controllers\Api\Competition\AllGetController::class);
        Route::get('/{id}', \App\Http\Controllers\Api\Competition\FindGetController::class);
    });

    Route::get('me', [UserController::class, 'me']);
    //    Route::get('user', [UserController::class, 'getUsers']);
    Route::post('logout', [UserController::class, 'logout']);
});
