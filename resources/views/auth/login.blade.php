<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px 15px;
            color: #111827;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 480px;
            background: #ffffff;
            padding: 38px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 30px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .subtitle {
            text-align: center;
            margin: 12px 0 28px;
            color: #6b7280;
            font-size: 15px;
        }

        .top-actions {
            margin-bottom: 22px;
        }

        .btn-back {
            display: inline-block;
            background: #6b7280;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success-box {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            background: #ffffff;
            color: #111827;
            outline: none;
            transition: 0.2s ease;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .login-btn {
            width: 100%;
            margin-top: 10px;
            padding: 15px;
            border: none;
            border-radius: 8px;
            background: #0f172a;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        .login-btn:hover {
            background: #1e293b;
        }

        .register-link {
            text-align: center;
            margin-top: 22px;
            color: #6b7280;
            font-size: 14px;
        }

        .register-link a {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 26px;
            }

            h1 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Gym Membership Management System</h1>
        <p class="subtitle">Login to access your account.</p>

        <div class="top-actions">
            <a href="{{ route('welcome') }}" class="btn-back">Back</a>
        </div>

        @if(session('success'))
            <div class="success-box">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <div class="field">
                <label>Email:</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email address"
                    required
                    autofocus
                >
            </div>

            <div class="field">
                <label>Password:</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <div class="register-link">
            Don't have an account?
            <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</body>
</html>