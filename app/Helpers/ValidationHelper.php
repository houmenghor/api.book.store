<?php

namespace App\Helpers;

use Illuminate\Http\Exceptions\HttpResponseException;

class ValidationHelper
{
    public static function throwError(string $message = '', int $statusCode = 400, mixed $data = null)
    {
        $response = [
            'status'  => 'error',
            'message' => $message,
        ];

        // This stays the same: it only adds 'data' if $data is not null
        if (!is_null($data)) {
            $response['data'] = $data;
        }

        throw new HttpResponseException(
            response()->json($response, $statusCode)
        );
    }
}
