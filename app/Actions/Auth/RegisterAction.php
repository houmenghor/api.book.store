<?php

namespace App\Actions\Auth;

use App\Mail\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use SensitiveParameter;
use Str;
use function Illuminate\Support\now;

class RegisterAction
{
    public function __construct(protected SendVerificationEmailAction $sendEmailAction)
    {

    }
    public function handle(array $data, #[SensitiveParameter] string $password): array
    {
        $user = User::query()->create([
            "full_name" => $data["full_name"],
            "email" => $data["email"],
            "password" => Hash::make($password),
            "role_id" => 2,
            "status" => false
        ]);
        
        $this->sendEmailAction->handle($user);

        return ["user" => $user];
    }
}