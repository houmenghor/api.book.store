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

        if ($response->getStatusCode() >= 400) {
            $message = $data['message'] ?? $data['error_description'] ?? 'Invalid refresh token.';
            ValidationHelper::throwError($message, 401);
        }
        
        return [        
            'token_type'    => $data['token_type'],
            'expires_in'    => $data['expires_in'],
            'access_token'  => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
        ];
    }
}