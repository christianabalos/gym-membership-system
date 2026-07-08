<!DOCTYPE html>
<html>
<head>
    <title>Member Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 850px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            font-size: 32px;
        }

        .welcome {
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            font-size: 22px;
            margin-top: 0;
        }

        .membership-box {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            background: #ffffff;
        }

        .membership-box p {
            margin: 12px 0;
            font-size: 16px;
        }

        .status-active {
            color: green;
            font-weight: bold;
        }

        .status-pending {
            color: #b45309;
            font-weight: bold;
        }

        .status-expired {
            color: red;
            font-weight: bold;
        }

        .status-default {
            color: #111827;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        th {
            background: #f3f4f6;
            padding: 14px;
            border: 1px solid #9ca3af;
            text-align: center;
        }

        td {
            padding: 14px;
            border: 1px solid #9ca3af;
            vertical-align: middle;
        }

        .module-cell {
            width: 160px;
            font-weight: 500;
        }

        .action-cell {
            text-align: center;
            width: 160px;
        }

        .btn {
            display: inline-block;
            min-width: 75px;
            padding: 10px 18px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .btn-primary {
            background: #111827;
            color: white;
        }

        .btn-primary:hover {
            background: #374151;
        }

        .logout-wrap {
            text-align: center;
            margin-top: 20px;
        }

        .logout-btn {
            background: white;
            color: #111827;
            border: 1px solid #111827;
            padding: 10px 22px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #111827;
            color: white;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            table {
                font-size: 14px;
            }

            .btn {
                padding: 9px 12px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Member Dashboard</h1>

        <p class="welcome">
            Welcome, {{ auth()->user()->name ?? 'Member' }}!
        </p>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if(isset($membership) && $membership)
            @php
                $status = strtolower($membership->status ?? 'pending');

                $statusText = match($status) {
                    'active' => 'Approved / Active',
                    'approved' => 'Approved / Active',
                    'pending' => 'Pending',
                    'expired' => 'Expired',
                    default => ucfirst($status),
                };

                $statusClass = match($status) {
                    'active', 'approved' => 'status-active',
                    'pending' => 'status-pending',
                    'expired' => 'status-expired',
                    default => 'status-default',
                };

                $daysLeftValue = null;

                if (!empty($membership->end_date)) {
                    $daysLeftValue = \Carbon\Carbon::now()
                        ->startOfDay()
                        ->diffInDays(\Carbon\Carbon::parse($membership->end_date)->startOfDay(), false);
                }
            @endphp

            <div class="membership-box">
                <h2>
                    @if($status == 'pending')
                        Pending Membership
                    @elseif($status == 'expired')
                        Expired Membership
                    @else
                        Current Active Membership
                    @endif
                </h2>

                <p><strong>Plan:</strong> {{ $membership->plan_name ?? 'N/A' }}</p>
                <p><strong>Start Date:</strong> {{ $membership->start_date ?? 'N/A' }}</p>
                <p><strong>End Date:</strong> {{ $membership->end_date ?? 'N/A' }}</p>

                @if($status == 'active' || $status == 'approved')
                    <p>
                        <strong>Days Left:</strong>
                        {{ $daysLeftValue !== null && $daysLeftValue > 0 ? $daysLeftValue . ' days' : 'Expired' }}
                    </p>
                @endif

                <p>
                    <strong>Status:</strong>
                    <span class="{{ $statusClass }}">
                        {{ $statusText }}
                    </span>
                </p>

                @if($status == 'pending')
                    <p class="status-pending">
                        Your membership is pending. Please wait for admin approval.
                    </p>
                @elseif($status == 'active' || $status == 'approved')
                    <p class="status-active">
                        Your membership is active.
                    </p>
                @elseif($status == 'expired')
                    <p class="status-expired">
                        Your membership has expired.
                    </p>
                @endif
            </div>
        @endif

        <table>
            <tr>
                <th>Member Module</th>
                <th>Description</th>
                <th>Action</th>
            </tr>

            <tr>
                <td class="module-cell">Register Membership</td>
                <td>Apply for a gym membership plan.</td>
                <td class="action-cell">
                    <a href="{{ route('member.registerMembership') }}" class="btn btn-primary">Open</a>
                </td>
            </tr>

            <tr>
                <td class="module-cell">View Schedules</td>
                <td>View workout or training schedules.</td>
                <td class="action-cell">
                    <a href="{{ route('member.schedules') }}" class="btn btn-primary">Open</a>
                </td>
            </tr>

            <tr>
                <td class="module-cell">Track Payments</td>
                <td>Check your payment records and payment status.</td>
                <td class="action-cell">
                    <a href="{{ route('member.payments') }}" class="btn btn-primary">Open</a>
                </td>
            </tr>

            <tr>
                <td class="module-cell">BMI Calculator</td>
                <td>Calculate your Body Mass Index.</td>
                <td class="action-cell">
                    <a href="{{ url('/member/bmi') }}" class="btn btn-primary">Open</a>
                </td>
            </tr>

            <tr>
                <td class="module-cell">My Requests</td>
                <td>View the requests or concerns you sent to the admin.</td>
                <td class="action-cell">
                    <a href="{{ route('member.requests') }}" class="btn btn-primary">Open</a>
                </td>
            </tr>

            <tr>
                <td class="module-cell">Send Request</td>
                <td>Send a membership, payment, or schedule concern to the admin.</td>
                <td class="action-cell">
                    <a href="{{ route('member.requests.create') }}" class="btn btn-primary">Open</a>
                </td>
            </tr>
        </table>

        <div class="logout-wrap">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>