<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::prefix('v1/')->group(function () {

    // --- PUBLIC AUTH ROUTES ---
    Route::prefix('/auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
        Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.token.refresh');

        // Email & Password recovery 
        Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('auth.email.verify');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('auth.forgot.password');
        Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify.otp');
        Route::put('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset.password');

        // Social Auth
        Route::get('/google-redirect', [AuthController::class, 'googleRedirect'])->name('auth.google.redirect');
        Route::get('/google-callback', [AuthController::class, 'googleCallback'])->name('auth.google.callback');
    });

    // --- PROTECTED ROUTES (Requires access_token) ---
    Route::middleware('auth:api')->group(function () {

        // Auth management
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // Profile / Me Routes
        Route::prefix('/me')->group(function () {
            // Route::get('/', [ProfileController::class, 'show']);
            // Route::put('/update', [ProfileController::class, 'update']); 
            // Route::post('/change-email', [ProfileController::class, 'changeEmail']);
            // Route::post('/change-password', [ProfileController::class, 'changePassword']);
        });

        // --- ADMIN ONLY ROUTES ---
        // This group uses a second middleware to check the role
        Route::middleware('isAdmin')->prefix('/admin')->group(function () {
            Route::get('/test', function () {
                return response()->json([
                    'message' => 'Endpoint for admin',
                    'status' => 'success'
                ]);
            });
        });
    });
});
