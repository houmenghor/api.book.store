<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'full_name' => $this->full_name,
            'email' => $this->email,
            'role' => [
                'id' => $this->role->id,
                'name' => $this->role->name
            ],
            'status' => $this->status,
            'pending_email' => $this->pending_email,
            // 'email_verified_at' => $this->email_verified_at,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
            'userProfile' => [
                'gender' => $this->userProfile->gender,
                'date_of_birth' => $this->userProfile->date_of_birth,   
                'phone_number' => $this->userProfile->phone_number,
                'address' => $this->userProfile->address,
                'thumbnail' => $this->userProfile->thumbnail 
                                ? Storage::disk('s3')->url($this->userProfile->thumbnail) 
                                : null,
                'created_at' => $this->userProfile->created_at,
                'updated_at' => $this->userProfile->updated_at
            ]
        ];
    }
}
