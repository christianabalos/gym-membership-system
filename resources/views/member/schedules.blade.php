<!DOCTYPE html>
<html>
<head>
    <title>My Workout Schedules</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
            text-align: center;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 30px;
        }

        .top-actions {
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            overflow: hidden;
            border-radius: 10px;
        }

        .schedule-table th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 14px;
        }

        .schedule-table td {
            padding: 14px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
            font-size: 14px;
        }

        .schedule-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .trainer-name {
            font-weight: bold;
            color: #1d4ed8;
        }

        .workout-name {
            font-weight: bold;
            color: #111827;
        }

        .description {
            color: #374151;
            line-height: 1.4;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .badge-scheduled {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .badge-completed {
            background: #dcfce7;
            color: #166534;
        }

        .badge-rest {
            background: #fef3c7;
            color: #92400e;
        }

        .time-box {
            font-weight: bold;
            background: #eef2ff;
            color: #3730a3;
            padding: 7px 10px;
            border-radius: 7px;
            display: inline-block;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 30px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #f9fafb;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            .table-wrap {
                overflow-x: auto;
            }

            .schedule-table {
                min-width: 950px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Workout Schedules</h1>
        <p class="subtitle">View your weekly workout plan, trainer, date, time, and workout status.</p>

        <div class="top-actions">
            <a href="{{ route('member.dashboard') }}" class="btn btn-back">Back</a>
        </div>

        @if($workouts->count() > 0)
            <div class="table-wrap">
                <table class="schedule-table">
                    <tr>
                        <th>Trainer</th>
                        <th>Workout Type</th>
                        <th>Workout Name</th>
                        <th>Description</th>
                        <th>Day</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>

                    @foreach($workouts as $workout)
                        <tr>
                            <td class="trainer-name">
                                {{ $workout->trainer->name ?? 'No Trainer' }}
                            </td>

                            <td>
                                {{ $workout->workout_type }}
                            </td>

                            <td class="workout-name">
                                {{ $workout->workout_name }}
                            </td>

                            <td class="description">
                                {{ $workout->description }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($workout->workout_date)->format('l') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($workout->workout_date)->format('M d, Y') }}
                            </td>

                            <td>
                                <span class="time-box">
                                    {{ \Carbon\Carbon::parse($workout->workout_time)->format('g:i A') }}
                                </span>
                            </td>

                            <td>
                                @php
                                    $statusClass = match($workout->status) {
                                        'completed' => 'badge-completed',
                                        'rest' => 'badge-rest',
                                        default => 'badge-scheduled',
                                    };
                                @endphp

                                <span class="badge {{ $statusClass }}">
                                    {{ $workout->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No workout schedules found yet. Please wait for your trainer/workout schedule to be generated.
            </div>
        @endif
    </div>
</body>
</html>