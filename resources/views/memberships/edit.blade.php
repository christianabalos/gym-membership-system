<!DOCTYPE html>
<html>
<head>
    <title>Edit Membership</title>
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
            max-width: 720px;
            margin: auto;
            padding: 34px 30px;
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
            font-size: 34px;
            font-weight: 900;
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

        .btn-gray {
            background: rgba(107, 114, 128, 0.92);
            color: #ffffff;
        }

        .form-card {
            margin-top: 22px;
            padding: 24px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }

        .error {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: 700;
        }

        .error p {
            margin: 4px 0;
        }

        label {
            display: block;
            font-weight: 800;
            margin-top: 15px;
            margin-bottom: 8px;
            color: #ffffff;
            font-size: 14px;
        }

        input,
        select {
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
        select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.22);
        }

        input[readonly],
        select:disabled {
            background: rgba(229, 231, 235, 0.92);
            cursor: not-allowed;
        }

        .note {
            font-size: 13px;
            margin-top: 8px;
            font-weight: 800;
            color: #dcfce7;
        }

        .warning-note {
            margin-top: 10px;
            padding: 12px 14px;
            border-radius: 10px;
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            font-size: 13px;
            font-weight: 800;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .slot-btn {
            padding: 13px 10px;
            border-radius: 12px;
            text-align: center;
            font-size: 13px;
            font-weight: 900;
            border: 2px solid transparent;
            transition: 0.2s;
        }

        .slot-btn:hover:not(:disabled) {
            transform: translateY(-1px);
        }

        .slot-booked {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border-color: #fca5a5;
            cursor: not-allowed;
        }

        .slot-available {
            background: rgba(220, 252, 231, 0.95);
            color: #166534;
            border-color: #86efac;
            cursor: pointer;
        }

        .slot-selected {
            background: rgba(219, 234, 254, 0.98);
            color: #1d4ed8;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.18);
        }

        .price-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .actions {
            text-align: center;
            margin-top: 26px;
        }

        button[type="submit"] {
            width: 100%;
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

        button[type="submit"]:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        @media (max-width: 700px) {
            body {
                padding: 18px 12px;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 29px;
            }

            .schedule-grid,
            .price-row {
                grid-template-columns: 1fr;
            }

            .btn,
            button[type="submit"] {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    @php
        $isFirstMembership = $isFirstMembership ?? true;
    @endphp

    <div class="container">
        <h1>Edit Membership</h1>
        <p class="subtitle">Update membership plan, trainer, schedule, and status.</p>

        <a href="{{ route('memberships.index') }}" class="btn btn-gray">Back</a>

        <div class="form-card">
            @if ($errors->any())
                <div class="error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('memberships.update', $membership->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label>Member:</label>
                <input type="text" value="{{ $membership->member->full_name ?? 'N/A' }}" readonly>
                <input type="hidden" name="member_id" value="{{ $membership->member_id }}">

                <label>Assign Trainer:</label>
                <select name="trainer_id" id="trainer_id" {{ !$isFirstMembership ? 'disabled' : '' }}>
                    <option value="">No Trainer</option>

                    @foreach($trainers as $trainer)
                        @php
                            $maxSlots = 6;

                            $bookedCount = $trainer->memberships
                                ->whereIn('status', ['pending', 'active', 'approved'])
                                ->whereNotNull('schedule_time')
                                ->where('id', '!=', $membership->id)
                                ->unique('schedule_time')
                                ->count();

                            $remaining = $maxSlots - $bookedCount;
                        @endphp

                        <option value="{{ $trainer->id }}"
                            data-booked="{{ $bookedCount }}"
                            data-remaining="{{ $remaining }}"
                            {{ old('trainer_id', $membership->trainer_id) == $trainer->id ? 'selected' : '' }}
                            {{ $bookedCount >= $maxSlots && old('trainer_id', $membership->trainer_id) != $trainer->id ? 'disabled' : '' }}>
                            {{ $trainer->name }} - {{ $trainer->specialization }}
                            @if($bookedCount >= $maxSlots)
                                (6/6 Fully Booked)
                            @else
                                ({{ $bookedCount }}/6 Booked, {{ $remaining }} available)
                            @endif
                        </option>
                    @endforeach
                </select>

                @if(!$isFirstMembership)
                    <input type="hidden" name="trainer_id" value="{{ $membership->trainer_id }}">
                @endif

                <p id="trainerNote" class="note"></p>

                @if($isFirstMembership)
                    <div id="schedulePreview" style="display:none;">
                        <label>Schedule Time:</label>

                        <input type="hidden" name="schedule_time" id="schedule_time" value="{{ old('schedule_time', $membership->schedule_time) }}">

                        <div id="scheduleSlots" class="schedule-grid"></div>
                    </div>
                @else
                    <input type="hidden" name="schedule_time" value="{{ $membership->schedule_time }}">

                    <div class="warning-note">
                        Trainer and schedule can only be changed from the first membership/payment.
                    </div>
                @endif

                <label>Plan Name:</label>
                <select name="plan_name" id="plan_name" required>
                    <option value="">Select Plan</option>
                    <option value="Monthly" {{ old('plan_name', $membership->plan_name) == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="Quarterly" {{ old('plan_name', $membership->plan_name) == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                    <option value="Annual" {{ old('plan_name', $membership->plan_name) == 'Annual' ? 'selected' : '' }}>Annual</option>
                </select>

                <div class="price-row">
                    <div>
                        <label>Price:</label>
                        <input 
                            type="number" 
                            name="price" 
                            id="price" 
                            step="0.01" 
                            value="{{ old('price', $membership->price) }}" 
                            required 
                            readonly
                        >
                    </div>

                    <div>
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="approved" {{ old('status', $membership->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="pending" {{ old('status', $membership->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="cancelled" {{ old('status', $membership->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="price-row">
                    <div>
                        <label>Start Date:</label>
                        <input 
                            type="date" 
                            name="start_date" 
                            id="start_date" 
                            value="{{ old('start_date', \Carbon\Carbon::parse($membership->start_date)->format('Y-m-d')) }}" 
                            required
                        >
                    </div>

                    <div>
                        <label>End Date:</label>
                        <input 
                            type="date" 
                            name="end_date" 
                            id="end_date" 
                            value="{{ old('end_date', \Carbon\Carbon::parse($membership->end_date)->format('Y-m-d')) }}" 
                            required 
                            readonly
                        >
                    </div>
                </div>

                <div class="actions">
                    <button type="submit">Update Membership</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const trainerSelect = document.getElementById('trainer_id');
        const trainerNote = document.getElementById('trainerNote');
        const schedulePreview = document.getElementById('schedulePreview');
        const scheduleSlots = document.getElementById('scheduleSlots');
        const scheduleTimeInput = document.getElementById('schedule_time');

        const planSelect = document.getElementById('plan_name');
        const priceInput = document.getElementById('price');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        const isFirstMembership = @json($isFirstMembership);
        const currentScheduleTime = @json(old('schedule_time', $membership->schedule_time));

        const prices = {
            Monthly: 500,
            Quarterly: 1800,
            Annual: 5500
        };

        const months = {
            Monthly: 1,
            Quarterly: 4,
            Annual: 12
        };

        const allSlots = [
            '8:00 AM - 9:00 AM',
            '9:00 AM - 10:00 AM',
            '10:00 AM - 11:00 AM',
            '1:00 PM - 2:00 PM',
            '2:00 PM - 3:00 PM',
            '4:00 PM - 5:00 PM'
        ];

        const bookedSlotsByTrainer = {
            @foreach($trainers as $trainer)
                "{{ $trainer->id }}": [
                    @foreach($trainer->memberships
                        ->whereIn('status', ['pending', 'active', 'approved'])
                        ->whereNotNull('schedule_time')
                        ->where('id', '!=', $membership->id)
                        ->unique('schedule_time') as $trainerMembership)
                        "{{ $trainerMembership->schedule_time }}",
                    @endforeach
                ],
            @endforeach
        };

        function updateTrainerSchedulePreview() {
            if (!isFirstMembership) {
                updatePriceAndEndDate();
                return;
            }

            const trainerId = trainerSelect.value;

            scheduleSlots.innerHTML = '';

            if (!trainerId) {
                trainerNote.innerText = 'No Trainer selected. Standard membership price applies.';
                trainerNote.style.color = '#e5e7eb';
                schedulePreview.style.display = 'none';
                scheduleTimeInput.value = '';
                updatePriceAndEndDate();
                return;
            }

            const selectedOption = trainerSelect.options[trainerSelect.selectedIndex];
            const booked = selectedOption.getAttribute('data-booked') || 0;
            const remaining = selectedOption.getAttribute('data-remaining') || 6;

            trainerNote.innerText = `${booked}/6 Booked, ${remaining} available. Please choose schedule time.`;
            trainerNote.style.color = '#dcfce7';

            schedulePreview.style.display = 'block';

            const bookedSlots = bookedSlotsByTrainer[trainerId] || [];

            allSlots.forEach(slot => {
                const slotButton = document.createElement('button');
                const isBooked = bookedSlots.includes(slot);
                const isSelected = scheduleTimeInput.value === slot || currentScheduleTime === slot;

                slotButton.type = 'button';
                slotButton.classList.add('slot-btn');

                if (isBooked) {
                    slotButton.innerText = `${slot} - Booked`;
                    slotButton.disabled = true;
                    slotButton.classList.add('slot-booked');
                } else {
                    slotButton.innerText = isSelected ? `${slot} - Selected` : `${slot} - Available`;

                    if (isSelected) {
                        scheduleTimeInput.value = slot;
                        slotButton.classList.add('slot-selected');
                    } else {
                        slotButton.classList.add('slot-available');
                    }

                    slotButton.addEventListener('click', function () {
                        scheduleTimeInput.value = slot;

                        document.querySelectorAll('#scheduleSlots button').forEach(button => {
                            if (!button.disabled) {
                                button.classList.remove('slot-selected');
                                button.classList.add('slot-available');
                                button.innerText = button.innerText.replace(' - Selected', ' - Available');
                            }
                        });

                        slotButton.classList.remove('slot-available');
                        slotButton.classList.add('slot-selected');
                        slotButton.innerText = `${slot} - Selected`;
                    });
                }

                scheduleSlots.appendChild(slotButton);
            });

            updatePriceAndEndDate();
        }

        function updatePriceAndEndDate() {
            const plan = planSelect.value;
            const hasTrainer = trainerSelect.value !== '';

            if (plan && prices[plan]) {
                let totalPrice = prices[plan];

                if (hasTrainer) {
                    totalPrice += 300;
                }

                priceInput.value = totalPrice;
            } else {
                priceInput.value = '';
            }

            if (plan && startDateInput.value && months[plan]) {
                const startDate = new Date(startDateInput.value);
                startDate.setMonth(startDate.getMonth() + months[plan]);

                const year = startDate.getFullYear();
                const month = String(startDate.getMonth() + 1).padStart(2, '0');
                const day = String(startDate.getDate()).padStart(2, '0');

                endDateInput.value = `${year}-${month}-${day}`;
            }
        }

        if (trainerSelect) {
            trainerSelect.addEventListener('change', function () {
                if (scheduleTimeInput) {
                    scheduleTimeInput.value = '';
                }

                updateTrainerSchedulePreview();
            });
        }

        planSelect.addEventListener('change', updatePriceAndEndDate);
        startDateInput.addEventListener('change', updatePriceAndEndDate);

        updateTrainerSchedulePreview();
        updatePriceAndEndDate();
    </script>
</body>
</html>