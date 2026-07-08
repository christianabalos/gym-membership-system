<!DOCTYPE html>
<html>
<head>
    <title>Trainers</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 1250px;
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
            text-align: center;
            margin-top: 40px;
            margin-bottom: 22px;
            font-size: 28px;
        }

        .top-actions {
            margin-bottom: 35px;
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
            background: #dcfce7;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }

        th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 15px;
        }

        td {
            padding: 14px;
            border: 1px solid #d1d5db;
            vertical-align: top;
            font-size: 15px;
        }

        .trainer-table td {
            vertical-align: middle;
        }

        .trainer-name {
            font-weight: bold;
        }

        .members-list {
            margin: 0;
            padding-left: 18px;
        }

        .no-members {
            color: #6b7280;
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

        .program-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        }

        .program-card h3 {
            margin: 0;
            font-size: 20px;
        }

        .program-specialization {
            color: #6b7280;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .program-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .program-table th {
            background: #111827;
            color: white;
            padding: 10px;
            font-size: 14px;
        }

        .program-table td {
            padding: 10px;
            border: 1px solid #d1d5db;
            font-size: 14px;
        }

        .program-table tr:last-child td {
            background: #fef3c7;
            font-weight: bold;
            color: #92400e;
        }

        .calendar-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 18px;
            margin-bottom: 18px;
        }

        .calendar-btn {
            padding: 9px 14px;
            border: none;
            border-radius: 7px;
            background: #111827;
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

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            border: 1px solid #d1d5db;
            margin-bottom: 40px;
        }

        .calendar-day-header {
            background: #111827;
            color: white;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #d1d5db;
        }

        .calendar-day {
            min-height: 130px;
            padding: 8px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            font-size: 13px;
        }

        .calendar-date {
            font-weight: bold;
            margin-bottom: 6px;
        }

        .calendar-empty {
            background: #f3f4f6;
        }

        .calendar-item {
            padding: 7px 8px;
            border-radius: 8px;
            margin-top: 6px;
            font-size: 12px;
            line-height: 1.35;
            font-weight: 600;
        }

        .calendar-item strong {
            display: block;
        }

        .schedule-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 30px;
            background: #ffffff;
        }

        .schedule-card h3 {
            margin: 0;
            font-size: 22px;
        }

        .specialization {
            margin-top: 5px;
            margin-bottom: 18px;
            color: #374151;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .schedule-table th {
            background: #111827;
            color: white;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            text-align: center;
        }

        .schedule-table td {
            padding: 12px;
            border: 1px solid #d1d5db;
            text-align: center;
            vertical-align: middle;
        }

        .time-cell {
            font-weight: bold;
            background: #f9fafb;
            text-align: center;
            width: 190px;
        }

        .slot-box {
            padding: 8px 10px;
            border-radius: 8px;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            min-width: 90px;
            display: inline-block;
        }

        .available {
            background: #dcfce7;
            color: #166534;
        }

        .booked {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .rest {
            background: #fef3c7;
            color: #92400e;
        }

        @media (max-width: 900px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 20px;
            }

            .program-grid {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 13px;
            }

            th,
            td {
                padding: 9px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Trainers</h1>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <h2>Trainer List</h2>

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

        <h2>Trainer Workout Programs</h2>

        @php
            function trainerProgram($specialization) {
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
            }
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

                        @foreach(trainerProgram($trainer->specialization) as $program)
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

        <div class="calendar-grid" id="calendarGrid"></div>

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

        @foreach($trainers as $trainer)
            <div class="schedule-card">
                <h3>{{ $trainer->name }}</h3>
                <div class="specialization">{{ $trainer->specialization }}</div>

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
        @endforeach
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
            @foreach($calendarMemberships as $membership)
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