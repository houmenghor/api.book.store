<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SensitiveParameter;

class RegisterAction
{
    public function __construct(protected SendVerificationEmailAction $sendEmailAction) {}
    public function handle(array $data, #[SensitiveParameter] string $password): User
    {
        return DB::transaction(function () use ($data, $password) {

            $user = User::query()->create([
                "full_name" => $data["full_name"],
                "email" => $data["email"],
                "password" => Hash::make($password),
                "role_id" => 2,
                "status" => false,
                'pending_email' => null
            ]);

            $user->userProfile()->create([
                'user_id' => $user->id
            ]);

            $this->sendEmailAction->handle($user);

            return $user->load('userProfile', 'role');
        });
    }
}
