<?php

namespace App\Actions\Auth;

use App\Actions\Auth\Otp\SendOtpAction;
use App\Models\User;

class ForgotPasswordAction
{
    public function __construct(protected SendOtpAction $sendOtp)
    {
    }
    public function handle(string $email, string $purpose)
    {
        $user = User::query()->where('email', $email)->first();

        $this->sendOtp->handle($email, $purpose, $user);
        return $user;
    }
}