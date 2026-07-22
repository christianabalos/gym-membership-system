<!DOCTYPE html>
<html>
<head>
    <title>Trainer Booking Dashboard</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #181c32;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background: #15192b;
            color: white;
            padding: 35px 25px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 45px;
        }

        .menu a,
        .menu button {
            display: block;
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 10px;
            border-radius: 10px;
            color: white;
            background: transparent;
            border: none;
            text-align: left;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }

        .menu a.active,
        .menu a:hover,
        .menu button:hover {
            background: #30364f;
        }

        .main {
            flex: 1;
            padding: 45px 55px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar h1 {
            font-size: 42px;
            margin: 0;
        }

        .trainer-name {
            font-weight: bold;
            background: white;
            padding: 12px 18px;
            border-radius: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .filters {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-top: 45px;
            margin-bottom: 45px;
        }

        .filter-box label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .filter-box select,
        .filter-box input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #eef1f6;
        }

        .booking-card {
            background: #eef2f7;
            border-radius: 22px;
            padding: 28px;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .booking-header h2 {
            margin: 0;
            font-size: 28px;
        }

        .booking-header .today {
            background: #4169e1;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            text-decoration: none;
        }

        .week-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 12px;
        }

        .day-column {
            border-left: 1px solid #ccd3df;
            padding: 0 10px;
            min-height: 500px;
        }

        .day-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 18px;
        }

        .date-text {
            font-size: 13px;
            color: #6b7280;
            margin-top: 3px;
        }

        .appointment {
            background: #4969df;
            color: white;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 16px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
        }

        .appointment-top {
            background: #9eaff5;
            height: 75px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: rgba(255, 255, 255, 0.75);
            font-size: 12px;
        }

        .appointment-body {
            padding: 12px;
        }

        .badge {
            display: inline-block;
            background: #ffb02e;
            color: white;
            padding: 4px 7px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .progress {
            height: 5px;
            background: #a9b8ef;
            border-radius: 10px;
            margin: 8px 0 12px 0;
            overflow: hidden;
        }

        .progress span {
            display: block;
            height: 100%;
            width: 70%;
            background: #7de36d;
        }

        .appointment-title {
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .appointment-info {
            font-size: 12px;
            line-height: 1.5;
        }

        .status {
            margin-top: 8px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            color: #ffe08a;
        }

        .approved {
            color: #a7ffb0;
        }

        .completed {
            color: #b7d4ff;
        }

        .cancelled {
            color: #ffb0b0;
        }

        .empty-slot {
            padding: 20px 10px;
            border: 1px dashed #b5bdca;
            border-radius: 12px;
            color: #7b8190;
            font-size: 13px;
            text-align: center;
        }

        @media (max-width: 1200px) {
            .week-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .filters {
                grid-template-columns: repeat(2, 1fr);
            }

            .sidebar {
                width: 210px;
            }
        }
    </style>
</head>
<body>
@php
    $startOfWeek = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY);
    $weekDays = collect();

    for ($i = 0; $i < 7; $i++) {
        $weekDays->push($startOfWeek->copy()->addDays($i));
    }

    $appointmentsByDate = $appointments->groupBy(function ($appointment) {
        return \Carbon\Carbon::parse($appointment->appointment_date)->format('Y-m-d');
    });
@endphp

<div class="layout">
    <aside class="sidebar">
        <div class="logo">Gym System</div>

        <div class="menu">
            <a href="{{ route('trainer.dashboard') }}" class="active">Dashboard</a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>Booking</h1>
                <p>Trainer appointment schedule</p>
            </div>

            <div class="trainer-name">
                {{ $trainer->name }}
            </div>
        </div>

        <div class="filters">
            <div class="filter-box">
                <label>Activity</label>
                <select>
                    <option>Fitness Training</option>
                    <option>Strength Training</option>
                    <option>Cardio</option>
                    <option>Full Body</option>
                </select>
            </div>

            <div class="filter-box">
                <label>Coach</label>
                <select>
                    <option>{{ $trainer->name }}</option>
                </select>
            </div>

            <div class="filter-box">
                <label>Search Date</label>
                <input type="date" value="{{ now()->format('Y-m-d') }}">
            </div>

            <div class="filter-box">
                <label>View Mode</label>
                <select>
                    <option>Weekly View</option>
                    <option>Daily View</option>
                </select>
            </div>
        </div>

        <div class="booking-card">
            <div class="booking-header">
                <h2>{{ now()->format('Y, F') }}</h2>
                <a href="{{ route('trainer.dashboard') }}" class="today">Today</a>
            </div>

            <div class="week-grid">
                @foreach($weekDays as $day)
                    @php
                        $dateKey = $day->format('Y-m-d');
                        $dayAppointments = $appointmentsByDate->get($dateKey, collect());
                    @endphp

                    <div class="day-column">
                        <div class="day-title">
                            {{ $day->format('l') }}
                            <div class="date-text">{{ $day->format('M d, Y') }}</div>
                        </div>

                        @forelse($dayAppointments as $appointment)
                            <div class="appointment">
                                <div class="appointment-top">
                                    Appointment
                                </div>

                                <div class="appointment-body">
                                    <span class="badge">FITNESS</span>

                                    <div class="appointment-info">
                                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('h:i A') }}
                                        -
                                        {{ \Carbon\Carbon::parse($appointment->end_time)->format('h:i A') }}
                                    </div>

                                    <div class="progress">
                                        <span></span>
                                    </div>

                                    <div class="appointment-title">
                                        {{ $appointment->member->full_name ?? 'Member' }}
                                    </div>

                                    <div class="appointment-info">
                                        {{ $appointment->notes ?? 'Gym training appointment' }}
                                    </div>

                                    <div class="status {{ $appointment->status }}">
                                        {{ ucfirst($appointment->status) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-slot">
                                No appointment
                            </div>
                        @endforelse
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
</body>
</html>
