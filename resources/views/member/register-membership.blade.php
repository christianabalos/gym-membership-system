<!DOCTYPE html>
<html>
<head>
    <title>Register Membership</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 760px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            font-size: 34px;
        }

        .btn-back {
            display: inline-block;
            background: #6b7280;
            color: white;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 14px;
            margin-bottom: 7px;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #9ca3af;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[readonly] {
            background: #ffffff;
        }

        .trainer-note {
            margin-top: 8px;
            color: #166534;
            font-size: 14px;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 9px;
            margin-top: 8px;
            margin-bottom: 14px;
        }

        .schedule-box {
            padding: 11px;
            border-radius: 7px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .schedule-box input {
            display: none;
        }

        .schedule-box.available {
            background: #dcfce7;
            color: #166534;
        }

        .schedule-box.booked {
            background: #fee2e2;
            color: #991b1b;
            cursor: not-allowed;
        }

        .schedule-box.selected {
            outline: 3px solid #2563eb;
            background: #dbeafe;
            color: #1d4ed8;
        }

        .price-note {
            margin-top: 8px;
            font-size: 14px;
            color: #111827;
        }

        .warning {
            color: red;
            margin-top: 8px;
            font-size: 14px;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .submit-btn {
            width: 100%;
            margin-top: 25px;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #111827;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        .submit-btn:hover {
            background: #374151;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            .schedule-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Register Membership</h1>

        <a href="{{ route('member.dashboard') }}" class="btn-back">Back</a>

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @php
            use App\Models\Membership;

            $slots = [
                '8:00 AM - 9:00 AM',
                '9:00 AM - 10:00 AM',
                '10:00 AM - 11:00 AM',
                '1:00 PM - 2:00 PM',
                '2:00 PM - 3:00 PM',
                '4:00 PM - 5:00 PM',
            ];

            $selectedTrainerId = old('trainer_id', $member->trainer_id ?? '');

            $bookedSlotsByTrainer = [];

            foreach ($trainers as $trainer) {
                $bookedSlotsByTrainer[$trainer->id] = Membership::where('trainer_id', $trainer->id)
                    ->whereNotNull('schedule_time')
                    ->whereIn('status', ['pending', 'approved', 'active'])
                    ->pluck('schedule_time')
                    ->map(fn($time) => trim($time))
                    ->toArray();
            }
        @endphp

        <form action="{{ route('member.storeMembership') }}" method="POST">
            @csrf

            <label>Member:</label>
            <input type="text" value="{{ $member->full_name ?? auth()->user()->name }}" readonly>

            <label>Trainer:</label>
            <select name="trainer_id" id="trainer_id">
                <option value="">No Trainer</option>

                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}" {{ $selectedTrainerId == $trainer->id ? 'selected' : '' }}>
                        {{ $trainer->name }} - {{ $trainer->specialization }}
                    </option>
                @endforeach
            </select>

            <p class="trainer-note" id="trainerNote">
                No Trainer selected. Standard membership price applies.
            </p>

            <div class="field" id="scheduleSection" style="display: none;">
                <label>Schedule Time:</label>

                <div class="schedule-grid" id="scheduleGrid"></div>
            </div>

            <label>Plan:</label>
            <select name="plan_name" id="plan_name" required>
                <option value="">Select Plan</option>
                <option value="Monthly" {{ old('plan_name') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="Quarterly" {{ old('plan_name') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                <option value="Annual" {{ old('plan_name') == 'Annual' ? 'selected' : '' }}>Annual</option>
            </select>

            <label>Price:</label>
            <input type="text" name="price" id="price" value="{{ old('price') }}" readonly>

            <p class="price-note">
                No Trainer: Monthly ₱500, Quarterly ₱1800, Annual ₱5500. With Trainer: add ₱300.
            </p>

            <label>Start Date:</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>

            @if(isset($nextStartDate) && $nextStartDate)
                <p class="warning">
                    Your current membership ends on {{ $nextStartDate }}. Please choose {{ $nextStartDate }} or later as your start date.
                </p>
            @endif

            <label>End Date:</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" readonly required>

            <label>Payment Method:</label>
            <select name="payment_method" required>
                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
            </select>

            <button type="submit" class="submit-btn">Save Membership</button>
        </form>
    </div>

    <script>
        const slots = @json($slots);
        const bookedSlotsByTrainer = @json($bookedSlotsByTrainer);
        const oldScheduleTime = @json(old('schedule_time'));

        const planSelect = document.getElementById('plan_name');
        const trainerSelect = document.getElementById('trainer_id');
        const priceInput = document.getElementById('price');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const trainerNote = document.getElementById('trainerNote');
        const scheduleSection = document.getElementById('scheduleSection');
        const scheduleGrid = document.getElementById('scheduleGrid');

        function refreshScheduleSlots() {
            const trainerId = trainerSelect.value;

            if (!trainerId) {
                trainerNote.innerText = 'No Trainer selected. Standard membership price applies.';
                trainerNote.style.color = '#6b7280';

                scheduleSection.style.display = 'none';
                scheduleGrid.innerHTML = '';

                return;
            }

            scheduleSection.style.display = 'block';

            const bookedSlots = bookedSlotsByTrainer[trainerId] || [];
            const bookedCount = bookedSlots.length;
            const availableCount = slots.length - bookedCount;

            trainerNote.innerText = `${bookedCount}/${slots.length} Booked, ${availableCount} available. Please choose your preferred schedule time.`;
            trainerNote.style.color = '#166534';

            scheduleGrid.innerHTML = '';

            slots.forEach(slot => {
                const isBooked = bookedSlots.includes(slot);

                const label = document.createElement('label');
                label.className = 'schedule-box ' + (isBooked ? 'booked' : 'available');
                label.dataset.slot = slot;

                const input = document.createElement('input');
                input.type = 'radio';
                input.name = 'schedule_time';
                input.value = slot;

                if (isBooked) {
                    input.disabled = true;
                }

                if (oldScheduleTime === slot && !isBooked) {
                    input.checked = true;
                    label.classList.add('selected');
                }

                const span = document.createElement('span');
                span.innerText = slot + ' - ' + (isBooked ? 'Booked' : 'Available');

                label.appendChild(input);
                label.appendChild(span);
                scheduleGrid.appendChild(label);
            });

            document.querySelectorAll('.schedule-box input').forEach(input => {
                input.addEventListener('change', function () {
                    document.querySelectorAll('.schedule-box').forEach(box => {
                        box.classList.remove('selected');
                    });

                    this.closest('.schedule-box').classList.add('selected');
                });
            });
        }

        function updatePriceAndEndDate() {
            const plan = planSelect.value;
            const hasTrainer = trainerSelect.value !== '';

            let price = 0;
            let months = 0;

            if (plan === 'Monthly') {
                price = 500;
                months = 1;
            }

            if (plan === 'Quarterly') {
                price = 1800;
                months = 4;
            }

            if (plan === 'Annual') {
                price = 5500;
                months = 12;
            }

            if (hasTrainer && price > 0) {
                price += 300;
            }

            priceInput.value = price > 0 ? price : '';

            if (startDateInput.value && months > 0) {
                const endDate = new Date(startDateInput.value);
                endDate.setMonth(endDate.getMonth() + months);

                const year = endDate.getFullYear();
                const month = String(endDate.getMonth() + 1).padStart(2, '0');
                const day = String(endDate.getDate()).padStart(2, '0');

                endDateInput.value = `${year}-${month}-${day}`;
            } else {
                endDateInput.value = '';
            }
        }

        trainerSelect.addEventListener('change', function () {
            refreshScheduleSlots();
            updatePriceAndEndDate();
        });

        planSelect.addEventListener('change', updatePriceAndEndDate);
        startDateInput.addEventListener('change', updatePriceAndEndDate);

        refreshScheduleSlots();
        updatePriceAndEndDate();
    </script>
</body>
</html>