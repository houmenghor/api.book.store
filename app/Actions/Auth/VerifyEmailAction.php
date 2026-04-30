<?php

namespace App\Actions\Auth;

use App\Models\User;


class VerifyEmailAction
{
    public function handle(?string $email, ?string $token)
    {
        if (!$email || !$token) {
            return null;
        }

        $user = User::where('email', $email)
            ->where('verification_token', $token)
            ->where('verification_token_expires_at', '>', now())
            ->first();
            

        if (!$user) return null;

        $user->update([
            'status' => true,
            'email_verified_at' => now(),
            'verification_token' => null,
            'verification_token_expires_at' => null,
        ]);

        return $user;
    }
}