<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Membership Management System</title>

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

        .card {
            width: 100%;
            max-width: 700px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 50px 35px;
            text-align: center;
            color: white;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.30);
        }

        .badge {
            display: inline-block;
            background: rgba(37, 99, 235, 0.20);
            color: #dbeafe;
            border: 1px solid rgba(219, 234, 254, 0.25);
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 48px;
            line-height: 1.1;
            margin-bottom: 18px;
        }

        h1 span {
            color: #60a5fa;
        }

        p {
            font-size: 16px;
            color: #e5e7eb;
            margin-bottom: 30px;
            line-height: 1.7;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .feature {
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.12);
            padding: 10px 14px;
            border-radius: 999px;
            font-size: 14px;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 13px 28px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            transition: 0.2s ease;
        }

        .btn-login {
            background: #2563eb;
            color: white;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .btn-register {
            background: transparent;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.30);
        }

        .btn-register:hover {
            background: rgba(255, 255, 255, 0.10);
        }

        @media (max-width: 768px) {
            .card {
                padding: 35px 22px;
            }

            h1 {
                font-size: 36px;
            }

            p {
                font-size: 15px;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="badge">Gym System</div>

        <h1>
            Gym Membership
            <span>Management System</span>
        </h1>

        <p>
            Manage members, trainers, schedules, workouts, and payments in one system.
        </p>

        <div class="buttons">
            <a href="{{ route('login') }}" class="btn btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn btn-register">Register</a>
        </div>
    </div>
</body>
</html>