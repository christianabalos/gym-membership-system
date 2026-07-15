<!DOCTYPE html>
<html>
<head>
    <title>Gym Dashboard</title>
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
            max-width: 1100px;
            margin: auto;
            padding: 34px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.28);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
        }

        h1 {
            margin: 0;
            font-size: 34px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        h2 {
            color: #ffffff;
            margin: 28px 0 16px;
            font-size: 24px;
            text-shadow: 0 3px 10px rgba(0,0,0,0.35);
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            border: none;
            background: #dc2626;
            color: white;
            padding: 10px 16px;
            border-radius: 9px;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #b91c1c;
        }

        .nav-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 25px;
        }

        .nav-btn {
            display: block;
            text-align: center;
            background: rgba(15, 23, 42, 0.92);
            color: white;
            text-decoration: none;
            padding: 12px 10px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid rgba(255,255,255,0.14);
        }

        .nav-btn:hover {
            background: #2563eb;
        }

        .divider {
            border: none;
            height: 1px;
            background: rgba(255,255,255,0.25);
            margin: 24px 0;
        }

        .notification {
            background: rgba(254, 243, 199, 0.96);
            color: #92400e;
            border: 1px solid #f59e0b;
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 28px;
        }

        .notification strong {
            display: block;
            margin-bottom: 8px;
        }

        .notification ul {
            margin: 8px 0 14px;
            padding-left: 20px;
        }

        .notification-btn {
            display: inline-block;
            background: #111827;
            color: white;
            padding: 9px 13px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.90);
            color: #111827;
            border-radius: 14px;
            padding: 18px;
            border: 1px solid rgba(203, 213, 225, 0.8);
        }

        .summary-card .label {
            font-size: 13px;
            font-weight: bold;
            color: #475569;
            margin-bottom: 8px;
        }

        .summary-card .value {
            font-size: 26px;
            font-weight: 800;
            color: #111827;
        }

        .summary-card .money {
            color: #166534;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255,255,255,0.94);
            color: #111827;
            overflow: hidden;
            border-radius: 14px;
        }

        th {
            background: #0f172a;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 13px;
        }

        td {
            padding: 13px;
            border: 1px solid #d1d5db;
            font-size: 13px;
            text-align: center;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: rgba(249,250,251,0.95);
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .badge-paid {
            background: #dcfce7;
            color: #166534;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-expired {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-box {
            background: rgba(255,255,255,0.90);
            color: #475569;
            padding: 20px;
            border-radius: 14px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 25px;
        }

        @media (max-width: 900px) {
            .nav-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            h1 {
                font-size: 28px;
            }

            .nav-grid,
            .summary-grid {
                grid-template-columns: 1fr;
            }

            table {
                min-width: 760px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Gym Membership Management System</h1>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <div class="nav-grid">
            <a href="{{ route('dashboard') }}" class="nav-btn">Dashboard</a>
            <a href="{{ route('trainers.index') }}" class="nav-btn">Trainers</a>
            <a href="{{ route('members.index') }}" class="nav-btn">Members</a>
            <a href="{{ route('memberships.index') }}" class="nav-btn">Memberships</a>
            <a href="{{ route('payments.index') }}" class="nav-btn">Payments</a>
            <a href="{{ route('workouts.index') }}" class="nav-btn">Workouts</a>
            <a href="{{ route('bmi.index') }}" class="nav-btn">BMI Calculator</a>
            <a href="{{ route('reports.index') }}" class="nav-btn">Generate Reports</a>
            <a href="{{ route('admin.member-requests.index') }}" class="nav-btn">Member Requests</a>
        </div>

        <hr class="divider">

        @if(isset($pendingRequestsCount) && $pendingRequestsCount > 0)
    <div class="notification">
        <strong>Notification: You have {{ $pendingRequestsCount }} pending member requests.</strong>

        <ul>
            @foreach($pendingRequests as $request)
                <li>
                    {{ $request->member->full_name ?? $request->user->name ?? 'Member' }}
                    - {{ $request->created_at ? $request->created_at->format('M d, Y') : 'N/A' }}
                </li>
            @endforeach
        </ul>

        <a href="{{ route('admin.member-requests.index') }}" class="notification-btn">
            View Member Requests
        </a>
    </div>
@endif

        <h2>System Summary</h2>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">Total Members</div>
                <div class="value">{{ $totalMembers ?? 0 }}</div>
            </div>

            <div class="summary-card">
                <div class="label">Total Trainers</div>
                <div class="value">{{ $totalTrainers ?? 0 }}</div>
            </div>

            <div class="summary-card">
                <div class="label">Active Memberships</div>
                <div class="value">{{ $activeMemberships ?? 0 }}</div>
            </div>

            <div class="summary-card">
                <div class="label">Total Payments</div>
                <div class="value money">₱{{ number_format($totalPayments, 2) }}</div>
            </div>

            <div class="summary-card">
                <div class="label">Total Workouts</div>
                <div class="value">{{ $totalWorkouts ?? 0 }}</div>
            </div>

            <div class="summary-card">
                <div class="label">Pending Member Requests</div>
                <div class="value">{{ $pendingRequestsCount ?? 0 }}</div>
            </div>
        </div>

        <h2>Recent Payments</h2>

        @if(isset($recentPayments) && $recentPayments->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Member</th>
                        <th>Membership</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>

                    @foreach($recentPayments as $payment)
                        @php
                            $status = strtolower($payment->status ?? 'pending');
                            $statusClass = $status === 'paid' || $status === 'approved' ? 'badge-paid' : 'badge-pending';
                        @endphp

                        <tr>
                            <td>{{ $payment->member->full_name ?? 'N/A' }}</td>
                            <td>{{ $payment->membership->plan_name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($payment->amount ?? 0, 2) }}</td>
                            <td>{{ ucfirst($payment->method ?? $payment->payment_method ?? 'N/A') }}</td>
                            <td>
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>
                                {{ $payment->payment_date ?? $payment->paid_at ?? ($payment->created_at ? $payment->created_at->format('Y-m-d') : 'N/A') }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty-box">No recent payments found.</div>
        @endif

        <h2>Memberships Expiring Soon</h2>

        @if(isset($expiringMemberships) && $expiringMemberships->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Member Name</th>
                        <th>Plan</th>
                        <th>End Date</th>
                        <th>Days Left</th>
                    </tr>

                    @foreach($expiringMemberships as $membership)
                        @php
                            $endDate = $membership->end_date ? \Carbon\Carbon::parse($membership->end_date)->startOfDay() : null;
                            $today = now()->startOfDay();

                            if ($endDate && $endDate->lt($today)) {
                                $daysLeft = 'Expired';
                                $badgeClass = 'badge-expired';
                            } elseif ($endDate) {
                                $daysLeft = $today->diffInDays($endDate) . ' day(s)';
                                $badgeClass = 'badge-pending';
                            } else {
                                $daysLeft = 'N/A';
                                $badgeClass = 'badge-pending';
                            }
                        @endphp

                        <tr>
                            <td>{{ $membership->member->full_name ?? 'N/A' }}</td>
                            <td>{{ $membership->plan_name ?? 'N/A' }}</td>
                            <td>{{ $membership->end_date ?? 'N/A' }}</td>
                            <td>
                                <span class="badge {{ $badgeClass }}">
                                    {{ $daysLeft }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty-box">No expiring memberships found.</div>
        @endif
    </div>
</body>
</html>