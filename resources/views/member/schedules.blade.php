<!DOCTYPE html>
<html>
<head>
    <title>My Workout Schedules</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 35px 15px;
            min-height: 100vh;
            color: #ffffff;
            background:
                linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.78)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 36px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.30);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.38);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 36px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 30px;
            color: #dbeafe;
            font-size: 15px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(107, 114, 128, 0.95);
            color: white;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .empty-box {
            background: rgba(255, 255, 255, 0.90);
            color: #374151;
            border-radius: 14px;
            padding: 25px;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            border: 1px solid rgba(203, 213, 225, 0.9);
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .schedule-card {
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            border-radius: 16px;
            padding: 22px;
            border-left: 6px solid #2563eb;
            box-shadow: 0 10px 25px rgba(0,0,0,0.18);
        }

        .schedule-card h3 {
            margin: 0 0 12px;
            font-size: 22px;
            color: #0f172a;
        }

        .info {
            margin: 8px 0;
            font-size: 14px;
            color: #374151;
            line-height: 1.5;
        }

        .info strong {
            color: #111827;
        }

        .badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
            margin-top: 10px;
        }

        .scheduled {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .completed {
            background: #dcfce7;
            color: #166534;
        }

        .rest {
            background: #fef3c7;
            color: #92400e;
        }

        .missed {
            background: #fee2e2;
            color: #991b1b;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 24px;
            }

            h1 {
                font-size: 30px;
            }

            .schedule-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>My Workout Schedules</h1>
        <p class="subtitle">View your weekly workout plan, trainer, time, and workout status.</p>

        <a href="{{ route('member.dashboard') }}" class="btn-back">Back</a>

        @php
            $myWorkouts = $workouts ?? collect();
        @endphp

        @if($myWorkouts->count() > 0)
            <div class="schedule-grid">
                @foreach($myWorkouts as $workout)
                    @php
                        $status = strtolower($workout->status ?? 'scheduled');

                        $statusClass = match($status) {
                            'completed' => 'completed',
                            'rest' => 'rest',
                            'missed' => 'missed',
                            default => 'scheduled',
                        };

                        $workoutTitle = $workout->title
                            ?? $workout->workout_title
                            ?? $workout->workout_name
                            ?? 'Workout';

                        $workoutTime = $workout->schedule_time
                            ?? $workout->time
                            ?? $workout->workout_time
                            ?? 'N/A';
                    @endphp

                    <div class="schedule-card">
                        <h3>{{ $workoutTitle }}</h3>

                        <p class="info">
                            <strong>Trainer:</strong>
                            {{ $workout->trainer->name ?? 'No Trainer' }}
                        </p>

                        <p class="info">
                            <strong>Day:</strong>
                            {{ $workout->day ?? 'N/A' }}
                        </p>

                        <p class="info">
                            <strong>Time:</strong>
                            {{ $workoutTime }}
                        </p>

                        <p class="info">
                            <strong>Type:</strong>
                            {{ $workout->workout_type ?? $workout->type ?? 'N/A' }}
                        </p>

                        <p class="info">
                            <strong>Description:</strong>
                            {{ $workout->details ?? $workout->description ?? 'N/A' }}
                        </p>

                        <span class="badge {{ $statusClass }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-box">
                No workout schedules found yet. Please wait for your trainer/workout schedule to be generated.
            </div>
        @endif
    </div>
</body>
</html>