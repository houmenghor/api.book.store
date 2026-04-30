<?php

namespace App\Actions\Auth;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Str;

class SendVerificationEmailAction
{
    public function handle(User $user)
    {
        $user->update([
            'verification_token' => Str::random(60),
            'verification_token_expires_at' => now()->addMinutes(1),

        ]);

        $url = url("/api/v1/auth/verify-email/{$user->verification_token}?email=" . urlencode($user->email));

        Mail::to($user->email)->queue(new VerifyEmail($url, $user->full_name));

    }
}