<!DOCTYPE html>
<html>
<head>
    <title>View Workout</title>

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
        }

        .container {
            max-width: 760px;
            margin: 0 auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 36px;
            font-weight: 800;
            color: #0f172a;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-top: 10px;
            margin-bottom: 28px;
            font-size: 15px;
        }

        .top-actions {
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 8px;
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

        .btn-edit {
            background: #2563eb;
            color: white;
            margin-left: 8px;
        }

        .workout-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            background: #ffffff;
        }

        .card-header {
            background: #111827;
            color: white;
            padding: 18px 22px;
        }

        .card-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .card-header p {
            margin: 6px 0 0;
            color: #d1d5db;
            font-size: 14px;
        }

        .details {
            padding: 22px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 190px 1fr;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #374151;
        }

        .value {
            color: #111827;
            line-height: 1.5;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-weight: bold;
            font-size: 13px;
            text-transform: capitalize;
        }

        .status-scheduled {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-rest {
            background: #fef3c7;
            color: #92400e;
        }

        .status-missed {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-default {
            background: #e5e7eb;
            color: #374151;
        }

        @media (max-width: 700px) {
            .container {
                padding: 22px;
            }

            h1 {
                font-size: 30px;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .btn-edit {
                margin-left: 0;
                margin-top: 8px;
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

            $statusClass = match($status) {
                'scheduled' => 'status-scheduled',
                'completed' => 'status-completed',
                'rest' => 'status-rest',
                'missed' => 'status-missed',
                default => 'status-default',
            };

            $workoutDate = $workout->workout_date
                ? \Carbon\Carbon::parse($workout->workout_date)->format('M d, Y')
                : 'N/A';

            $workoutTime = $workout->workout_time ?? $workout->time ?? 'N/A';
        @endphp

        <div class="workout-card">
            <div class="card-header">
                <h2>{{ $workout->workout_name ?? $workout->title ?? 'Workout' }}</h2>
                <p>{{ $workout->day ?? 'No day set' }} • {{ $workoutDate }}</p>
            </div>

            <div class="details">
                <div class="detail-row">
                    <div class="label">Member</div>
                    <div class="value">{{ $workout->member->full_name ?? $workout->member->name ?? 'N/A' }}</div>
                </div>

                <div class="detail-row">
                    <div class="label">Trainer</div>
                    <div class="value">{{ $workout->trainer->name ?? 'No Trainer' }}</div>
                </div>

                <div class="detail-row">
                    <div class="label">Workout Type</div>
                    <div class="value">{{ $workout->workout_type ?? 'N/A' }}</div>
                </div>

                <div class="detail-row">
                    <div class="label">Workout Title</div>
                    <div class="value">{{ $workout->workout_name ?? $workout->title ?? 'N/A' }}</div>
                </div>

                <div class="detail-row">
                    <div class="label">Description</div>
                    <div class="value">{{ $workout->description ?? $workout->details ?? 'N/A' }}</div>
                </div>

                <div class="detail-row">
                    <div class="label">Date</div>
                    <div class="value">{{ $workoutDate }}</div>
                </div>

                <div class="detail-row">
                    <div class="label">Time</div>
                    <div class="value">{{ $workoutTime }}</div>
                </div>

                <div class="detail-row">
                    <div class="label">Status</div>
                    <div class="value">
                        <span class="status-badge {{ $statusClass }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>