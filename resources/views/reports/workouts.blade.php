<!DOCTYPE html>
<html>
<head>
    <title>Workout Report</title>

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
            text-align: center;
            margin-top: 0;
            font-size: 32px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 30px;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
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

        .btn-print {
            background: #2563eb;
            color: white;
        }

        .summary-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: bold;
        }

        .member-section {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 35px;
            overflow: hidden;
            background: white;
        }

        .member-header {
            background: #111827;
            color: white;
            padding: 16px 20px;
        }

        .member-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .member-header p {
            margin: 6px 0 0;
            color: #d1d5db;
            font-size: 14px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            table-layout: fixed;
        }

        th {
            background: #f3f4f6;
            color: #111827;
            padding: 12px;
            text-align: center;
            font-size: 13px;
            border: 1px solid #d1d5db;
        }

        td {
            padding: 12px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
            font-size: 13px;
            text-align: center;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .trainer-name {
            color: #2563eb;
            font-weight: bold;
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

        .badge-missed {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 30px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #f9fafb;
            font-size: 15px;
        }

        @media print {
            @page {
                size: landscape;
                margin: 10mm;
            }

            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .container {
                max-width: 100%;
                width: 100%;
                box-shadow: none;
                border-radius: 0;
                padding: 0;
            }

            .top-actions {
                display: none;
            }

            .member-section {
                page-break-inside: avoid;
                margin-bottom: 20px;
            }

            h1 {
                font-size: 24px;
                margin-bottom: 8px;
            }

            .subtitle {
                margin-bottom: 15px;
            }

            .summary-box {
                padding: 10px;
                margin-bottom: 15px;
                font-size: 12px;
            }

            .member-header {
                padding: 10px;
            }

            .member-header h2 {
                font-size: 17px;
            }

            .member-header p {
                font-size: 11px;
            }

            th {
                padding: 7px;
                font-size: 10px;
            }

            td {
                padding: 7px;
                font-size: 10px;
            }

            .badge {
                padding: 4px 7px;
                font-size: 9px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            table {
                min-width: 900px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Workout Report</h1>
        <p class="subtitle">List of generated workout schedules separated by member.</p>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Report</button>
        </div>

        <div class="summary-box">
            Total Workouts: {{ $workouts->count() }}
        </div>

        @php
            $groupedWorkouts = $workouts->groupBy(function ($workout) {
                return $workout->member->full_name ?? 'No Member';
            });
        @endphp

        @if($workouts->count() > 0)
            @foreach($groupedWorkouts as $memberName => $memberWorkouts)
                <div class="member-section">
                    <div class="member-header">
                        <h2>{{ $memberName }}</h2>
                        <p>Total Workouts: {{ $memberWorkouts->count() }}</p>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Trainer</th>
                                    <th>Day</th>
                                    <th>Workout Type</th>
                                    <th>Workout Name</th>
                                    <th>Description</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($memberWorkouts as $workout)
                                    <tr>
                                        <td class="trainer-name">
                                            {{ $workout->trainer->name ?? 'No Trainer' }}
                                        </td>

                                        <td>
                                            {{ $workout->day ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $workout->workout_type ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $workout->workout_name ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $workout->description ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $workout->workout_time ?? 'N/A' }}
                                        </td>

                                        <td>
                                            @php
                                                $status = strtolower($workout->status ?? 'scheduled');

                                                $statusClass = match($status) {
                                                    'completed' => 'badge-completed',
                                                    'rest' => 'badge-rest',
                                                    'missed' => 'badge-missed',
                                                    default => 'badge-scheduled',
                                                };
                                            @endphp

                                            <span class="badge {{ $statusClass }}">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty">
                No workout records found. Generate workouts first from the Workouts page.
            </div>
        @endif
    </div>
</body>
</html>