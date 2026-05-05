<?php

namespace App\Actions\Auth\Oauth;

use App\Helpers\ValidationHelper;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class GoogleCallbackAction
{
    public function handle(): array
    {
        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        $driver = Socialite::driver('google');

        $googleUser = $driver->stateless()->user();
        if (empty($googleUser->getEmail())) {
            ValidationHelper::throwError('No email returned from Google.');
        }

        return DB::transaction(function () use ($googleUser) {

            $user = User::query()->where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::query()->create([
                    'full_name'         => $googleUser->getName(),
                    'email'             => $googleUser->getEmail(),
                    'role_id'           => 2,
                    'email_verified_at' => now(),
                    'status'            => true,
                    'pending_email'     => null
                ]);

                $user->userProfile()->create([
                    'user_id' => $user->id,
                    'thumbnail' => $googleUser->getAvatar()
                ]);
            }

            $user->socialAccounts()->updateOrCreate(
                ['provider_name' => 'google'],
                [
                    'provider_user_id' => $googleUser->getId(),
                    'provider_email' => $googleUser->getEmail(),
                    'provider_avatar' => $googleUser->getAvatar()
                ]
            );

            $token = $user->createToken('GoogleAuth');

            return [
                'user' => $user->load('userProfile', 'role'),
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => $token->token->expires_at->toDateTimeString()
            ];
        });
    }
}
