<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>
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
            max-width: 760px;
            margin: auto;
            padding: 36px 24px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 32px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 8px 0 24px;
            color: #e5e7eb;
            font-size: 14px;
        }

        .top-actions {
            margin-bottom: 18px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(107, 114, 128, 0.9);
            color: white;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid rgba(255,255,255,0.15);
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .form-box {
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 18px;
            padding: 20px;
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .birth-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            width: 100%;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
            color: #ffffff;
            font-size: 14px;
        }

        input,
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

        input:focus,
        select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.22);
        }

        input[readonly] {
            background: rgba(229, 231, 235, 0.9);
            cursor: not-allowed;
        }

        .note,
        .price-note {
            margin-top: 6px;
            color: #e5e7eb;
            font-size: 12px;
            line-height: 1.4;
            font-weight: 600;
        }

        .trainer-schedule-box {
            display: none;
            margin-top: 10px;
        }

        .schedule-label {
            margin-top: 12px;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #ffffff;
        }

        .schedule-note {
            margin-top: 6px;
            color: #e5e7eb;
            font-size: 12px;
            line-height: 1.4;
            font-weight: 600;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 10px;
        }

        .schedule-slot {
            border: none;
            border-radius: 10px;
            padding: 12px 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .schedule-slot.available {
            background: #ccebd2;
            color: #166534;
        }

        .schedule-slot.booked {
            background: #f7d6d6;
            color: #b42318;
            cursor: not-allowed;
        }

        .schedule-slot.selected {
            outline: 3px solid #2563eb;
            background: #dbeafe;
            color: #1d4ed8;
        }

        .submit-btn {
            width: 100%;
            margin-top: 18px;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }

        .bottom-text {
            text-align: center;
            margin-top: 14px;
            font-size: 13px;
            color: #e5e7eb;
        }

        .bottom-text a {
            color: #93c5fd;
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .row {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 28px;
            }

            .birth-row {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
            }

            .birth-row select {
                padding: 12px 8px;
                font-size: 13px;
            }

            .schedule-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
@php
    $defaultSlots = [
        '8:00 AM - 9:00 AM',
        '9:00 AM - 10:00 AM',
        '10:00 AM - 11:00 AM',
        '1:00 PM - 2:00 PM',
        '2:00 PM - 3:00 PM',
        '4:00 PM - 5:00 PM',
    ];

    $trainerSchedules = [];

    foreach(($trainers ?? []) as $trainer) {
        $bookedSlots = [];

        if (isset($trainer->booked_times) && is_array($trainer->booked_times)) {
            foreach ($trainer->booked_times as $bookedTime) {
                $bookedSlots[$bookedTime] = true;
            }
        }

        $slots = [];

        foreach ($defaultSlots as $slotTime) {
            $slots[] = [
                'time' => $slotTime,
                'status' => isset($bookedSlots[$slotTime]) ? 'booked' : 'available',
            ];
        }

        $trainerSchedules[$trainer->id] = [
            'name' => $trainer->name,
            'specialization' => $trainer->specialization ?? '',
            'slots' => $slots,
        ];
    }
@endphp

    <div class="container">
        <h1>Add Member</h1>
        <p class="subtitle">Create a new gym member account.</p>

        <div class="top-actions">
            <a href="{{ route('members.index') }}" class="btn-back">Back</a>
        </div>

        <div class="form-box">
            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('members.store') }}" method="POST" id="memberForm">
                @csrf

                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="Enter your address" required>
                </div>

                <div class="form-group">
                    <label>Birth Date:</label>

                    <input type="hidden" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">

                    <div class="birth-row">
                        <select id="birth_month" required>
                            <option value="">Month</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>

                        <select id="birth_day" required>
                            <option value="">Day</option>
                            @for($day = 1; $day <= 31; $day++)
                                <option value="{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}">
                                    {{ $day }}
                                </option>
                            @endfor
                        </select>

                        <select id="birth_year" required>
                            <option value="">Year</option>
                            @for($year = now()->year; $year >= 1950; $year--)
                                <option value="{{ $year }}">
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="trainer_id">Trainer Option:</label>
                    <select id="trainer_id" name="trainer_id">
                        <option value="">No Trainer</option>
                        @foreach(($trainers ?? []) as $trainer)
                            <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                {{ $trainer->name }} - {{ $trainer->specialization }}
                            </option>
                        @endforeach
                    </select>

                    <div class="note" id="trainerNote">
                        No Trainer selected. Standard membership price applies.
                    </div>

                    <div class="trainer-schedule-box" id="trainerScheduleBox">
                        <div class="schedule-note" id="scheduleSummary"></div>
                        <div class="schedule-label">Schedule Time:</div>

                        <input type="hidden" name="schedule_time" id="schedule_time" value="{{ old('schedule_time') }}">

                        <div class="schedule-grid" id="scheduleGrid"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="plan_name">Plan:</label>
                        <select id="plan_name" name="plan_name">
                            <option value="">Select Plan</option>
                            <option value="Monthly" {{ old('plan_name') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="Quarterly" {{ old('plan_name') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="Annual" {{ old('plan_name') == 'Annual' ? 'selected' : '' }}>Annual</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" id="price" name="price" value="{{ old('price') }}" placeholder="Auto-computed price" readonly>

                        <div class="price-note">
                            Monthly ₱500 - Quarterly ₱1800 - Annual ₱5500 - With Trainer +₱300
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}">
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" readonly>
                    </div>
                </div>

                <div class="form-group">
                    <label for="payment_method">Payment Method:</label>
                    <select id="payment_method" name="payment_method">
                        <option value="">Select Payment Method</option>
                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                        <option value="Online" {{ old('payment_method') == 'Online Payment' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>

                <button type="submit" class="submit-btn">Save Member</button>

                <div class="bottom-text">
                    Go back to <a href="{{ route('members.index') }}">Members List</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const trainerSelect = document.getElementById('trainer_id');
        const planSelect = document.getElementById('plan_name');
        const priceInput = document.getElementById('price');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const trainerNote = document.getElementById('trainerNote');

        const trainerScheduleBox = document.getElementById('trainerScheduleBox');
        const scheduleSummary = document.getElementById('scheduleSummary');
        const scheduleGrid = document.getElementById('scheduleGrid');
        const scheduleTimeInput = document.getElementById('schedule_time');

        const trainerSchedules = @json($trainerSchedules);

        const basePrices = {
            Monthly: 500,
            Quarterly: 1800,
            Annual: 5500
        };

        function updateTrainerNote() {
            if (trainerSelect.value) {
                trainerNote.textContent = 'Trainer selected. Additional ₱300 trainer fee will be added.';
            } else {
                trainerNote.textContent = 'No Trainer selected. Standard membership price applies.';
            }
        }

        function updatePrice() {
            const plan = planSelect.value;
            let total = 0;

            if (plan && basePrices[plan]) {
                total = basePrices[plan];

                if (trainerSelect.value) {
                    total += 300;
                }

                priceInput.value = '₱' + total.toFixed(2);
            } else {
                priceInput.value = '';
            }
        }

        function updateEndDate() {
            const plan = planSelect.value;
            const startDate = startDateInput.value;

            if (!plan || !startDate) {
                endDateInput.value = '';
                return;
            }

            const date = new Date(startDate);

            if (plan === 'Monthly') {
                date.setMonth(date.getMonth() + 1);
            } else if (plan === 'Quarterly') {
                date.setMonth(date.getMonth() + 4);
            } else if (plan === 'Annual') {
                date.setFullYear(date.getFullYear() + 1);
            }

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            endDateInput.value = `${year}-${month}-${day}`;
        }

        function renderTrainerSchedule() {
            const trainerId = trainerSelect.value;

            scheduleGrid.innerHTML = '';
            scheduleTimeInput.value = '';

            if (!trainerId) {
                trainerScheduleBox.style.display = 'none';
                scheduleSummary.textContent = '';
                return;
            }

            const trainerData = trainerSchedules[trainerId];

            if (!trainerData || !trainerData.slots || trainerData.slots.length === 0) {
                trainerScheduleBox.style.display = 'none';
                scheduleSummary.textContent = '';
                return;
            }

            trainerScheduleBox.style.display = 'block';

            const bookedCount = trainerData.slots.filter(slot => slot.status === 'booked').length;
            const availableCount = trainerData.slots.filter(slot => slot.status === 'available').length;

            scheduleSummary.textContent = `${bookedCount}/${trainerData.slots.length} Booked, ${availableCount} available. Please choose your preferred schedule time.`;

            trainerData.slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = `schedule-slot ${slot.status}`;
                btn.textContent = `${slot.time} - ${slot.status === 'booked' ? 'Booked' : 'Available'}`;

                if (slot.status === 'booked') {
                    btn.disabled = true;
                } else {
                    btn.addEventListener('click', function () {
                        document.querySelectorAll('.schedule-slot.available').forEach(el => {
                            el.classList.remove('selected');
                        });

                        btn.classList.add('selected');
                        scheduleTimeInput.value = slot.time;
                    });
                }

                scheduleGrid.appendChild(btn);
            });
        }

        trainerSelect.addEventListener('change', function () {
            updateTrainerNote();
            updatePrice();
            renderTrainerSchedule();
        });

        planSelect.addEventListener('change', function () {
            updatePrice();
            updateEndDate();
        });

        startDateInput.addEventListener('change', updateEndDate);

        updateTrainerNote();
        updatePrice();
        updateEndDate();
        renderTrainerSchedule();

        const birthDateInput = document.getElementById('birth_date');
        const birthMonth = document.getElementById('birth_month');
        const birthDay = document.getElementById('birth_day');
        const birthYear = document.getElementById('birth_year');

        function updateBirthDate() {
            if (birthYear.value && birthMonth.value && birthDay.value) {
                birthDateInput.value = `${birthYear.value}-${birthMonth.value}-${birthDay.value}`;
            } else {
                birthDateInput.value = '';
            }
        }

        birthMonth.addEventListener('change', updateBirthDate);
        birthDay.addEventListener('change', updateBirthDate);
        birthYear.addEventListener('change', updateBirthDate);

        if (birthDateInput.value) {
            const parts = birthDateInput.value.split('-');

            if (parts.length === 3) {
                birthYear.value = parts[0];
                birthMonth.value = parts[1];
                birthDay.value = parts[2];
            }
        }
    </script>
</body>
</html>