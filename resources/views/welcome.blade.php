<!DOCTYPE html>
<html>
<head>
    <title>Gym Membership System</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            min-height: 100vh;
            color: #111827;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 15px;
        }

        .container {
            width: 100%;
            max-width: 560px;
            background: #ffffff;
            padding: 45px 38px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 36px;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
        }

        .subtitle {
            margin: 16px 0 32px;
            color: #6b7280;
            font-size: 16px;
            line-height: 1.5;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            min-width: 120px;
            padding: 13px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-login {
            background: #0f172a;
            color: white;
        }

        .btn-login:hover {
            background: #1e293b;
        }

        .btn-register {
            background: #2563eb;
            color: white;
        }

        .btn-register:hover {
            background: #1d4ed8;
        }

        .footer-note {
            margin-top: 28px;
            font-size: 13px;
            color: #9ca3af;
        }

        @media (max-width: 600px) {
            .container {
                padding: 32px 24px;
            }

            h1 {
                font-size: 30px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Gym Membership<br>Management System</h1>

        <p class="subtitle">
            Manage memberships, trainers, workouts, payments, and member schedules in one system.
        </p>

        <div class="actions">
            <a href="{{ route('login') }}" class="btn btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn btn-register">Register</a>
        </div>

        <div class="footer-note">
            Please login or register to continue.
        </div>
    </div>
</body>
</html>