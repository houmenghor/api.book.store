<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::prefix('v1/')->group(function () {
    Route::prefix('/auth')->group(function () {

        Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.token.refresh');

        Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('auth.email.verify');
        Route::post('/resend-verification', [AuthController::class, 'resendVerification'])->name('auth.email.resend');

        Route::get('/google/redirect', [AuthController::class, 'googleRedirect'])->name('auth.google.redirect');
        Route::get('/google/callback', [AuthController::class, 'googleCallback'])->name('auth.google.callback');

        Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
    });
});
