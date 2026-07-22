<!DOCTYPE html>
<html>
<head>
    <title>View Workout</title>
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
            max-width: 760px;
            margin: auto;
            padding: 36px 24px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
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
            margin: 8px 0 26px;
            color: #e5e7eb;
            font-size: 14px;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .btn-back {
            background: rgba(107, 114, 128, 0.9);
            color: white;
        }

        .btn-edit {
            background: #2563eb;
            color: white;
        }

        .details-card {
            overflow: hidden;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.22);
        }

        .card-header {
            padding: 20px;
            background: rgba(15, 23, 42, 0.92);
            color: #ffffff;
        }

        .card-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }

        .card-header p {
            margin: 7px 0 0;
            font-size: 13px;
            color: #dbeafe;
            font-weight: bold;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table th,
        .details-table td {
            padding: 16px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
            vertical-align: top;
            font-size: 14px;
        }

        .details-table th {
            width: 35%;
            text-align: left;
            color: #ffffff;
            font-weight: 800;
            background: rgba(255, 255, 255, 0.08);
        }

        .details-table td {
            color: #ffffff;
            font-weight: 600;
            line-height: 1.45;
            background: rgba(255, 255, 255, 0.05);
        }

        .details-table tr:last-child th,
        .details-table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 13px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            text-transform: capitalize;
        }

        .status-scheduled {
            background: rgba(219, 234, 254, 0.95);
            color: #1d4ed8;
        }

        .status-rest {
            background: rgba(254, 243, 199, 0.95);
            color: #92400e;
        }

        .status-completed {
            background: rgba(220, 252, 231, 0.95);
            color: #166534;
        }

        .status-cancelled {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 28px;
            }

            .top-actions {
                flex-direction: column;
            }

            .btn {
                text-align: center;
            }

            .details-table th,
            .details-table td {
                display: block;
                width: 100%;
            }

            .details-table th {
                border-bottom: none;
                padding-bottom: 6px;
            }

            .details-table td {
                padding-top: 6px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>View Workout</h1>
        <p class="subtitle">Workout schedule details and information.</p>

        <div class="top-actions">
            <a href="{{ route('workouts.index') }}" class="btn btn-back">Back</a>
            <a href="{{ route('workouts.edit', $workout->id) }}" class="btn btn-edit">Edit Workout</a>
        </div>

        @php
            $status = strtolower($workout->status ?? 'scheduled');
            $statusClass = 'status-' . $status;

            $titleFromWorkoutTitle = $workout->workout_title ?? null;
            $titleFromTitle = $workout->title ?? null;

            if ($titleFromTitle === 'Workout Details') {
                $titleFromTitle = null;
            }

            $workoutTitle = $titleFromWorkoutTitle
                ?? $titleFromTitle
                ?? $workout->workout_name
                ?? 'N/A';

            $workoutDate = $workout->workout_date
                ? \Carbon\Carbon::parse($workout->workout_date)->format('F d, Y')
                : 'N/A';
        @endphp

        <div class="details-card">
            <div class="card-header">
                <h2>{{ $workoutTitle }}</h2>
                <p>{{ $workout->day ?? 'N/A' }} • {{ $workoutDate }}</p>
            </div>

            <table class="details-table">
                <tr>
                    <th>Member</th>
                    <td>{{ $workout->member->full_name ?? $workout->membership->member->full_name ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Trainer</th>
                    <td>{{ $workout->trainer->name ?? $workout->membership->trainer->name ?? 'No Trainer' }}</td>
                </tr>

                <tr>
                    <th>Workout Type</th>
                    <td>{{ $workout->workout_type ?? $workout->type ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Workout Title</th>
                    <td>{{ $workoutTitle }}</td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td>{{ $workout->details ?? $workout->description ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Date</th>
                    <td>{{ $workoutDate }}</td>
                </tr>

                <tr>
                    <th>Time</th>
                    <td>{{ $workout->schedule_time ?? $workout->time ?? '8:00 AM - 9:00 AM' }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        <span class="status-badge {{ $statusClass }}">
                            {{ ucfirst($workout->status ?? 'Scheduled') }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>