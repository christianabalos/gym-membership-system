<!DOCTYPE html>
<html>
<head>
    <title>Edit Workout</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            font-size: 38px;
            font-weight: bold;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 14px;
            margin-bottom: 6px;
            font-size: 15px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input[readonly] {
            background: #f3f4f6;
            color: #374151;
            cursor: not-allowed;
        }

        textarea {
            resize: vertical;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            font-size: 14px;
        }

        .btn-back {
            background: #6b7280;
            color: white;
            margin-bottom: 10px;
        }

        .btn-save {
            background: #2563eb;
            color: white;
            width: 100%;
            margin-top: 25px;
        }

        .error-box {
            color: #991b1b;
            background: #fee2e2;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .time-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-top: 8px;
            margin-bottom: 14px;
        }

        .time-box {
            padding: 18px 12px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            border: 2px solid transparent;
            min-height: 78px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .time-box input {
            display: none;
        }

        .time-box.available {
            background: #dcfce7;
            color: #166534;
        }

        .time-box.taken {
            background: #fee2e2;
            color: #991b1b;
            border-color: #fca5a5;
            cursor: not-allowed;
        }

        .time-box.selected {
            background: #dbeafe;
            color: #1d4ed8;
            border-color: #2563eb;
        }

        .time-box small {
            display: block;
            margin-top: 6px;
            font-size: 12px;
        }

        .note {
            color: #6b7280;
            font-size: 13px;
            margin-top: 6px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            .time-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Workout</h1>

        <a href="{{ route('workouts.index') }}" class="btn btn-back">Back</a>

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @php
            $selectedTime = old('time', old('workout_time', $workout->workout_time ?? ''));

            $workoutTitle = old(
                'title',
                old('workout_name', $workout->title ?? $workout->workout_name ?? '')
            );

            $workoutDescription = old(
                'description',
                old('details', $workout->description ?? $workout->details ?? '')
            );

            $fixedWorkoutDate = old(
                'workout_date',
                \Carbon\Carbon::parse($workout->workout_date)->format('Y-m-d')
            );

            $displayWorkoutDate = \Carbon\Carbon::parse($fixedWorkoutDate)->format('m/d/Y');
        @endphp

        <form action="{{ route('workouts.update', $workout->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Member:</label>
            <input type="text" value="{{ $workout->member->full_name ?? 'N/A' }}" readonly>

            <label>Trainer:</label>
            <input type="text" value="{{ $workout->trainer->name ?? 'No Trainer' }}" readonly>

            <label>Day:</label>
            <select name="day" required>
                @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                    <option value="{{ $day }}" {{ old('day', $workout->day) == $day ? 'selected' : '' }}>
                        {{ $day }}
                    </option>
                @endforeach
            </select>

            <label>Workout Type:</label>
            <input type="text" name="workout_type" value="{{ old('workout_type', $workout->workout_type) }}" required>

            <label>Workout Title:</label>
            <input type="text" name="title" id="title" value="{{ $workoutTitle }}" required>

            <input type="hidden" name="workout_name" id="workout_name" value="{{ $workoutTitle }}">

            <label>Description:</label>
            <textarea name="description" id="description" rows="4">{{ $workoutDescription }}</textarea>

            <input type="hidden" name="details" id="details" value="{{ $workoutDescription }}">

            <label>Workout Date:</label>
            <input type="text" value="{{ $displayWorkoutDate }}" readonly>
            <input type="hidden" name="workout_date" value="{{ $fixedWorkoutDate }}">

            <label>Workout Time:</label>

            <input type="hidden" name="time" id="time" value="{{ $selectedTime }}" required>
            <input type="hidden" name="workout_time" id="workout_time" value="{{ $selectedTime }}">

            <div class="time-grid">
                @foreach($timeSlots as $slot)
                    <label class="time-box">
                        <input type="radio" name="time_slot_choice" value="{{ $slot }}">
                        <span class="time-main">{{ $slot }}</span>
                        <small>Available</small>
                    </label>
                @endforeach
            </div>

            <p class="note">
                Green = available, Blue = selected, Red = already booked.
            </p>

            <label>Status:</label>
            <select name="status" required>
                <option value="scheduled" {{ old('status', $workout->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                <option value="completed" {{ old('status', $workout->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="rest" {{ old('status', $workout->status) == 'rest' ? 'selected' : '' }}>Rest</option>
                <option value="missed" {{ old('status', $workout->status) == 'missed' ? 'selected' : '' }}>Missed</option>
            </select>

            <button type="submit" class="btn btn-save">Update Workout</button>
        </form>
    </div>

    <script>
        const takenSlotsByDay = @json($takenSlotsByDay);
        const timeSlots = @json($timeSlots);

        const daySelect = document.querySelector('select[name="day"]');
        const hiddenTime = document.getElementById('time');
        const hiddenWorkoutTime = document.getElementById('workout_time');

        const titleInput = document.getElementById('title');
        const workoutNameInput = document.getElementById('workout_name');

        const descriptionInput = document.getElementById('description');
        const detailsInput = document.getElementById('details');

        if (titleInput && workoutNameInput) {
            titleInput.addEventListener('input', function () {
                workoutNameInput.value = this.value;
            });
        }

        if (descriptionInput && detailsInput) {
            descriptionInput.addEventListener('input', function () {
                detailsInput.value = this.value;
            });
        }

        function refreshTimeButtons() {
            const selectedDay = daySelect.value;
            const takenSlots = takenSlotsByDay[selectedDay] || [];
            const currentSelectedTime = hiddenTime.value;

            document.querySelectorAll('.time-box').forEach(box => {
                const input = box.querySelector('input');
                const small = box.querySelector('small');
                const slot = input.value;

                const isTaken = takenSlots.includes(slot);
                const isSelected = currentSelectedTime === slot;

                box.classList.remove('available', 'taken', 'selected');

                input.disabled = false;
                input.checked = false;

                if (isSelected) {
                    box.classList.add('selected');
                    input.checked = true;
                    small.textContent = 'Selected';
                } else if (isTaken) {
                    box.classList.add('taken');
                    input.disabled = true;
                    small.textContent = 'Booked';
                } else {
                    box.classList.add('available');
                    small.textContent = 'Available';
                }
            });
        }

        document.querySelectorAll('.time-box input').forEach(input => {
            input.addEventListener('change', function () {
                if (this.disabled) {
                    return;
                }

                hiddenTime.value = this.value;
                hiddenWorkoutTime.value = this.value;

                refreshTimeButtons();
            });
        });

        daySelect.addEventListener('change', function () {
            hiddenTime.value = '';
            hiddenWorkoutTime.value = '';

            refreshTimeButtons();
        });

        refreshTimeButtons();
    </script>
</body>
</html>