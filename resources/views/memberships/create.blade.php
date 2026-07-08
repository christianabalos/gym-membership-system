<!DOCTYPE html>
<html>
<head>
    <title>Add Membership</title>

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
            font-weight: bold;
        }

        .subtitle {
            text-align: center;
            margin-top: 6px;
            margin-bottom: 25px;
            color: #6b7280;
            font-size: 14px;
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
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
            box-sizing: border-box;
        }

        input[readonly] {
            background: #f9fafb;
        }

        .trainer-note {
            margin-top: 8px;
            color: #166534;
            font-size: 14px;
            font-weight: 600;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px 10px;
            margin-top: 10px;
            margin-bottom: 16px;
        }

        .schedule-box {
            padding: 13px 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            border: 2px solid transparent;
            user-select: none;
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
            border-color: #2563eb;
            background: #dbeafe;
            color: #1d4ed8;
        }

        .price-note {
            margin-top: 8px;
            font-size: 13px;
            color: #374151;
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
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        .submit-btn:hover {
            background: #1d4ed8;
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
        <h1>Add Membership</h1>
        <p class="subtitle">Create a new membership record for a member.</p>

        <a href="{{ route('memberships.index') }}" class="btn-back">Back</a>

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

            $selectedTrainerId = old('trainer_id', '');

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

        <form action="{{ route('memberships.store') }}" method="POST" id="membershipForm">
            @csrf

            <label>Member:</label>
            <select name="member_id" required>
                <option value="">Select Member</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->full_name }}
                    </option>
                @endforeach
            </select>

            <label>Assign Trainer:</label>
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

            <label>Plan Name:</label>
            <select name="plan_name" id="plan_name" required>
                <option value="">Select Plan</option>
                <option value="Monthly" {{ old('plan_name') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                <option value="Quarterly" {{ old('plan_name') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                <option value="Annual" {{ old('plan_name') == 'Annual' ? 'selected' : '' }}>Annual</option>
            </select>

            <label>Price:</label>
            <input type="text" name="price" id="price" value="{{ old('price') }}" readonly>

            <p class="price-note">
                Monthly ₱500, Quarterly ₱1800, Annual ₱5500. With trainer: add ₱300.
            </p>

            <label>Start Date:</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>

            <label>End Date:</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" readonly required>

            <label>Status:</label>
            <select name="status" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
            </select>

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

        const trainerSelect = document.getElementById('trainer_id');
        const trainerNote = document.getElementById('trainerNote');
        const scheduleSection = document.getElementById('scheduleSection');
        const scheduleGrid = document.getElementById('scheduleGrid');

        const planSelect = document.getElementById('plan_name');
        const priceInput = document.getElementById('price');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const membershipForm = document.getElementById('membershipForm');

        function updateScheduleSlots() {
            const trainerId = trainerSelect.value;
            const bookedSlots = trainerId && bookedSlotsByTrainer[trainerId] ? bookedSlotsByTrainer[trainerId] : [];

            if (!trainerId) {
                trainerNote.textContent = 'No Trainer selected. Standard membership price applies.';
                trainerNote.style.color = '#6b7280';

                scheduleSection.style.display = 'none';
                scheduleGrid.innerHTML = '';

                return;
            }

            scheduleSection.style.display = 'block';

            const bookedCount = bookedSlots.length;
            const availableCount = slots.length - bookedCount;

            trainerNote.textContent = bookedCount + '/' + slots.length + ' Booked, ' + availableCount + ' available. Please choose your preferred schedule time.';
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
                span.textContent = slot + ' - ' + (isBooked ? 'Booked' : 'Available');

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

        membershipForm.addEventListener('submit', function(e) {
            if (trainerSelect.value !== '') {
                const selectedSchedule = document.querySelector('input[name="schedule_time"]:checked');

                if (!selectedSchedule) {
                    e.preventDefault();
                    alert('Please select a schedule time for the trainer.');
                }
            }
        });

        trainerSelect.addEventListener('change', function () {
            updateScheduleSlots();
            updatePriceAndEndDate();
        });

        planSelect.addEventListener('change', updatePriceAndEndDate);
        startDateInput.addEventListener('change', updatePriceAndEndDate);

        updateScheduleSlots();
        updatePriceAndEndDate();
    </script>
</body>
</html>