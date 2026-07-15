<!DOCTYPE html>
<html>
<head>
    <title>Trainer Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            padding: 35px 15px;
            color: #ffffff;
            background:
                linear-gradient(rgba(15, 23, 42, 0.84), rgba(15, 23, 42, 0.84)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 760px;
            margin: auto;
            padding: 34px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.28);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 34px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 10px 0 28px;
            color: #dbeafe;
            font-size: 15px;
        }

        .top-actions {
            margin-bottom: 24px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(15, 23, 42, 0.92);
            color: white;
            padding: 10px 18px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid rgba(255,255,255,0.18);
        }

        .btn-back:hover {
            background: #2563eb;
        }

        .details-card {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 16px;
            padding: 22px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.22);
        }

        .detail-row {
            display: grid;
            grid-template-columns: 170px 1fr;
            gap: 14px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255,255,255,0.20);
            align-items: center;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #e5e7eb;
        }

        .value {
            color: #ffffff;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(219, 234, 254, 0.90);
            color: #1d4ed8;
            font-weight: bold;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            h1 {
                font-size: 28px;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Trainer Details</h1>
        <p class="subtitle">View complete trainer information.</p>

        <div class="top-actions">
            <a href="{{ route('trainers.index') }}" class="btn-back">Back</a>
        </div>

        <div class="details-card">
            <div class="detail-row">
                <div class="label">Name:</div>
                <div class="value">{{ $trainer->name }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Email:</div>
                <div class="value">{{ $trainer->email }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Phone:</div>
                <div class="value">{{ $trainer->phone }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Specialization:</div>
                <div class="value">
                    <span class="badge">{{ $trainer->specialization }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>