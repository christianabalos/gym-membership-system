<!DOCTYPE html>
<html>
<head>
    <title>Edit Membership</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button,
        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            background: #111827;
            color: white;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-gray {
            background: #6b7280;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .note {
            font-size: 14px;
            margin-top: 6px;
        }

        .actions {
            text-align: center;
            margin-top: 25px;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 8px;
        }

        .slot-btn {
            padding: 9px;
            border-radius: 6px;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            border: none;
        }

        .slot-booked {
            background: #fee2e2;
            color: #991b1b;
            cursor: not-allowed;
        }

        .slot-available {
            background: #dcfce7;
            color: #166534;
            cursor: pointer;
        }

        .slot-selected {
            background: #bbf7d0;
            color: #14532d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Membership</h1>

        <a href="{{ route('memberships.index') }}" class="btn btn-gray">Back</a>

        <br><br>

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
            <select name="trainer_id" id="trainer_id">
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

            <p id="trainerNote" class="note"></p>

            <div id="schedulePreview" style="display:none;">
                <label>Schedule Time:</label>

                <input type="hidden" name="schedule_time" id="schedule_time" value="{{ old('schedule_time', $membership->schedule_time) }}">

                <div id="scheduleSlots" class="schedule-grid"></div>
            </div>

            <label>Plan Name:</label>
            <select name="plan_name" id="plan_name" required>
                <option value="">Select Plan</option>
                <option value="Monthly" {{ old('plan_name', $membership->plan_name) == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="Quarterly" {{ old('plan_name', $membership->plan_name) == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                <option value="Annual" {{ old('plan_name', $membership->plan_name) == 'Annual' ? 'selected' : '' }}>Annual</option>
            </select>

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

            <label>Start Date:</label>
            <input 
                type="date" 
                name="start_date" 
                id="start_date" 
                value="{{ old('start_date', \Carbon\Carbon::parse($membership->start_date)->format('Y-m-d')) }}" 
                required
            >

            <label>End Date:</label>
            <input 
                type="date" 
                name="end_date" 
                id="end_date" 
                value="{{ old('end_date', \Carbon\Carbon::parse($membership->end_date)->format('Y-m-d')) }}" 
                required 
                readonly
            >

            <label>Status:</label>
            <select name="status" required>
                <option value="active" {{ old('status', $membership->status) == 'active' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ old('status', $membership->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ old('status', $membership->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <div class="actions">
                <button type="submit">Update Membership</button>
            </div>
        </form>
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
            const trainerId = trainerSelect.value;

            scheduleSlots.innerHTML = '';

            if (!trainerId) {
                trainerNote.innerText = 'No Trainer selected. Standard membership price applies.';
                trainerNote.style.color = '#6b7280';
                schedulePreview.style.display = 'none';
                scheduleTimeInput.value = '';
                updatePriceAndEndDate();
                return;
            }

            const selectedOption = trainerSelect.options[trainerSelect.selectedIndex];
            const booked = selectedOption.getAttribute('data-booked') || 0;
            const remaining = selectedOption.getAttribute('data-remaining') || 6;

            trainerNote.innerText = `${booked}/6 Booked, ${remaining} available. Please choose schedule time.`;
            trainerNote.style.color = '#166534';

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
                                button.innerText = button.innerText
                                    .replace(' - Selected', ' - Available');
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

        trainerSelect.addEventListener('change', function () {
            scheduleTimeInput.value = '';
            updateTrainerSchedulePreview();
        });

        planSelect.addEventListener('change', updatePriceAndEndDate);
        startDateInput.addEventListener('change', updatePriceAndEndDate);

        updateTrainerSchedulePreview();
        updatePriceAndEndDate();
    </script>
</body>
</html>