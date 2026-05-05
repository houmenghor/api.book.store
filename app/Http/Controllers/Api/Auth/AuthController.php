<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\LogoutAction;
use App\Actions\Auth\Oauth\GoogleCallbackAction;
use App\Actions\Auth\Oauth\GoogleRedirectAction;
use App\Actions\Auth\RefreshTokenAction;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\ResendVerificationAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SendEmailRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterAction $action)
    {
        $user = $request->validated();
        $response = $action->handle($user, $user['password']);
        return $this->success("Registration successful! Please check your email to verify your account.", new UserResource($response));
    }

    public function login(LoginRequest $request, LoginAction $action)
    {
        $user = $request->validated();
        $response = $action->handle($user['email'], $user['password']);

        return $this->success("Login successful!", $response);
    }

    public function logout(Request $request, LogoutAction $action)
    {

        $action->handle($request);
        return $this->success("Logout successful!");
    }

    public function verifyEmail(Request $request, VerifyEmailAction $action, string $token)
    {
        $email = $request->query('email');
        $user = $action->handle($email, $token);
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        if (!$user) {
            return redirect("{$frontendUrl}/verify-email?status=error&message=" . urlencode("Invalid or expired verification token."));
        }

        return redirect("{$frontendUrl}/verify-email?status=success");
    }

    public function resendVerification(ResendVerificationAction $action, SendEmailRequest $request)
    {
        $data = $request->validated();
        $action->handle($data['email']);
        return $this->success("Verification email resent! Please check your email.");
    }

    public function refresh(RefreshTokenRequest $request, RefreshTokenAction $action)
    {
        $data = $request->validated();
        $response = $action->handle($data['refresh_token']);
        return $this->success("Token refreshed successfully!", $response);
    }

    public function googleRedirect(GoogleRedirectAction $action)
    {
        $url = $action->handle();
        return redirect()->away($url);
    }

    public function googleCallback(GoogleCallbackAction $action)
    {
        $response = $action->handle();

        return $this->success("Google authentication successful!", [
            'user'         => new UserResource($response['user']),
            'access_token' => $response['access_token'],
            'token_type'   => $response['token_type'],
            'expires_at'   => $response['expires_at'],
        ]);
    }
}
