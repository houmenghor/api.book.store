<?php

namespace App\Actions\Auth\Otp;

use App\Helpers\ValidationHelper;
use App\Models\OtpCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VerifyOtpAction
{
    public function handle(string $email, string $code, string $purpose)
    {
        $otpCode = OtpCode::query()
            ->where('email', $email)
            ->where('purpose', $purpose)
            ->latest()
            ->first();

        if (!$otpCode) {
            ValidationHelper::throwError(
                'The verification code does not exist.',
                404
            );
        }

        if ($otpCode->isExpired()) {
            ValidationHelper::throwError(
                'The verification code has expired.',
                410
            );
        }

        if ($otpCode->tooManyAttempts()) {
            ValidationHelper::throwError(
                'Too many failed attempts. Please request a new code.',
                429
            );
        }

        if (!Hash::check($code, $otpCode->code)) {
            $otpCode->increment('attempts');
            ValidationHelper::throwError(
                'Invalid verification code.',
                422
            );
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $otpCode->delete();

        return $token;
    }
}
