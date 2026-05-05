<?php

namespace App\Actions\Auth\Otp;

use App\Helpers\ValidationHelper;
use App\Mail\SendOtp;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class SendOtpAction
{
    public function handle(string $email, string $purpose, ?User $user)
    {
        $email = strtolower($email);

        $throttleKey = 'send-otp:' . $email . ':' . $purpose;

        if (RateLimiter::tooManyAttempts($throttleKey, 1)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            ValidationHelper::throwError(
                message: "We've sent a code recently. Please wait a moment.",
                data: ['retry_after' => $seconds],
                statusCode: 429
            );
        }

        //delete the old otp before request new 
        OtpCode::query()->where('email', $email)
            ->where('purpose', $purpose)
            ->delete();

        $code = (string) rand(100000, 999999);

        $otpCode = OtpCode::query()->create([
            'user_id' => $user?->id,
            'email' => $email,
            'code' => Hash::make($code),
            'purpose' => $purpose,
            'expires_at' => now()->addMinutes(10),
            'attempts' => 0
        ]);

        RateLimiter::hit($throttleKey, 60);

        Mail::to($email)->queue(new SendOtp($otpCode, $user->full_name, $code));
    }
}
