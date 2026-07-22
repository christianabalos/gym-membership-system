<!DOCTYPE html>
<html>
<head>
    <title>Generate Reports</title>
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
                linear-gradient(rgba(15, 23, 42, 0.82), rgba(15, 23, 42, 0.82)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 1050px;
            margin: auto;
            padding: 36px 34px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 38px;
            font-weight: 900;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 10px 0 30px;
            color: #dbeafe;
            font-size: 15px;
            font-weight: 600;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 16px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 800;
            transition: 0.2s ease;
            text-align: center;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .btn-back {
            background: rgba(107, 114, 128, 0.92);
            color: #ffffff;
        }

        .reports-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .report-card {
            padding: 24px 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 10px 25px rgba(0,0,0,0.18);
            text-align: center;
            transition: 0.2s ease;
        }

        .report-card:hover {
            transform: translateY(-3px);
            background: rgba(255, 255, 255, 0.16);
        }

        .report-card h2 {
            margin: 0 0 10px;
            color: #ffffff;
            font-size: 21px;
            font-weight: 900;
            text-shadow: 0 2px 8px rgba(0,0,0,0.35);
        }

        .report-card p {
            margin: 0 0 18px;
            color: #e5e7eb;
            font-size: 13px;
            line-height: 1.5;
            min-height: 38px;
        }

        .btn-primary {
            width: 100%;
            background: #2563eb;
            color: #ffffff;
        }

        .btn-dark {
            width: 100%;
            background: #111827;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-dark:hover {
            background: #030712;
        }

        @media (max-width: 900px) {
            .reports-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 18px 12px;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 30px;
            }

            .reports-grid {
                grid-template-columns: 1fr;
            }

            .top-actions {
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
        <h1>Generate Reports</h1>
        <p class="subtitle">Open and generate gym management reports.</p>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back to Dashboard</a>
        </div>

        <div class="reports-grid">
            <div class="report-card">
                <h2>Members Report</h2>
                <p>View registered gym members and their information.</p>
                <a href="{{ route('reports.members') }}" class="btn btn-primary">
                    Open Members Report
                </a>
            </div>

            <div class="report-card">
                <h2>Memberships Report</h2>
                <p>View membership plans, status, start dates, and end dates.</p>
                <a href="{{ route('reports.memberships') }}" class="btn btn-primary">
                    Open Memberships Report
                </a>
            </div>

            <div class="report-card">
                <h2>Payments Report</h2>
                <p>View payment records, amounts, methods, and payment status.</p>
                <a href="{{ route('reports.payments') }}" class="btn btn-primary">
                    Open Payments Report
                </a>
            </div>

            <div class="report-card">
                <h2>Workouts Report</h2>
                <p>View generated workout schedules by member and trainer.</p>
                <a href="{{ route('reports.workouts') }}" class="btn btn-primary">
                    Open Workouts Report
                </a>
            </div>

            <div class="report-card">
                <h2>Trainers Report</h2>
                <p>View trainers, specialization, and assigned members.</p>
                <a href="{{ route('reports.trainers') }}" class="btn btn-primary">
                    Open Trainers Report
                </a>
            </div>

            <div class="report-card">
                <h2>Membership Analytics</h2>
                <p>View membership summary and analytics information.</p>
                <a href="{{ route('reports.analytics') }}" class="btn btn-dark">
                    Open Membership Analytics
                </a>
            </div>
        </div>
    </div>
</body>
</html>