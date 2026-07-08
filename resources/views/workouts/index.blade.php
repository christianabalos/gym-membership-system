<!DOCTYPE html>
<html>
<head>
    <title>Workouts</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 1300px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h1 {
            margin-top: 0;
            font-size: 34px;
        }

        h2 {
            margin-top: 35px;
            margin-bottom: 18px;
            font-size: 28px;
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

        .btn-dashboard {
            background: #6b7280;
            color: white;
        }

        .btn-generate {
            background: #2563eb;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .btn-view {
            background: #2563eb;
            color: white;
            padding: 7px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
        }

        .btn-edit {
            background: #6b7280;
            color: white;
            padding: 7px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
        }

        .success {
            color: #166534;
            background: #dcfce7;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .error-box {
            color: #991b1b;
            background: #fee2e2;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .form-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 30px;
            background: #f9fafb;
        }

        .form-row {
            display: flex;
            gap: 12px;
            align-items: end;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        select {
            min-width: 320px;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
        }

        .helper-text {
            color: #6b7280;
            margin-top: 12px;
            font-size: 14px;
        }

        .member-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 30px;
            background: #ffffff;
        }

        .member-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .member-header h3 {
            margin: 0;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 14px;
        }

        td {
            padding: 14px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
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

        .rest-row {
            background: #fffbeb;
        }

        .action-links {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .no-data {
            color: #6b7280;
            text-align: center;
            padding: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Workouts</h1>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-dashboard">Dashboard</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="form-card">
            <h2>Generate Next Weekly Schedule</h2>

            <form action="{{ route('workouts.generateNextWeek') }}" method="POST">
                @csrf

                <label for="membership_id">Select Membership:</label>

                <div class="form-row">
                    <select name="membership_id" id="membership_id" required>
                        <option value="">Select Member</option>

                        @foreach($memberships as $membership)
                            <option value="{{ $membership->id }}">
                                {{ $membership->member->full_name ?? 'N/A' }}
                                -
                                {{ $membership->trainer->name ?? 'No Trainer' }}
                                -
                                {{ $membership->schedule_time ?? 'No Schedule Time' }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-generate">Generate Next Week</button>
                </div>
            </form>

            <p class="helper-text">
                Available approved memberships: {{ $memberships->count() }}
            </p>
        </div>

        @forelse($workouts as $memberId => $memberWorkouts)
            @php
                $sortedWorkouts = $memberWorkouts->sortBy(function ($workout) {
                    $dayOrder = [
                        'Monday' => 1,
                        'Tuesday' => 2,
                        'Wednesday' => 3,
                        'Thursday' => 4,
                        'Friday' => 5,
                        'Saturday' => 6,
                        'Sunday' => 7,
                    ];

                    $dayName = $workout->day ?: \Carbon\Carbon::parse($workout->workout_date)->format('l');

                    return $dayOrder[$dayName] ?? 99;
                });
            @endphp

            <div class="member-card">
                <div class="member-header">
                    <h3>{{ $memberWorkouts->first()->member->full_name ?? 'N/A' }}</h3>

                    <form action="{{ route('workouts.deleteByMember', $memberId) }}" method="POST" onsubmit="return confirm('Delete all workouts for this member?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">Delete All Workouts</button>
                    </form>
                </div>

                <table>
                    <tr>
                        <th>Day</th>
                        <th>Member</th>
                        <th>Trainer</th>
                        <th>Workout Type</th>
                        <th>Workout Title</th>
                        <th>Description</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                    @foreach($sortedWorkouts as $workout)
                        @php
                            $dayName = $workout->day ?: \Carbon\Carbon::parse($workout->workout_date)->format('l');
                            $status = strtolower($workout->status);
                        @endphp

                        <tr class="{{ $status === 'rest' ? 'rest-row' : '' }}">
                            <td>{{ $dayName }}</td>
                            <td>{{ $workout->member->full_name ?? 'N/A' }}</td>
                            <td>{{ $workout->trainer->name ?? 'No Trainer' }}</td>
                            <td>{{ $workout->workout_type }}</td>
                            <td>{{ $workout->workout_name }}</td>
                            <td>{{ $workout->description }}</td>
                            <td class="text-center">
    @php
        $displayTime = $workout->workout_time ?? 'N/A';

        if ($displayTime !== 'N/A') {
            try {
                if (str_contains($displayTime, ' - ')) {
                    $displayTime = $displayTime;
                } else {
                    $displayTime = \Carbon\Carbon::parse($displayTime)->format('g:i A');
                }
            } catch (\Exception $e) {
                $displayTime = $workout->workout_time;
            }
        }
    @endphp

    {{ $displayTime }}
</td>
                            <td class="text-center">
                                <span class="status-badge status-{{ $status }}">
                                    {{ $workout->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="action-links">
                                    <a href="{{ route('workouts.show', $workout->id) }}" class="btn-view">View</a>
                                    <a href="{{ route('workouts.edit', $workout->id) }}" class="btn-edit">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @empty
            <div class="member-card">
                <p class="no-data">No workouts found.</p>
            </div>
        @endforelse
    </div>
</body>
</html>