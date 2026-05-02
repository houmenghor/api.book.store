<?php

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;

class ValidationHelper
{
    public static function throwError(string $message = 'Invalid credentials.', int $statusCode = 401)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => $message,
            ], $statusCode)
        );
    }
}