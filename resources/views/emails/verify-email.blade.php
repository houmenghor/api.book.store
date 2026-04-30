<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        /* Reset and base styles */
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            /* Soft light gray background */
            font-family: 'Inter', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1f2937;
            /* Dark gray for better readability */
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            padding: 40px 0;
            background-color: #f3f4f6;
        }

        .main-card {
            background-color: #ffffff;
            margin: 0 auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* Content section */
        .content {
            padding: 40px 40px 20px;
        }

        .content h2 {
            font-size: 20px;
            font-weight: 600;
            margin-top: 0;
            color: #111827;
        }

        .content p {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 24px;
        }

        /* Button styles */
        .button-container {
            text-align: center;
            margin: 32px 0;
        }

        .button {
            background-color: #4F46E5;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 6px;
            display: inline-block;
            transition: background-color 0.2s ease;
        }

        .button:hover {
            background-color: #4338ca;
        }

        /* Notice/Warning text */
        .notice {
            font-size: 14px;
            color: #6b7280;
            background-color: #f9fafb;
            padding: 16px;
            border-radius: 6px;
            border-left: 4px solid #e5e7eb;
            margin-top: 10px;
        }

        /* Fallback link section */
        .fallback {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 13px;
            color: #6b7280;
        }

        .fallback-link {
            color: #4F46E5;
            word-break: break-all;
            /* Prevents long URLs from breaking the layout */
            text-decoration: none;
            display: block;
            margin-top: 8px;
        }

        /* Footer */
        .footer {
            background-color: #f9fafb;
            padding: 24px 40px;
            text-align: center;
            border-top: 1px solid #f3f4f6;
        }

        .footer p {
            margin: 0;
            font-size: 14px;
            color: #6b7280;
        }

        .footer strong {
            color: #374151;
        }

        /* Mobile responsiveness */
        @media only screen and (max-width: 600px) {
            .content {
                padding: 30px 20px 20px;
            }

            .footer {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="main-card">
            <!-- Main Content -->
            <div class="content">
                <h2>Hello, {{ $full_name }}!</h2>
                <p>Welcome to <b>Book Store</b>! Please click the button below to verify your email address and complete your
                    registration.</p>

                <div class="button-container">
                    <a href="{{ $verificationUrl }}" class="button">Verify Email Address</a>
                </div>

                <div class="notice">
                    <p style="margin: 0; margin-bottom: 8px;">This link will expire in <strong>1 hour</strong>.</p>
                    <p style="margin: 0;">If you did not create an account, no further action is required.</p>
                </div>

                <!-- Fallback URL -->
                <div class="fallback">
                    If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below
                    into your web browser:
                    <a href="{{ $verificationUrl }}" class="fallback-link">{{ $verificationUrl }}</a>
                </div>

                <p style="margin-top:32px;">
                    Best regards,<br>
                    <strong>The Book Store Team</strong>
                </p>

            </div>


        </div>
    </div>
</body>

</html>
