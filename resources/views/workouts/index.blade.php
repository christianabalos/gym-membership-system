<!DOCTYPE html>
<html>
<head>
    <title>Workouts</title>
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
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.28);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
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
            margin-bottom: 25px;
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
            background: rgba(107, 114, 128, 0.9);
            color: white;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-view {
            background: #2563eb;
            color: white;
            padding: 8px 13px;
        }

        .btn-edit {
            background: #6b7280;
            color: white;
            padding: 8px 13px;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
            padding: 8px 13px;
        }

        .success {
            background: rgba(220, 252, 231, 0.92);
            color: #166534;
            border: 1px solid #86efac;
            padding: 13px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: bold;
        }

        .panel {
            padding: 22px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.22);
            margin-bottom: 28px;
        }

        .panel h2 {
            margin: 0 0 16px;
            font-size: 24px;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0,0,0,0.35);
        }

        .generate-form {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            align-items: end;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
            color: #ffffff;
            font-size: 14px;
        }

        select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 9px;
            border: 1px solid rgba(203, 213, 225, 0.95);
            font-size: 14px;
            background: rgba(255,255,255,0.95);
            color: #111827;
            outline: none;
        }

        select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.22);
        }

        .note {
            margin-top: 9px;
            color: #e5e7eb;
            font-size: 13px;
            font-weight: 600;
        }

        .workout-card {
            padding: 22px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.22);
            margin-bottom: 28px;
            overflow: hidden;
        }

        .workout-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .member-title {
            margin: 0;
            font-size: 24px;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0,0,0,0.35);
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border-radius: 14px;
            overflow: hidden;
        }

        th {
            background: rgba(15, 23, 42, 0.92);
            color: #ffffff;
            padding: 14px;
            text-align: center;
            font-size: 13px;
            white-space: nowrap;
        }

        td {
            padding: 14px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.18);
            vertical-align: middle;
            font-size: 13px;
            font-weight: 600;
        }

        .day-cell {
            font-weight: 900;
            color: #dbeafe;
            white-space: nowrap;
        }

        .member-cell,
        .trainer-cell,
        .type-cell,
        .title-cell {
            font-weight: 800;
        }

        .description-cell {
            min-width: 280px;
            line-height: 1.45;
            color: #e5e7eb;
        }

        .time-cell {
            white-space: nowrap;
            text-align: center;
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

        .status-cancelled {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 7px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .delete-form {
            display: inline;
            margin: 0;
        }

        .rest-row td {
            background: rgba(254, 243, 199, 0.15);
        }

        .empty {
            text-align: center;
            padding: 28px;
            color: #e5e7eb;
            font-weight: bold;
        }

        @media (max-width: 900px) {
            table {
                min-width: 1050px;
            }

            .generate-form {
                grid-template-columns: 1fr;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Workouts</h1>
        <p class="subtitle">Manage weekly workout schedules for approved memberships.</p>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Dashboard</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="panel">
            <h2>Generate Next Weekly Schedule</h2>

            <form action="{{ route('workouts.generateNextWeek') }}" method="POST" class="generate-form">
                @csrf

                <div>
                    <label for="membership_id">Select Membership:</label>
                    <select id="membership_id" name="membership_id" required>
                        <option value="">Select Member</option>

                        @foreach(($approvedMemberships ?? []) as $membership)
                            <option value="{{ $membership->id }}">
                                {{ $membership->member->full_name ?? 'N/A' }}
                                —
                                {{ $membership->trainer->name ?? 'No Trainer' }}
                                —
                                {{ $membership->plan_name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>

                    <div class="note">
                        Available approved memberships: {{ isset($approvedMemberships) ? $approvedMemberships->count() : 0 }}
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Generate Next Week</button>
            </form>
        </div>

        @php
            $workoutCollection = collect($workouts ?? []);

            $groupedWorkouts = $workoutCollection->groupBy(function ($item) {
                return optional($item->member)->full_name
                    ?? optional($item->membership->member ?? null)->full_name
                    ?? 'Unknown Member';
            });
        @endphp

        @forelse($groupedWorkouts as $memberName => $memberWorkouts)
            @php
                $memberWorkouts = collect($memberWorkouts);
                $firstWorkout = $memberWorkouts->first();

                $memberId = $firstWorkout->member_id
                    ?? optional($firstWorkout->member)->id
                    ?? optional($firstWorkout->membership->member ?? null)->id
                    ?? null;
            @endphp

            <div class="workout-card">
                <div class="workout-header">
                    <h2 class="member-title">{{ $memberName }}</h2>

                    @if($memberId)
                        <form action="{{ route('workouts.deleteByMember', $memberId) }}" method="POST" class="delete-form" onsubmit="return confirm('Delete all workouts for this member?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Delete All Workouts</button>
                        </form>
                    @endif
                </div>

                <div class="table-wrap">
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

                        @foreach($memberWorkouts as $workout)
                            @php
                                $status = strtolower($workout->status ?? 'scheduled');
                                $statusClass = 'status-' . $status;

                                $workoutTitle = $workout->title
                                    ?? $workout->workout_title
                                    ?? $workout->workout_name
                                    ?? $workout->name
                                    ?? 'N/A';

                                $isRest = str_contains(strtolower($workoutTitle), 'rest') || $status === 'rest';

                                $displayTime = $workout->schedule_time
                                    ?: ($workout->time
                                    ?: ($workout->workout_time ?: 'N/A'));
                            @endphp

                            <tr class="{{ $isRest ? 'rest-row' : '' }}">
                                <td class="day-cell">
                                    {{ $workout->day ?? 'N/A' }}
                                </td>

                                <td class="member-cell">
                                    {{ $workout->member->full_name ?? $workout->membership->member->full_name ?? 'N/A' }}
                                </td>

                                <td class="trainer-cell">
                                    {{ $workout->trainer->name ?? $workout->membership->trainer->name ?? 'No Trainer' }}
                                </td>

                                <td class="type-cell">
                                    {{ $workout->workout_type ?? $workout->type ?? 'N/A' }}
                                </td>

                                <td class="title-cell">
                                    {{ $workoutTitle }}
                                </td>

                                <td class="description-cell">
                                    {{ $workout->details ?? $workout->description ?? 'N/A' }}
                                </td>

                                <td class="time-cell">
                                    {{ $displayTime }}
                                </td>

                                <td>
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($workout->status ?? 'Scheduled') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('workouts.show', $workout->id) }}" class="btn btn-view">View</a>
                                        <a href="{{ route('workouts.edit', $workout->id) }}" class="btn btn-edit">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        @empty
            <div class="workout-card">
                <div class="empty">No workouts found.</div>
            </div>
        @endforelse
    </div>
</body>
</html>