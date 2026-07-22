<!DOCTYPE html>
<html>
<head>
    <title>Add Membership</title>
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
            font-size: 34px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 8px 0 26px;
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
            padding: 22px;
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
            margin-bottom: 15px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
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

        .note {
            margin-top: 6px;
            color: #e5e7eb;
            font-size: 12px;
            line-height: 1.4;
            font-weight: 600;
        }

        .renewal-warning {
            margin-top: 8px;
            color: #fecaca;
            font-size: 12px;
            font-weight: bold;
            line-height: 1.5;
        }

        .end-date-note {
            margin-top: 14px;
            padding: 12px 14px;
            border-radius: 10px;
            background: rgba(219, 234, 254, 0.95);
            color: #1e3a8a;
            border: 1px solid #93c5fd;
            font-size: 13px;
            font-weight: bold;
            line-height: 1.5;
        }

        .end-date-note strong {
            color: #1d4ed8;
        }

        .submit-btn {
            width: 100%;
            margin-top: 16px;
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

        @media (max-width: 768px) {
            body {
                padding: 18px 12px;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 28px;
            }

            .row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add Membership</h1>
        <p class="subtitle">Create a new membership record for a member.</p>

        <div class="top-actions">
            <a href="{{ route('memberships.index') }}" class="btn-back">Back</a>
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

            <form action="{{ route('memberships.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="member_id">Member:</label>
                    <select id="member_id" name="member_id" required>
                        <option value="">Select Member</option>

                        @foreach(($members ?? []) as $member)
                            @php
                                $latestMembership = $member->memberships->sortByDesc('end_date')->first();
                                $latestEndDate = $latestMembership && $latestMembership->end_date
                                    ? \Carbon\Carbon::parse($latestMembership->end_date)->format('Y-m-d')
                                    : '';
                            @endphp

                            <option
                                value="{{ $member->id }}"
                                data-end-date="{{ $latestEndDate }}"
                                {{ old('member_id') == $member->id ? 'selected' : '' }}
                            >
                                {{ $member->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="trainer_id">Assign Trainer:</label>
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
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="plan_name">Plan Name:</label>
                        <select id="plan_name" name="plan_name" required>
                            <option value="">Select Plan</option>
                            <option value="Monthly" {{ old('plan_name') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="Quarterly" {{ old('plan_name') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                            <option value="Annual" {{ old('plan_name') == 'Annual' ? 'selected' : '' }}>Annual</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" id="price" name="price" value="{{ old('price') }}" readonly>
                        <div class="note">
                            Monthly ₱500, Quarterly ₱1800, Annual ₱5500. With trainer add ₱300.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" readonly>
                    </div>
                </div>

                <div class="renewal-warning" id="renewalWarning">
                    Select a member to see the current membership end date.
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="payment_method">Payment Method:</label>
                        <select id="payment_method" name="payment_method" required>
                            <option value="Cash" {{ old('payment_method', 'Cash') == 'Cash' ? 'selected' : '' }}>Cash</option>
                            <option value="Online" {{ old('payment_method') == 'Online' ? 'selected' : '' }}>Online</option>
                        </select>
                    </div>
                </div>

                <div class="end-date-note" id="endDateNote">
                    Select a plan and start date to see when the membership will end.
                </div>

                <button type="submit" class="submit-btn">Save Membership</button>
            </form>
        </div>
    </div>

    <script>
        const memberSelect = document.getElementById('member_id');
        const trainerSelect = document.getElementById('trainer_id');
        const trainerNote = document.getElementById('trainerNote');
        const planSelect = document.getElementById('plan_name');
        const priceInput = document.getElementById('price');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const renewalWarning = document.getElementById('renewalWarning');
        const endDateNote = document.getElementById('endDateNote');

        const basePrices = {
            Monthly: 500,
            Quarterly: 1800,
            Annual: 5500
        };

        function formatReadableDate(date) {
            return date.toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
        }

        function updateTrainerNote() {
            if (trainerSelect.value) {
                trainerNote.textContent = 'Trainer selected. Additional ₱300 trainer fee applies.';
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

        function updateRenewalWarning() {
            const selectedOption = memberSelect.options[memberSelect.selectedIndex];

            if (!memberSelect.value || !selectedOption) {
                renewalWarning.textContent = 'Select a member to see the current membership end date.';
                startDateInput.removeAttribute('min');
                return;
            }

            const currentEndDate = selectedOption.getAttribute('data-end-date');

            if (!currentEndDate) {
                renewalWarning.textContent = 'This member has no previous membership record yet.';
                startDateInput.removeAttribute('min');
                return;
            }

            renewalWarning.textContent = `Your current membership ends on ${currentEndDate}. Please choose ${currentEndDate} or later as your start date.`;
            startDateInput.min = currentEndDate;

            if (!startDateInput.value || startDateInput.value < currentEndDate) {
                startDateInput.value = currentEndDate;
            }
        }

        function updateEndDate() {
            const plan = planSelect.value;
            const startDate = startDateInput.value;

            if (!plan || !startDate) {
                endDateInput.value = '';
                endDateNote.innerHTML = 'Select a plan and start date to see when the membership will end.';
                return;
            }

            const date = new Date(startDate + 'T00:00:00');
            const start = new Date(startDate + 'T00:00:00');

            let durationText = '';

            if (plan === 'Monthly') {
                date.setMonth(date.getMonth() + 1);
                durationText = '1 month';
            } else if (plan === 'Quarterly') {
                date.setMonth(date.getMonth() + 4);
                durationText = '4 months';
            } else if (plan === 'Annual') {
                date.setFullYear(date.getFullYear() + 1);
                durationText = '1 year';
            }

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            endDateInput.value = `${year}-${month}-${day}`;

            endDateNote.innerHTML = `
                Membership duration: <strong>${durationText}</strong><br>
                Start Date: <strong>${formatReadableDate(start)}</strong><br>
                End Date: <strong>${formatReadableDate(date)}</strong>
            `;
        }

        memberSelect.addEventListener('change', function () {
            updateRenewalWarning();
            updateEndDate();
        });

        trainerSelect.addEventListener('change', function () {
            updateTrainerNote();
            updatePrice();
        });

        planSelect.addEventListener('change', function () {
            updatePrice();
            updateEndDate();
        });

        startDateInput.addEventListener('change', function () {
            updateEndDate();
        });

        updateTrainerNote();
        updatePrice();
        updateRenewalWarning();
        updateEndDate();
    </script>
</body>
</html>