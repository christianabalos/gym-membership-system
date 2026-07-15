<!DOCTYPE html>
<html>
<head>
    <title>Workout Report</title>
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
            max-width: 1250px;
            margin: auto;
            padding: 34px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
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
            margin: 10px 0 28px;
            color: #dbeafe;
            font-size: 15px;
            font-weight: 600;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 22px;
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

        .btn-print {
            background: #2563eb;
            color: #ffffff;
        }

        .summary-box {
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            border-radius: 14px;
            padding: 16px 18px;
            border: 1px solid rgba(203, 213, 225, 0.9);
            margin-bottom: 24px;
            font-size: 15px;
            font-weight: 800;
        }

        .member-section {
    margin-bottom: 24px;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid rgba(203, 213, 225, 0.45);
    background: rgba(255, 255, 255, 0.08);
}

        .member-header {
    padding: 14px 18px;
    background: rgba(15, 23, 42, 0.88);
    color: #ffffff;
    border-bottom: 1px solid rgba(203, 213, 225, 0.25);
}

.member-header h2 {
    margin: 0;
    font-size: 22px;
    font-weight: 900;
}

.member-header p {
    margin: 5px 0 0;
    color: #dbeafe;
    font-size: 13px;
    font-weight: 700;
}

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(255, 255, 255, 0.06);
}

th {
    background: rgba(17, 24, 39, 0.92);
    color: #ffffff;
    padding: 12px 10px;
    text-align: center;
    font-size: 12px;
    white-space: nowrap;
    border: 1px solid rgba(203, 213, 225, 0.18);
}

td {
    padding: 12px 10px;
    color: #f9fafb;
    border: 1px solid rgba(203, 213, 225, 0.18);
    background: rgba(255, 255, 255, 0.06);
    vertical-align: middle;
    font-size: 12px;
    font-weight: 600;
    text-align: center;
}

        .trainer-cell,
        .type-cell,
        .title-cell {
            font-weight: 900;
        }

        .trainer-cell {
            color: #bfdbfe;
        }

        .description-cell {
    min-width: 250px;
    text-align: left;
    line-height: 1.45;
    color: #f3f4f6;
}

        .trainer-cell {
    color: #dbeafe;
}

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
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

        .status-cancelled,
        .status-canceled {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
        }

       .rest-row td {
    background: rgba(250, 204, 21, 0.12);
}

        .empty {
            text-align: center;
            padding: 28px;
            color: #e5e7eb;
            font-weight: bold;
        }

        .print-header {
            display: none;
        }

        @media (max-width: 900px) {
            table {
                min-width: 1050px;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            h1 {
                font-size: 30px;
            }

            .top-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0;
                margin: 0;
                font-family: Arial, sans-serif;
            }

            .container {
                max-width: none;
                width: 100%;
                margin: 0;
                padding: 18px;
                border: none;
                box-shadow: none;
                border-radius: 0;
                background: #ffffff !important;
                color: #000000 !important;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }

            .top-actions {
                display: none !important;
            }

            .print-header {
                display: block;
                text-align: center;
                margin-bottom: 18px;
                color: #000000;
            }

            .print-header h2 {
                margin: 0 0 5px;
                font-size: 24px;
            }

            .print-header p {
                margin: 0;
                font-size: 13px;
            }

            h1 {
                color: #000000 !important;
                text-shadow: none;
                font-size: 26px;
            }

            .subtitle {
                color: #374151 !important;
            }

            .summary-box {
                background: #ffffff !important;
                color: #000000 !important;
                border: 1px solid #111827;
                padding: 10px;
                margin-bottom: 14px;
            }

            .member-section {
                border: 1px solid #111827;
                border-radius: 0;
                margin-bottom: 18px;
                page-break-inside: avoid;
                background: #ffffff !important;
            }

            .member-header {
                background: #111827 !important;
                color: #ffffff !important;
                padding: 10px;
            }

            .member-header h2 {
                font-size: 18px;
            }

            .member-header p {
                color: #ffffff !important;
                font-size: 11px;
            }

            .table-wrap {
                overflow: visible;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                background: #ffffff !important;
            }

            th {
                background: #111827 !important;
                color: #ffffff !important;
                border: 1px solid #111827;
                padding: 7px;
                font-size: 10px;
            }

            td {
                background: #ffffff !important;
                color: #000000 !important;
                border: 1px solid #9ca3af;
                padding: 7px;
                font-size: 10px;
                font-weight: normal;
            }

            .trainer-cell,
            .type-cell,
            .title-cell,
            .time-cell,
            .description-cell {
                color: #000000 !important;
                font-weight: normal;
            }

            .status-badge {
                background: transparent !important;
                color: #000000 !important;
                padding: 0;
                border-radius: 0;
                font-weight: normal;
            }

            @page {
                size: landscape;
                margin: 10mm;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="print-header">
            <h2>Gym Membership Management System</h2>
            <p>Workout Report</p>
        </div>

        <h1>Workout Report</h1>
        <p class="subtitle">List of generated workout schedules separated by member.</p>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Report</button>
        </div>

        @php
            $workoutList = collect($workouts ?? []);

            $activeWorkoutList = $workoutList->filter(function ($workout) {
                $membershipStatus = strtolower($workout->membership->status ?? '');
                $workoutStatus = strtolower($workout->status ?? '');

                if (in_array($membershipStatus, ['cancelled', 'canceled'])) {
                    return false;
                }

                if (in_array($workoutStatus, ['cancelled', 'canceled'])) {
                    return false;
                }

                return true;
            });

            $groupedWorkouts = $activeWorkoutList->groupBy(function ($workout) {
                return $workout->member->full_name
                    ?? $workout->membership->member->full_name
                    ?? 'Unknown Member';
            });
        @endphp

        <div class="summary-box">
            Total Workouts: {{ $activeWorkoutList->count() }}
        </div>

        @forelse($groupedWorkouts as $memberName => $memberWorkouts)
            <div class="member-section">
                <div class="member-header">
                    <h2>{{ $memberName }}</h2>
                    <p>Total Workouts: {{ collect($memberWorkouts)->count() }}</p>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Trainer</th>
                                <th>Day</th>
                                <th>Workout Type</th>
                                <th>Workout Title</th>
                                <th>Description</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($memberWorkouts as $workout)
                                @php
                                    $status = strtolower($workout->status ?? 'scheduled');

                                    $statusClass = match($status) {
                                        'rest' => 'status-rest',
                                        'completed' => 'status-completed',
                                        'cancelled' => 'status-cancelled',
                                        'canceled' => 'status-canceled',
                                        default => 'status-scheduled',
                                    };

                                    $title = $workout->title
                                        ?? $workout->workout_title
                                        ?? $workout->workout_name
                                        ?? $workout->name
                                        ?? 'N/A';

                                    $isRest = str_contains(strtolower($title), 'rest') || $status === 'rest';
                                @endphp

                                <tr class="{{ $isRest ? 'rest-row' : '' }}">
                                    <td class="trainer-cell">
                                        {{ $workout->trainer->name ?? $workout->membership->trainer->name ?? 'No Trainer' }}
                                    </td>

                                    <td>
                                        {{ $workout->day ?? 'N/A' }}
                                    </td>

                                    <td class="type-cell">
                                        {{ $workout->workout_type ?? $workout->type ?? 'N/A' }}
                                    </td>

                                    <td class="title-cell">
                                        {{ $title }}
                                    </td>

                                    <td class="description-cell">
                                        {{ $workout->details ?? $workout->description ?? 'N/A' }}
                                    </td>

                                    <td class="time-cell">
                                        {{ $workout->schedule_time ?? $workout->time ?? $workout->workout_time ?? 'N/A' }}
                                    </td>

                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ ucfirst($workout->status ?? 'Scheduled') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="empty">
                No workout records found.
            </div>
        @endforelse
    </div>
</body>
</html>