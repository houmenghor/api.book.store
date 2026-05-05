@php
    $templates = [
        'change_email' => [
            'title' => 'Confirm your new email address',
            'intro' => [
                'We received a request to change the email address on your <strong>Book Store</strong> account.',
                'Please enter the one-time code below to confirm your new email address.',
            ],
            'footer' => 'If you didn’t request this change, please secure your account and ignore this email.',
        ],

        'reset_password' => [
            'title' => 'Reset your password',
            'intro' => [
                'You have asked to reset the password for your <strong>Book Store</strong> account.',
                'Use the one-time code below to continue. If you didn’t request this, you can safely ignore this email.',
            ],
            'footer' => 'For your security, do not share this code with anyone.',
        ],
    ];

    $content = $templates[$purpose] ?? [
        'title' => 'Verification code',
        'intro' => ['Use the one-time code below to continue.'],
        'footer' => 'If you did not request this, please ignore this email.',
    ];

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $content['title'] }}</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; background:#f6f6f6; padding:20px;">
    <div style="max-width:600px; margin:auto; background:#ffffff; padding:32px; border-radius:8px;">

        <!-- Header: Logo + Profile -->
        {{-- <div style="text-align:center; margin-bottom:24px;">
            @if (!empty($logoUrl))
                <img src="{{ $logoUrl }}" alt="Book Store" width="120" style="display:block; margin:0 auto 14px;">
            @endif

            <img src="{{ $avatarUrl }}" alt="{{ $name }}" width="64" height="64"
                style="
                    display:block;
                    margin:0 auto;
                    border-radius:50%;
                    object-fit:cover;
                    border:2px solid #e5e7eb;
                ">
        </div> --}}

        <!-- Greeting -->
        <p>Hello <strong>{{ $full_name }}</strong>,</p>

        <!-- Intro text -->
        @foreach ($content['intro'] as $paragraph)
            <p>{!! $paragraph !!}</p>
        @endforeach

        <!-- OTP -->
        <div style="text-align:center; margin:32px 0;">
            <span
                style="
                display:inline-block;
                font-size:28px;
                letter-spacing:6px;
                font-weight:bold;
                background:#f2f4f7;
                padding:12px 20px;
                border-radius:6px;
            ">
                {{ $code }}
            </span>
        </div>

        <!-- Expiry -->
        <p>This code will expire in <strong>10 minutes</strong>.</p>

        <!-- Footer security note -->
        <p style="color:#777;">{{ $content['footer'] }}</p>

        <p style="margin-top:32px;">
            Best regards,<br>
            <strong>The Book Store Team</strong>
        </p>
    </div>
</body>

</html>
