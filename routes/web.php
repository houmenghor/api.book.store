<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the API Book Store!',
        'status' => 'success',
        'version' => '1.0',
        // 'documentation' => url('/docs'),
    ]);
});

Route::get('/verify-email', function () {
    return view('auth.verify-result', [
        'status' => request()->query('status'),
        'message' => request()->query('message', 'Email verified successfully! You can now close this window.')
    ]);
});
