<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
        'phone_number',
        'address',
        'thumbnail',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    const GENDER_PREFER_NOT_TO_SAY = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
}
