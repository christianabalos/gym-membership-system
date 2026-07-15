<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background:
                linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.78)),
                url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 430px;
            background: rgba(255, 255, 255, 0.13);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 38px 34px;
            color: white;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.30);
        }

        h1 {
            text-align: center;
            font-size: 30px;
            line-height: 1.2;
            margin-bottom: 8px;
        }

        h1 span {
            color: #60a5fa;
        }

        .subtitle {
            text-align: center;
            color: #d1d5db;
            font-size: 14px;
            margin-bottom: 28px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(255, 255, 255, 0.14);
            color: white;
            padding: 9px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 22px;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.22);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            margin-bottom: 16px;
            font-size: 14px;
            outline: none;
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
        }

        input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.25);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
            margin-top: 8px;
        }

        .login-btn:hover {
            background: #1d4ed8;
        }

        .register-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #d1d5db;
        }

        .register-text a {
            color: #60a5fa;
            font-weight: bold;
            text-decoration: none;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        @media (max-width: 500px) {
            .login-card {
                padding: 30px 22px;
            }

            h1 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>
            Gym Membership
            <span>Management System</span>
        </h1>

        <p class="subtitle">Login to access your account.</p>

        <a href="{{ route('welcome') }}" class="btn-back">Back</a>

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <label>Email:</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email address"
                required
            >

            <label>Password:</label>
            <input
                type="password"
                name="password"
                placeholder="Enter your password"
                required
            >

            <button type="submit" class="login-btn">Login</button>
        </form>

        <div class="register-text">
            Don't have an account?
            <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</body>
</html>