<!DOCTYPE html>
<html>
<head>
    <title>Edit Workout</title>
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
            max-width: 920px;
            margin: auto;
            padding: 34px 26px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.24);
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
            font-size: 14px;
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
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.96;
        }

        .btn-back {
            background: rgba(107, 114, 128, 0.92);
            color: #ffffff;
        }

        .form-card {
            padding: 24px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: 700;
        }

        .error-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            font-weight: 800;
            margin-bottom: 8px;
            color: #ffffff;
            font-size: 14px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 13px 14px;
            border-radius: 10px;
            border: 1px solid rgba(203, 213, 225, 0.95);
            font-size: 14px;
            background: rgba(255,255,255,0.95);
            color: #111827;
            outline: none;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.22);
        }

        input[readonly] {
            background: rgba(229, 231, 235, 0.92);
            cursor: not-allowed;
        }

        textarea {
            resize: vertical;
            min-height: 110px;
        }

        .section-title {
            margin: 8px 0 14px;
            font-size: 18px;
            font-weight: 800;
            color: #ffffff;
        }

        .schedule-wrapper {
            margin-top: 6px;
            margin-bottom: 10px;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 10px;
        }

        .schedule-option {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            min-height: 76px;
            padding: 13px 10px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            user-select: none;
            border: 2px solid transparent;
            transition: 0.2s ease;
        }

        .schedule-option:hover {
            transform: translateY(-1px);
        }

        .schedule-option input {
            display: none;
        }

        .schedule-option .slot-time {
            font-size: 13px;
            line-height: 1.25;
        }

        .schedule-option .slot-status {
            margin-top: 5px;
            font-size: 11px;
        }

        .schedule-option.available {
            background: rgba(220, 252, 231, 0.95);
            color: #166534;
            border-color: #86efac;
        }

        .schedule-option.booked {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border-color: #fca5a5;
            cursor: not-allowed;
        }

        .schedule-option.selected {
            background: rgba(219, 234, 254, 0.98);
            color: #1d4ed8;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18);
        }

        .schedule-summary {
            margin-top: 8px;
            color: #dbeafe;
            font-size: 13px;
            font-weight: 700;
        }

        .helper-note {
            margin-top: 4px;
            color: #e5e7eb;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.4;
        }

        .status-area {
            margin-top: 18px;
        }

        .submit-btn {
            width: 100%;
            margin-top: 10px;
            padding: 14px;
            border: none;
            border-radius: 11px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
            transition: 0.2s;
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }

        @media (max-width: 768px) {
            body {
                padding: 18px 12px;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 30px;
            }

            .row,
            .schedule-grid {
                grid-template-columns: 1fr;
            }

            .top-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    @php
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $scheduleSlots = $scheduleSlots ?? [
            '8:00 AM - 9:00 AM',
            '9:00 AM - 10:00 AM',
            '10:00 AM - 11:00 AM',
            '1:00 PM - 2:00 PM',
            '2:00 PM - 3:00 PM',
            '4:00 PM - 5:00 PM',
        ];

        $selectedDay = old('day', $workout->day ?? '');
        $selectedTime = old('schedule_time', $workout->schedule_time ?? $workout->time ?? '');
        $selectedType = old('workout_type', $workout->workout_type ?? $workout->type ?? '');
        $selectedTitle = old('title', $workout->title ?? $workout->workout_title ?? '');
        $selectedDetails = old('details', $workout->details ?? $workout->description ?? '');
        $selectedStatus = old('status', $workout->status ?? 'scheduled');

        $selectedDate = old(
            'workout_date',
            !empty($workout->workout_date)
                ? \Carbon\Carbon::parse($workout->workout_date)->format('Y-m-d')
                : ''
        );
    @endphp

    <div class="container">
        <h1>Edit Workout</h1>
        <p class="subtitle">Update workout information and schedule time.</p>

        <div class="top-actions">
            <a href="{{ route('workouts.index') }}" class="btn btn-back">Back</a>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('workouts.update', $workout->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="member_id" value="{{ $workout->member_id }}">
                <input type="hidden" name="trainer_id" id="trainer_id" value="{{ $workout->trainer_id }}">
                <input type="hidden" name="schedule_time" id="selected_schedule_time" value="{{ $selectedTime }}">
<input type="hidden" name="time" id="selected_time" value="{{ $selectedTime }}">
<input type="hidden" name="workout_time" id="selected_workout_time" value="{{ $selectedTime }}">

                <div class="row">
                    <div class="form-group">
                        <label>Member:</label>
                        <input type="text" value="{{ $workout->member->full_name ?? 'N/A' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Trainer:</label>
                        <input type="text" value="{{ $workout->trainer->name ?? 'No Trainer' }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="day">Day:</label>
                        <select id="day" name="day" required>
                            @foreach($days as $day)
                                <option value="{{ $day }}" {{ $selectedDay === $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="workout_type">Workout Type:</label>
                        <input type="text" id="workout_type" name="workout_type" value="{{ $selectedType }}" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="title">Workout Title:</label>
                        <input type="text" id="title" name="title" value="{{ $selectedTitle }}" readonly required>
                    </div>

                    <div class="form-group full-width">
                        <label for="details">Description:</label>
                        <textarea id="details" name="details" required>{{ $selectedDetails }}</textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="workout_date">Workout Date:</label>
                        <input
                            type="date"
                            id="workout_date"
                            name="workout_date"
                            value="{{ $selectedDate }}"
                            readonly
                            required
                        >
                    </div>
                </div>

                <div class="form-group schedule-area">
                    <div class="section-title">Workout Time</div>

                    <div class="schedule-wrapper">
                        <div id="scheduleGrid" class="schedule-grid"></div>
                        <div id="scheduleSummary" class="schedule-summary"></div>
                        <div class="helper-note">
                            Green = available, Blue = selected, Red = already booked for the selected day.
                        </div>
                    </div>
                </div>

                <div class="form-group status-area">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="scheduled" {{ $selectedStatus === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ $selectedStatus === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="rest" {{ $selectedStatus === 'rest' ? 'selected' : '' }}>Rest</option>
                        <option value="cancelled" {{ $selectedStatus === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <button type="submit" class="submit-btn">Update Workout</button>
            </form>
        </div>
    </div>

    <script>
        const daySelect = document.getElementById('day');
        const trainerIdInput = document.getElementById('trainer_id');
        const selectedScheduleTimeInput = document.getElementById('selected_schedule_time');
const selectedTimeInput = document.getElementById('selected_time');
const selectedWorkoutTimeInput = document.getElementById('selected_workout_time');
        const scheduleGrid = document.getElementById('scheduleGrid');
        const scheduleSummary = document.getElementById('scheduleSummary');
        const workoutTypeInput = document.getElementById('workout_type');
        const titleInput = document.getElementById('title');

        const currentWorkoutId = @json($workout->id);
        const scheduleSlots = @json($scheduleSlots);
        const trainerBookings = @json($trainerBookings ?? []);

        function normalize(value) {
            return String(value ?? '')
                .trim()
                .toLowerCase()
                .replace(/\s+/g, ' ');
        }

        function generateWorkoutTitle() {
            const type = workoutTypeInput.value.trim();
            const day = daySelect.value;

            const titles = {
                'Upper Body': 'Upper Body Toning',
                'Lower Body': 'Lower Body Strength',
                'Full Body': 'Full Body Circuit',
                'Cardio': 'Fat Burn Cardio',
                'Core': 'Core Fat Loss Workout',
                'Conditioning': 'Calorie Burn Workout',
                'Recovery': 'Recovery Day',
                'Rest Day': 'Sunday Rest',
                'Rest': 'Sunday Rest'
            };

            if (day === 'Sunday') {
                titleInput.value = 'Sunday Rest';
                return;
            }

            if (titles[type]) {
                titleInput.value = titles[type];
            } else if (type) {
                titleInput.value = type + ' Workout';
            } else {
                titleInput.value = '';
            }
        }

        function isBooked(slotTime) {
    const trainerId = trainerIdInput.value;
    const selectedDay = daySelect.value;

    return trainerBookings.some(booking => {
        const sameWorkout = String(booking.id ?? '') === String(currentWorkoutId);

        if (sameWorkout) {
            return false;
        }

        const bookingTime =
            booking.schedule_time ??
            booking.workout_time ??
            booking.time ??
            '';

        const sameTrainer = String(booking.trainer_id ?? '') === String(trainerId);
        const sameDay = normalize(booking.day ?? '') === normalize(selectedDay);
        const sameTime = normalize(bookingTime) === normalize(slotTime);

        return sameTrainer && sameDay && sameTime;
    });
        }

        function renderScheduleTimes() {
            const selectedDay = daySelect.value;
            let selectedTime = selectedScheduleTimeInput.value;
            let bookedCount = 0;

            scheduleGrid.innerHTML = '';

            scheduleSlots.forEach(slot => {
                const booked = isBooked(slot);
                const selected = normalize(selectedTime) === normalize(slot);

                if (booked) {
                    bookedCount++;
                }

                const label = document.createElement('label');
                label.className = 'schedule-option';

                if (booked) {
                    label.classList.add('booked');
                } else if (selected) {
                    label.classList.add('selected');
                } else {
                    label.classList.add('available');
                }

                label.innerHTML = `
                    <input
                        type="radio"
                        name="schedule_time_option"
                        value="${slot}"
                        ${selected ? 'checked' : ''}
                        ${booked ? 'disabled' : ''}
                    >
                    <span class="slot-time">${slot}</span>
                    <span class="slot-status">${booked ? 'Booked' : (selected ? 'Selected' : 'Available')}</span>
                `;

                if (!booked) {
                    label.addEventListener('click', function () {
                       selectedScheduleTimeInput.value = slot;
selectedTimeInput.value = slot;
selectedWorkoutTimeInput.value = slot;
renderScheduleTimes();
                    });
                }

                scheduleGrid.appendChild(label);
            });

            const availableCount = scheduleSlots.length - bookedCount;
            scheduleSummary.textContent = `${bookedCount}/${scheduleSlots.length} booked for ${selectedDay}. ${availableCount} available.`;
        }

        daySelect.addEventListener('change', function () {
            generateWorkoutTitle();
            renderScheduleTimes();
        });

        workoutTypeInput.addEventListener('input', function () {
            generateWorkoutTitle();
        });

        generateWorkoutTitle();
        renderScheduleTimes();
    </script>
</body>
</html>