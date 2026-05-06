<?php

namespace App\Http\Controllers\Api;

use App\Actions\Profiles\UpdateProfileAction;
use App\Actions\Queries\Profiles\GetProfileQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(GetProfileQuery $query, Request $request)
    {
        $response = $query->handle($request->user());
        return $this->success('Profile retrieved successfully!', new UserResource($response));
    }

    public function update(UpdateProfileRequest $request, UpdateProfileAction $action) 
    {
        $user = $request->user();
        $data = $request->validated();
        $action->handle($user, $data);

        return $this->success('Profile updated successfully!');
    }
}
