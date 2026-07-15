<!DOCTYPE html>
<html>
<head>
    <title>Member Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 35px 15px;
            min-height: 100vh;
            color: #111827;
            background:
                linear-gradient(rgba(15, 23, 42, 0.72), rgba(15, 23, 42, 0.72)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 760px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.18);
            padding: 35px;
            border-radius: 22px;
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.35);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 34px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 10px 0 28px;
            color: #e5e7eb;
            font-size: 15px;
        }

        .top-actions {
            margin-bottom: 25px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(107, 114, 128, 0.95);
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .error-box div {
            margin-bottom: 5px;
        }

        .field {
            margin-bottom: 18px;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 15px;
            color: #ffffff;
            text-shadow: 0 1px 5px rgba(0,0,0,0.45);
        }

        input,
        select {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid rgba(255,255,255,0.45);
            border-radius: 10px;
            font-size: 14px;
            background: rgba(255,255,255,0.90);
            color: #111827;
            outline: none;
            transition: 0.2s ease;
        }

        input:focus,
        select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.25);
        }

        input[readonly] {
            background: rgba(255,255,255,0.75);
        }

        .birth-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .trainer-note {
            margin-top: 8px;
            font-size: 14px;
            color: #e5e7eb;
            font-weight: 600;
            text-shadow: 0 1px 5px rgba(0,0,0,0.45);
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px 10px;
            margin-top: 10px;
            margin-bottom: 18px;
        }

        .schedule-box {
            padding: 14px 12px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: 0.2s ease;
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
            color: #e5e7eb;
            text-shadow: 0 1px 5px rgba(0,0,0,0.45);
        }

        .submit-btn {
            width: 100%;
            margin-top: 10px;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.35);
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }

        .login-link {
            text-align: center;
            margin-top: 18px;
            color: #e5e7eb;
            font-size: 14px;
            text-shadow: 0 1px 5px rgba(0,0,0,0.45);
        }

        .login-link a {
            color: #93c5fd;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
                border-radius: 16px;
            }

            h1 {
                font-size: 30px;
            }

            .two-column,
            .birth-grid,
            .schedule-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Member Registration</h1>
        <p class="subtitle">Create your gym membership account.</p>

        <div class="top-actions">
            <a href="{{ route('welcome') }}" class="btn-back">Back</a>
        </div>

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

            $months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $trainerSchedules = [];

            foreach ($trainers as $trainer) {
                $trainerSchedules[$trainer->id] = Membership::where('trainer_id', $trainer->id)
                    ->whereNotNull('schedule_time')
                    ->whereIn('status', ['pending', 'approved', 'active'])
                    ->pluck('schedule_time')
                    ->map(fn($time) => trim($time))
                    ->toArray();
            }
        @endphp

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <div class="field">
                <label>Full Name:</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Enter your full name" required>
            </div>

            <div class="field">
                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>
            </div>

            <div class="two-column">
                <div class="field">
                    <label>Password:</label>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>

                <div class="field">
                    <label>Confirm Password:</label>
                    <input type="password" name="password_confirmation" placeholder="Confirm password" required>
                </div>
            </div>

            <div class="two-column">
                <div class="field">
                    <label>Phone:</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number" required>
                </div>

                <div class="field">
                    <label>Gender:</label>
                    <select name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
            </div>

            <div class="field">
                <label>Address:</label>
                <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter your address" required>
            </div>

            <div class="field">
                <label>Birth Date:</label>
                <div class="birth-grid">
                    <select name="birth_month" required>
                        <option value="">Month</option>
                        @foreach($months as $month)
                            <option value="{{ $month }}" {{ old('birth_month') == $month ? 'selected' : '' }}>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>

                    <select name="birth_day" required>
                        <option value="">Day</option>
                        @for($day = 1; $day <= 31; $day++)
                            <option value="{{ $day }}" {{ old('birth_day') == $day ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endfor
                    </select>

                    <select name="birth_year" required>
                        <option value="">Year</option>
                        @for($year = date('Y'); $year >= 1950; $year--)
                            <option value="{{ $year }}" {{ old('birth_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="field">
                <label>Trainer Option:</label>
                <select name="trainer_id" id="trainer_id">
                    <option value="">No Trainer</option>

                    @foreach($trainers as $trainer)
                        <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                            {{ $trainer->name }} - {{ $trainer->specialization }}
                        </option>
                    @endforeach
                </select>

                <div class="trainer-note" id="trainerNote">
                    No Trainer selected. Standard membership price applies.
                </div>
            </div>

            <div class="field" id="scheduleSection" style="display: none;">
                <label>Schedule Time:</label>

                <div class="schedule-grid" id="scheduleGrid">
                    @foreach($slots as $slot)
                        <label class="schedule-box available" data-slot="{{ $slot }}">
                            <input type="radio" name="schedule_time" value="{{ $slot }}">
                            <span>{{ $slot }} - Available</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="two-column">
                <div class="field">
                    <label>Plan:</label>
                    <select name="plan_name" id="plan_name" required>
                        <option value="">Select Plan</option>
                        <option value="Monthly" {{ old('plan_name') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="Quarterly" {{ old('plan_name') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                        <option value="Annual" {{ old('plan_name') == 'Annual' ? 'selected' : '' }}>Annual</option>
                    </select>
                </div>

                <div class="field">
                    <label>Price:</label>
                    <input type="text" name="price" id="price" value="{{ old('price') }}" placeholder="Auto-computed price" readonly>

                    <div class="price-note">
                        Monthly ₱500 • Quarterly ₱1800 • Annual ₱5500 • With Trainer +₱300
                    </div>
                </div>
            </div>

            <div class="two-column">
                <div class="field">
                    <label>Start Date:</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                </div>

                <div class="field">
                    <label>End Date:</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" readonly required>
                </div>
            </div>

            <div class="field">
                <label>Payment Method:</label>
                <select name="payment_method" required>
                    <option value="">Select Payment Method</option>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">Register Account</button>
        </form>

        <div class="login-link">
            Already have an account?
            <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>

    <script>
        const slots = @json($slots);
        const trainerSchedules = @json($trainerSchedules);
        const oldScheduleTime = @json(old('schedule_time'));

        const planSelect = document.getElementById('plan_name');
        const trainerSelect = document.getElementById('trainer_id');
        const priceInput = document.getElementById('price');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const trainerNote = document.getElementById('trainerNote');
        const scheduleGrid = document.getElementById('scheduleGrid');
        const scheduleSection = document.getElementById('scheduleSection');

        function updatePrice() {
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

        function updateScheduleSlots() {
            const trainerId = trainerSelect.value;
            const bookedSlots = trainerId && trainerSchedules[trainerId] ? trainerSchedules[trainerId] : [];

            if (!trainerId) {
                trainerNote.textContent = 'No Trainer selected. Standard membership price applies.';
                trainerNote.style.color = '#e5e7eb';

                scheduleSection.style.display = 'none';
                scheduleGrid.innerHTML = '';

                return;
            }

            scheduleSection.style.display = 'block';

            const bookedCount = bookedSlots.length;
            const availableCount = slots.length - bookedCount;

            trainerNote.textContent = bookedCount + '/' + slots.length + ' Booked, ' + availableCount + ' available. Please choose your preferred schedule time.';
            trainerNote.style.color = '#dcfce7';

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

        trainerSelect.addEventListener('change', function () {
            updatePrice();
            updateScheduleSlots();
        });

        planSelect.addEventListener('change', updatePrice);
        startDateInput.addEventListener('change', updatePrice);

        updatePrice();
        updateScheduleSlots();
    </script>
</body>
</html>