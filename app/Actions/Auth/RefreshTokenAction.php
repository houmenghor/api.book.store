<?php

namespace App\Actions\Auth;

use App\Helpers\ValidationHelper;
use Illuminate\Http\Request;

class RefreshTokenAction
{
    public function handle(string $refreshToken): array
    {
        // Create an INTERNAL request to the token endpoint
        $params = [
            'grant_type'    => 'refresh_token',
            'client_id'     => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'refresh_token' => $refreshToken,
            'scope'         => '',
        ];

        // Create an INTERNAL request (Very readable!)
        $request = Request::create('/oauth/token', 'POST', $params);

        // Hand the request directly to Laravel's core router
        $response = app()->handle($request);

        // Decode the response
        $data = json_decode($response->getContent(), true);

        if (isset($data['error'])) {
            ValidationHelper::throwError('Authentication failed.', 401);
        }

        return [        
            'message'       => "Token refreshed successfully!",
            'access_token'  => $data['access_token'],
            'token_type'    => $data['token_type'],
            'expires_in'    => $data['expires_in'],
        ];
    }
}