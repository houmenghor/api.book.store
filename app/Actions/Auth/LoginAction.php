<?php

namespace App\Actions\Auth;

use App\Helpers\ValidationHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SensitiveParameter;

class LoginAction
{

    public function __construct(protected SendVerificationEmailAction $sendEmail) {}

    public function handle(string $email, #[SensitiveParameter] string $password): array
    {
        $user = User::query()->with('role')->where("email", $email)->first();
        // dd($user);
        if (!$user) {
            ValidationHelper::throwError('User with this email does not exist.', 401);
        }

        if (!Hash::check($password, $user->password)) {
            ValidationHelper::throwError('Invalid credentials.', 401);
        }

        // if ($user->role->name !== 'admin') {
        //     ValidationHelper::throwError('You do not have permission to access', 403);
        // }

        if ($user->status == false) {

            $this->sendEmail->handle($user);
            ValidationHelper::throwError(
                'email is not verified yet. Please verify your email before logging in.',
                403
            );
        }

        return $this->issueToken($user, $email, $password);
    }

    protected function issueToken(User $user, string $email, string $password): array
    {
        // 1. Prepare the credentials
        $params = [
            'grant_type'    => 'password',
            'client_id'     => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'username'      => $email,
            'password'      => $password,
            'scope'         => $user->role->name,
        ];

        // 2. Create an INTERNAL request (Very readable!)
        $request = Request::create('/oauth/token', 'POST', $params);

        // 3. Hand the request directly to Laravel's core router
        $response = app()->handle($request);
        // dd($response);
        // 4. Decode the response
        $data = json_decode($response->getContent(), true);

        if ($response->getStatusCode() >= 400) {
            $errorMessage = $data['message'] ?? $data['error_description'] ?? 'Authentication failed.';
            ValidationHelper::throwError($errorMessage, 401);
        }

        return [
            'email'         => $email,
            'role'          => $user->role->name,
            'token_type'    => $data['token_type'],
            'expires_in'    => $data['expires_in'],
            'access_token'  => $data['access_token'],
            'refresh_token' => $data['refresh_token'] ?? null,
        ];
    }
}
