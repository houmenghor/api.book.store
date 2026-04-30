<?php

namespace App\Actions\Auth;

use App\Helpers\ValidationHelper;
use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ResendVerificationAction
{
    public function __construct(protected SendVerificationEmailAction $sendEmailAction)
    {
        
    }
    public function handle(string $email)
    {
        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            ValidationHelper::throwValidation('email', 'User with this email does not exist.');
        }

        if ($user->email_verified_at) {
            ValidationHelper::throwValidation('email', 'This account is already verified.');
        }

        $this->sendEmailAction->handle($user);
    }
}