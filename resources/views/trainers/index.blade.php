<!DOCTYPE html>
<html>
<head>
    <title>Trainers</title>
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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 28px;
        }

        h1 {
            margin: 0;
            font-size: 36px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        h2 {
            text-align: center;
            margin-top: 35px;
            margin-bottom: 22px;
            font-size: 28px;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        h3 {
            margin: 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
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
            background: rgba(107, 114, 128, 0.85);
            color: white;
        }

        .btn-view {
            background: #2563eb;
            color: white;
        }

        .btn-edit {
            background: #6b7280;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .success {
            color: #166534;
            background: rgba(220, 252, 231, 0.92);
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-weight: bold;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
            margin-bottom: 35px;
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
            background: rgba(15, 23, 42, 0.88);
            color: #ffffff;
            padding: 14px;
            text-align: center;
            font-size: 13px;
        }

        td {
            padding: 14px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.18);
            vertical-align: middle;
            font-size: 13px;
        }

        tr:nth-child(even) {
            background: transparent;
        }

        .trainer-name {
            font-weight: 800;
            color: #ffffff;
        }

        .members-list {
            margin: 0;
            padding-left: 18px;
        }

        .members-list li {
            margin-bottom: 4px;
            font-weight: 600;
            color: #ffffff;
        }

        .no-members {
            display: inline-block;
            background: rgba(255, 255, 255, 0.18);
            color: #e5e7eb;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        .delete-form {
            display: inline;
            margin: 0;
        }

        .program-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
            margin-bottom: 45px;
        }

        .program-card,
        .schedule-card {
            background: rgba(255, 255, 255, 0.10);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.25);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .program-card h3,
        .schedule-card h3 {
            font-size: 20px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.35);
        }

        .program-specialization,
        .specialization {
            color: #dbeafe;
            margin-top: 5px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .program-table,
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            border-radius: 12px;
            overflow: hidden;
        }

        .program-table th,
        .schedule-table th {
            background: rgba(15, 23, 42, 0.92);
            color: #ffffff;
            padding: 11px;
            font-size: 13px;
        }

        .program-table td,
        .schedule-table td {
            padding: 11px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 13px;
        }

        .program-table tr:last-child td {
            background: rgba(254, 243, 199, 0.82);
            font-weight: bold;
            color: #92400e;
        }

        .calendar-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 18px;
            margin-bottom: 14px;
        }

        .calendar-controls h3 {
            color: #ffffff;
            min-width: 160px;
            text-align: center;
            text-shadow: 0 3px 10px rgba(0,0,0,0.45);
        }

        .calendar-btn {
            padding: 9px 14px;
            border: none;
            border-radius: 9px;
            background: rgba(15, 23, 42, 0.92);
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        .trainer-legend {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 18px;
        }

        .legend-item {
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .legend-0 { background: #dbeafe; color: #1d4ed8; }
        .legend-1 { background: #dcfce7; color: #166534; }
        .legend-2 { background: #fef3c7; color: #92400e; }
        .legend-3 { background: #fce7f3; color: #be185d; }
        .legend-4 { background: #ede9fe; color: #6d28d9; }
        .legend-5 { background: #ccfbf1; color: #0f766e; }
        .legend-6 { background: #ffedd5; color: #c2410c; }
        .legend-7 { background: #e0f2fe; color: #0369a1; }

        .calendar-scroll {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 40px;
            border-radius: 14px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 14px;
            overflow: hidden;
            min-width: 950px;
        }

        .calendar-day-header {
            background: rgba(15, 23, 42, 0.92);
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .calendar-day {
            min-height: 135px;
            padding: 8px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 12px;
        }

        .calendar-date {
            font-weight: 800;
            margin-bottom: 7px;
            color: #ffffff;
        }

        .calendar-empty {
            background: rgba(255, 255, 255, 0.04);
        }

        .calendar-item {
            padding: 7px 8px;
            border-radius: 8px;
            margin-top: 6px;
            font-size: 11px;
            line-height: 1.35;
            font-weight: 600;
        }

        .calendar-item strong {
            display: block;
            font-size: 12px;
            margin-bottom: 2px;
        }

        .schedule-list {
            display: grid;
            gap: 24px;
        }

        .time-cell {
            font-weight: bold;
            background: rgba(15, 23, 42, 0.45);
            color: #ffffff;
            text-align: center;
            width: 190px;
        }

        .slot-box {
            padding: 8px 10px;
            border-radius: 8px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            min-width: 90px;
            display: inline-block;
        }

        .available {
            background: rgba(220, 252, 231, 0.85);
            color: #166534;
        }

        .booked {
            background: rgba(219, 234, 254, 0.85);
            color: #1d4ed8;
        }

        .rest {
            background: rgba(254, 243, 199, 0.85);
            color: #92400e;
        }

        @media (max-width: 1000px) {
            .program-grid {
                grid-template-columns: 1fr;
            }

            table {
                min-width: 900px;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            h1 {
                font-size: 28px;
            }

            h2 {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="page-header">
            <h1>Trainers</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <h2>Trainer List</h2>

        <div class="table-wrap">
            <table class="trainer-table">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Specialization</th>
                    <th>Members</th>
                    <th>Action</th>
                </tr>

                @forelse($trainers as $trainer)
                    <tr>
                        <td class="trainer-name">{{ $trainer->name }}</td>
                        <td>{{ $trainer->email }}</td>
                        <td>{{ $trainer->phone }}</td>
                        <td>{{ $trainer->specialization }}</td>

                        <td>
                            @php
                                $uniqueMembers = $trainer->memberships
                                    ->whereIn('status', ['active', 'approved'])
                                    ->pluck('member')
                                    ->filter()
                                    ->unique('id');
                            @endphp

                            @if($uniqueMembers->count() > 0)
                                <ul class="members-list">
                                    @foreach($uniqueMembers as $member)
                                        <li>{{ $member->full_name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="no-members">No members</span>
                            @endif
                        </td>

                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('trainers.show', $trainer->id) }}" class="btn btn-view">View</a>
                                <a href="{{ route('trainers.edit', $trainer->id) }}" class="btn btn-edit">Edit</a>

                                <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Delete this trainer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">No trainers found.</td>
                    </tr>
                @endforelse
            </table>
        </div>

        <h2>Trainer Workout Programs</h2>

        @php
            $trainerProgram = function ($specialization) {
                $specialization = strtolower($specialization ?? '');

                if (str_contains($specialization, 'cardio')) {
                    return [
                        ['day' => 'Monday', 'workout' => 'Treadmill Endurance'],
                        ['day' => 'Tuesday', 'workout' => 'HIIT Cardio Workout'],
                        ['day' => 'Wednesday', 'workout' => 'Core Cardio Circuit'],
                        ['day' => 'Thursday', 'workout' => 'Cycling Workout'],
                        ['day' => 'Friday', 'workout' => 'Endurance Builder'],
                        ['day' => 'Saturday', 'workout' => 'Fat Burn Conditioning'],
                        ['day' => 'Sunday', 'workout' => 'Recovery Day / Rest'],
                    ];
                }

                if (str_contains($specialization, 'weight')) {
                    return [
                        ['day' => 'Monday', 'workout' => 'Weight Loss Circuit'],
                        ['day' => 'Tuesday', 'workout' => 'Fat Burn Cardio'],
                        ['day' => 'Wednesday', 'workout' => 'Core Fat Loss Workout'],
                        ['day' => 'Thursday', 'workout' => 'Lower Body Fat Burn'],
                        ['day' => 'Friday', 'workout' => 'Upper Body Toning'],
                        ['day' => 'Saturday', 'workout' => 'Calorie Burn Workout'],
                        ['day' => 'Sunday', 'workout' => 'Recovery Day / Rest'],
                    ];
                }

                if (str_contains($specialization, 'strength')) {
                    return [
                        ['day' => 'Monday', 'workout' => 'Push Muscle Builder'],
                        ['day' => 'Tuesday', 'workout' => 'Pull Muscle Builder'],
                        ['day' => 'Wednesday', 'workout' => 'Leg Muscle Builder'],
                        ['day' => 'Thursday', 'workout' => 'Upper Body Hypertrophy'],
                        ['day' => 'Friday', 'workout' => 'Lower Body Hypertrophy'],
                        ['day' => 'Saturday', 'workout' => 'Muscle Conditioning Workout'],
                        ['day' => 'Sunday', 'workout' => 'Recovery Day / Rest'],
                    ];
                }

                return [
                    ['day' => 'Monday', 'workout' => 'Flexibility Flow'],
                    ['day' => 'Tuesday', 'workout' => 'Mobility Training'],
                    ['day' => 'Wednesday', 'workout' => 'Core Stability'],
                    ['day' => 'Thursday', 'workout' => 'Full Body Stretch'],
                    ['day' => 'Friday', 'workout' => 'Balance and Posture'],
                    ['day' => 'Saturday', 'workout' => 'General Fitness Circuit'],
                    ['day' => 'Sunday', 'workout' => 'Recovery Day / Rest'],
                ];
            };
        @endphp

        <div class="program-grid">
            @foreach($trainers as $trainer)
                <div class="program-card">
                    <h3>{{ $trainer->name }}</h3>
                    <p class="program-specialization">{{ $trainer->specialization }}</p>

                    <table class="program-table">
                        <tr>
                            <th>Day</th>
                            <th>Workout</th>
                        </tr>

                        @foreach($trainerProgram($trainer->specialization) as $program)
                            <tr>
                                <td>{{ $program['day'] }}</td>
                                <td>{{ $program['workout'] }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endforeach
        </div>

        <h2>Membership Schedule Calendar</h2>

        <div class="calendar-controls">
            <button type="button" onclick="previousMonth()" class="calendar-btn">Previous</button>
            <h3 id="calendarTitle"></h3>
            <button type="button" onclick="nextMonth()" class="calendar-btn">Next</button>
        </div>

        <div class="trainer-legend">
            @foreach($trainers as $index => $trainer)
                <span class="legend-item legend-{{ $index % 8 }}">
                    {{ $trainer->name }}
                </span>
            @endforeach
        </div>

        <div class="calendar-scroll">
            <div class="calendar-grid" id="calendarGrid"></div>
        </div>

        <h2>Trainer Schedule</h2>

        @php
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            $cleanTimeSlots = [
                '8:00 AM - 9:00 AM',
                '9:00 AM - 10:00 AM',
                '10:00 AM - 11:00 AM',
                '1:00 PM - 2:00 PM',
                '2:00 PM - 3:00 PM',
                '4:00 PM - 5:00 PM',
            ];
        @endphp

        <div class="schedule-list">
            @foreach($trainers as $trainer)
                <div class="schedule-card">
                    <h3>{{ $trainer->name }}</h3>
                    <div class="specialization">{{ $trainer->specialization }}</div>

                    <div class="table-wrap">
                        <table class="schedule-table">
                            <tr>
                                <th>Time</th>
                                @foreach($days as $day)
                                    <th>{{ $day }}</th>
                                @endforeach
                            </tr>

                            @foreach($cleanTimeSlots as $time)
                                <tr>
                                    <td class="time-cell">{{ $time }}</td>

                                    @foreach($days as $day)
                                        @php
                                            $cell = $trainer->scheduleGrid[$time][$day] ?? null;
                                        @endphp

                                        <td>
                                            @if($cell)
                                                @if(($cell['status'] ?? '') === 'rest')
                                                    <div class="slot-box rest">Rest</div>
                                                @else
                                                    <div class="slot-box booked">
                                                        {{ $cell['member'] }}
                                                    </div>
                                                @endif
                                            @else
                                                <div class="slot-box available">Available</div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        let currentDate = new Date();

        const trainerColors = {
            @foreach($trainers as $index => $trainer)
                "{{ $trainer->name }}": {
                    background: [
                        '#dbeafe',
                        '#dcfce7',
                        '#fef3c7',
                        '#fce7f3',
                        '#ede9fe',
                        '#ccfbf1',
                        '#ffedd5',
                        '#e0f2fe'
                    ][{{ $index }} % 8],
                    text: [
                        '#1d4ed8',
                        '#166534',
                        '#92400e',
                        '#be185d',
                        '#6d28d9',
                        '#0f766e',
                        '#c2410c',
                        '#0369a1'
                    ][{{ $index }} % 8],
                    border: [
                        '#2563eb',
                        '#16a34a',
                        '#d97706',
                        '#db2777',
                        '#7c3aed',
                        '#14b8a6',
                        '#ea580c',
                        '#0284c7'
                    ][{{ $index }} % 8]
                },
            @endforeach
        };

        const calendarData = [
            @foreach(($calendarMemberships ?? collect()) as $membership)
                {
                    member: @json($membership->member->full_name ?? 'N/A'),
                    trainer: @json($membership->trainer->name ?? 'No Trainer'),
                    plan: @json($membership->plan_name ?? 'N/A'),
                    start_date: @json(\Carbon\Carbon::parse($membership->start_date)->format('Y-m-d')),
                    end_date: @json(\Carbon\Carbon::parse($membership->end_date)->format('Y-m-d')),
                    status: @json($membership->status ?? 'pending')
                },
            @endforeach
        ];

        const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        function formatDateLocal(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function renderCalendar() {
            const calendarGrid = document.getElementById('calendarGrid');
            const calendarTitle = document.getElementById('calendarTitle');

            calendarGrid.innerHTML = '';

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            const monthName = currentDate.toLocaleString('default', {
                month: 'long'
            });

            calendarTitle.innerText = `${monthName} ${year}`;

            dayNames.forEach(day => {
                const header = document.createElement('div');
                header.className = 'calendar-day-header';
                header.innerText = day;
                calendarGrid.appendChild(header);
            });

            const firstDay = new Date(year, month, 1);
            const startingDay = firstDay.getDay();

            const lastDay = new Date(year, month + 1, 0);
            const totalDays = lastDay.getDate();

            for (let i = 0; i < startingDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.className = 'calendar-day calendar-empty';
                calendarGrid.appendChild(emptyCell);
            }

            for (let day = 1; day <= totalDays; day++) {
                const date = new Date(year, month, day);
                const dateString = formatDateLocal(date);

                const dayCell = document.createElement('div');
                dayCell.className = 'calendar-day';

                const dateLabel = document.createElement('div');
                dateLabel.className = 'calendar-date';
                dateLabel.innerText = day;
                dayCell.appendChild(dateLabel);

                const membershipsForDate = calendarData.filter(item => {
                    return dateString >= item.start_date && dateString <= item.end_date;
                });

                membershipsForDate.forEach(item => {
                    const membershipDiv = document.createElement('div');
                    membershipDiv.className = 'calendar-item';

                    const color = trainerColors[item.trainer] || {
                        background: '#e5e7eb',
                        text: '#374151',
                        border: '#6b7280'
                    };

                    membershipDiv.style.background = color.background;
                    membershipDiv.style.color = color.text;
                    membershipDiv.style.borderLeft = `6px solid ${color.border}`;

                    membershipDiv.innerHTML = `
                        <strong>${item.member}</strong>
                        Trainer: ${item.trainer}<br>
                        Plan: ${item.plan}<br>
                        Status: ${item.status}
                    `;

                    dayCell.appendChild(membershipDiv);
                });

                calendarGrid.appendChild(dayCell);
            }
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        }

        renderCalendar();
    </script>
</body>
</html>