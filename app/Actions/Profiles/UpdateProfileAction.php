<?php

namespace App\Actions\Profiles;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateProfileAction
{
    public function handle(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            if (isset($data['thumbnail']) && $data['thumbnail'] instanceof UploadedFile) {
                $data['thumbnail'] = $this->uploadThumbnail($user, $data['thumbnail']);
            }

            if (isset($data['full_name'])) {
                $user->update(['full_name' => $data['full_name']]);
            }

          $user->userProfile()->update([
            'gender'        => $data['gender'] ?? $user->userProfile->gender,
            'date_of_birth' => $data['date_of_birth'] ?? $user->userProfile->date_of_birth,
            'address'       => $data['address'] ?? $user->userProfile->address,
            'thumbnail'     => $data['thumbnail'] ?? $user->userProfile->thumbnail,
            'phone_number'  => $data['phone_number'] ?? $user->userProfile->phone_number,
        ]);

            return $user->load('userProfile');
        });
    }

    protected function uploadThumbnail(User $user, UploadedFile $file): string
    {
        $oldPath = $user->userProfile?->thumbnail;

        // Upload new file to S3 'thumbnails' folder
        $path = $file->store('thumbnails', 's3');

        // If upload is successful and an old thumbnail exists, delete it from S3
        if ($path && $oldPath) {
            Storage::disk('s3')->delete($oldPath);
        }

        return $path;
    }
}
