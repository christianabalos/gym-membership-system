<!DOCTYPE html>
<html>
<head>
    <title>Register Membership</title>
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
            color: #ffffff;
            background:
                linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.78)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 820px;
            margin: auto;
            padding: 36px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.30);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.38);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
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
            margin-top: 10px;
            margin-bottom: 30px;
            color: #dbeafe;
            font-size: 15px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(107, 114, 128, 0.95);
            color: white;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 14px;
            margin-bottom: 7px;
            color: #ffffff;
        }

        input,
        select {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid rgba(203, 213, 225, 0.9);
            border-radius: 10px;
            font-size: 14px;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            outline: none;
        }

        input:focus,
        select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.25);
        }

        input[readonly] {
            background: rgba(255, 255, 255, 0.75);
        }

        .trainer-note {
            margin-top: 8px;
            color: #dbeafe;
            font-size: 14px;
            font-weight: bold;
        }

        .price-note {
            margin-top: 8px;
            font-size: 13px;
            color: #dbeafe;
            font-weight: bold;
        }

        .warning {
            color: #fecaca;
            margin-top: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-weight: bold;
        }

        .submit-btn {
            width: 100%;
            margin-top: 25px;
            padding: 14px;
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

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 24px;
            }

            h1 {
                font-size: 30px;
            }

            .two-column {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Register Membership</h1>
        <p class="subtitle">Choose your plan, trainer, and payment method.</p>

        <a href="{{ route('member.dashboard') }}" class="btn-back">Back</a>

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @php
            $selectedTrainerId = old('trainer_id', $member->trainer_id ?? '');
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

            <div class="two-column">
                <div>
                    <label>Start Date:</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                </div>

                <div>
                    <label>End Date:</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" readonly required>
                </div>
            </div>

            @if(isset($nextStartDate) && $nextStartDate)
                <p class="warning">
                    Your current membership ends on {{ $nextStartDate }}. Please choose {{ $nextStartDate }} or later as your start date.
                </p>
            @endif

            <label>Payment Method:</label>
            <select name="payment_method" required>
                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
            </select>

            <button type="submit" class="submit-btn">Save Membership</button>
        </form>
    </div>

    <script>
        const planSelect = document.getElementById('plan_name');
        const trainerSelect = document.getElementById('trainer_id');
        const priceInput = document.getElementById('price');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const trainerNote = document.getElementById('trainerNote');

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

        function updateTrainerNote() {
            if (trainerSelect.value) {
                trainerNote.innerText = 'Trainer selected. Additional ₱300 trainer fee applies.';
                trainerNote.style.color = '#dcfce7';
            } else {
                trainerNote.innerText = 'No Trainer selected. Standard membership price applies.';
                trainerNote.style.color = '#dbeafe';
            }
        }

        trainerSelect.addEventListener('change', function () {
            updateTrainerNote();
            updatePriceAndEndDate();
        });

        planSelect.addEventListener('change', updatePriceAndEndDate);
        startDateInput.addEventListener('change', updatePriceAndEndDate);

        updateTrainerNote();
        updatePriceAndEndDate();
    </script>
</body>
</html>