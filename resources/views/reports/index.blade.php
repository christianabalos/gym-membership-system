<!DOCTYPE html>
<html>
<head>
    <title>Generate Reports</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 980px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 32px;
        }

        .top-actions {
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .report-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .report-card {
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 22px;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        .report-card h3 {
            margin: 0 0 18px 0;
            font-size: 20px;
            color: #111827;
            text-align: center;
        }

        .btn-report {
            background: #2563eb;
            color: white;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }

        .btn-report:hover {
            background: #1d4ed8;
        }

        .btn-analytics {
            background: #111827;
            color: white;
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }

        .btn-analytics:hover {
            background: #374151;
        }

        @media (max-width: 900px) {
            .report-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            .report-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Generate Reports</h1>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back to Dashboard</a>
        </div>

        <div class="report-grid">
            <div class="report-card">
                <h3>Members Report</h3>
                <a href="{{ route('reports.members') }}" class="btn btn-report">Open Members Report</a>
            </div>

            <div class="report-card">
                <h3>Memberships Report</h3>
                <a href="{{ route('reports.memberships') }}" class="btn btn-report">Open Memberships Report</a>
            </div>

            <div class="report-card">
                <h3>Payments Report</h3>
                <a href="{{ route('reports.payments') }}" class="btn btn-report">Open Payments Report</a>
            </div>

            <div class="report-card">
                <h3>Workouts Report</h3>
                <a href="{{ route('reports.workouts') }}" class="btn btn-report">Open Workouts Report</a>
            </div>

            <div class="report-card">
                <h3>Trainers Report</h3>
                <a href="{{ route('reports.trainers') }}" class="btn btn-report">Open Trainers Report</a>
            </div>

            <div class="report-card">
                <h3>Membership Analytics</h3>
                <a href="{{ route('reports.membershipAnalytics') }}" class="btn btn-analytics">Open Membership Analytics</a>
            </div>
        </div>
    </div>
</body>
</html>