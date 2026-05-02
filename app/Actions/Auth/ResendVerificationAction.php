<?php

namespace App\Actions\Auth;

use App\Helpers\ValidationHelper;
use App\Models\User;

class ResendVerificationAction
{
    public function __construct(protected SendVerificationEmailAction $sendEmailAction)
    {
        
    }
    public function handle(string $email)
    {
        $user = User::query()->where('email', $email)->first();

        if (!$user) {
            ValidationHelper::throwError('User with this email does not exist.', 401);
        }

        if ($user->email_verified_at) {
            ValidationHelper::throwError('This account is already verified.', 400);
        }

        $this->sendEmailAction->handle($user);
    }
}