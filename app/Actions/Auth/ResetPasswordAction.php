<?php

namespace App\Actions\Auth;

use App\Helpers\ValidationHelper;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SensitiveParameter;
class ResetPasswordAction
{
    public function handle(string $email, string $token, #[SensitiveParameter] string $newPassword)
    {
        $getToken = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        //  check token exists or not
        if (!$getToken || !Hash::check($token, $getToken->token)) {
            ValidationHelper::throwError('Invalid or expired reset token.', 422);
        }

        $isExpired = now()->subMinutes(15)->gt($getToken->created_at);
        if ($isExpired) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            ValidationHelper::throwError('Reset session expired. Please start over.', 400);
        }

        //  update password
        $user = User::query()->where('email', $email)->first();
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return $user;
    }
}