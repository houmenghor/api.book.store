<?php

namespace App\Actions\Auth\Oauth;

use Laravel\Socialite\Facades\Socialite;

class GoogleRedirectAction
{
    public function handle(): string
    {
        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        $driver = Socialite::driver('google');

        return $driver->stateless()
            ->redirect()
            ->getTargetUrl();
    }
}
