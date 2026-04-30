<?php

namespace App\Helpers;

use Illuminate\Validation\ValidationException;

class ValidationHelper
{
    public static function throwValidation(string $field, string $message)
    {
        throw ValidationException::withMessages([
            $field => [$message],
        ]);
    }
}