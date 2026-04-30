<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }
        .success { color: #10B981; }
        .error { color: #EF4444; }
        h1 { margin: 0 0 10px; font-size: 24px; color: #1f2937; }
        p { color: #4b5563; margin-bottom: 0; }
    </style>
</head>
<body>

    <div class="card">
        @if($status === 'success')
            <div class="icon success"></div>
            <h1>Verified!</h1>
            <p>{{ $message }}</p>
        @else
            <div class="icon error"></div>
            <h1>Verification Failed</h1>
            <p>{{ $message }}</p>
        @endif
    </div>

</body>
</html>