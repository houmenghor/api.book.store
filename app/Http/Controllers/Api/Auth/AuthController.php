<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RefreshTokenAction;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\ResendVerificationAction;
use App\Actions\Auth\VerifyEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\SendEmailRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(RegisterRequest $req, RegisterAction $action)
    {
        $user = $req->validated();
        $response = $action->handle($user, $user['password']);
        return $this->success("Registration successful! Please check your email to verify your account.", $response);
    }

    public function login(LoginRequest $req, LoginAction $action)
    {
        $user = $req->validated();
        $response = $action->handle($user['email'], $user['password']);

        return $this->success("Login successful!", $response);
    }

    public function verifyEmail(Request $req, VerifyEmailAction $action, string $token)
    {
        $email = $req->query('email');
        $user = $action->handle($email, $token);
        $frontendUrl = config('app.frontend_url', 'http://localhost:3000');
        if (!$user) {
            return redirect("{$frontendUrl}/verify-email?status=error&message=" . urlencode("Invalid or expired verification token."));
        }

        return redirect("{$frontendUrl}/verify-email?status=success");
    }

    public function resendVerification(ResendVerificationAction $action, SendEmailRequest $req)
    {
        $data = $req->validated();
        $action->handle($data['email']);
        return $this->success("Verification email resent! Please check your email.");
    }

    public function refresh(RefreshTokenRequest $req, RefreshTokenAction $action)
    {
        $data = $req->validated();
        $response = $action->handle($data['refresh_token']);
        return $this->success("Token refreshed successfully!", $response);
        
    }

}
