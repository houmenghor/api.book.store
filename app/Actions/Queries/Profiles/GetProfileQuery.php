<?php

namespace App\Actions\Queries\Profiles;

use App\Models\User;

class GetProfileQuery
{
    public function handle(User $user): User
    {
        return $user->load(['role', 'userProfile']);
    }
}