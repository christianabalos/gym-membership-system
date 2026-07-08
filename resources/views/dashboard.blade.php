<!DOCTYPE html>
<html>
<head>
    <title>Gym Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 1050px;
            margin: auto;
            background: #ffffff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
            font-size: 32px;
        }

        h2 {
            margin-top: 35px;
            margin-bottom: 16px;
            font-size: 24px;
        }

        .logout-btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .nav {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(155px, 1fr));
            gap: 10px;
            margin-bottom: 30px;
            padding-bottom: 25px;
            border-bottom: 1px solid #d1d5db;
        }

        .nav a {
            text-decoration: none;
            background: #111827;
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .notification-box {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 16px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .notification-box strong {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .notification-list {
            margin: 10px 0 0;
            padding-left: 18px;
        }

        .notification-list li {
            margin-bottom: 6px;
        }

        .notification-link {
            display: inline-block;
            margin-top: 12px;
            background: #111827;
            color: white;
            padding: 9px 14px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .summary-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            background: #f9fafb;
        }

        .summary-card h3 {
            margin: 0 0 10px;
            color: #374151;
            font-size: 15px;
        }

        .summary-card p {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #111827;
        }

        .peso {
            color: #166534 !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 25px;
        }

        th {
            background: #111827;
            color: white;
            padding: 13px;
            text-align: center;
            font-size: 14px;
        }

        td {
            padding: 13px;
            border: 1px solid #d1d5db;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: #f9fafb;
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

        .empty {
            text-align: center;
            color: #6b7280;
            background: #f9fafb;
        }

        @media (max-width: 768px) {
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

            .summary-grid {
                grid-template-columns: 1fr;
            }

            table {
                min-width: 700px;
            }

            .table-wrap {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        @php
            $pendingRequestList = \App\Models\MemberRequest::where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();

            $pendingRequestCount = \App\Models\MemberRequest::where('status', 'pending')->count();
        @endphp

        <div class="header">
            <h1>Gym Membership Management System</h1>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <div class="nav">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('trainers.index') }}">Trainers</a>
            <a href="{{ route('members.index') }}">Members</a>
            <a href="{{ route('memberships.index') }}">Memberships</a>
            <a href="{{ route('payments.index') }}">Payments</a>
            <a href="{{ route('workouts.index') }}">Workouts</a>
            <a href="{{ route('bmi.index') }}">BMI Calculator</a>
            <a href="{{ route('reports.index') }}">Generate Reports</a>
            <a href="{{ url('/admin/requests') }}">Member Requests</a>
        </div>

        @if($pendingRequestCount > 0)
            <div class="notification-box">
                <strong>Notification: You have {{ $pendingRequestCount }} pending member request{{ $pendingRequestCount > 1 ? 's' : '' }}.</strong>

                <ul class="notification-list">
                    @foreach($pendingRequestList as $request)
                        <li>
                            {{ $request->subject }} -
                            {{ $request->created_at ? $request->created_at->format('M d, Y') : 'N/A' }}
                        </li>
                    @endforeach
                </ul>

                <a href="{{ url('/admin/requests') }}" class="notification-link">
                    View Member Requests
                </a>
            </div>
        @endif

        <h2>System Summary</h2>

        <div class="summary-grid">
            <div class="summary-card">
                <h3>Total Members</h3>
                <p>{{ $totalMembers ?? 0 }}</p>
            </div>

            <div class="summary-card">
                <h3>Total Trainers</h3>
                <p>{{ $totalTrainers ?? 0 }}</p>
            </div>

            <div class="summary-card">
                <h3>Active Memberships</h3>
                <p>{{ $activeMemberships ?? 0 }}</p>
            </div>

            <div class="summary-card">
                <h3>Total Payments</h3>
                <p class="peso">₱{{ number_format($totalPayments ?? 0, 2) }}</p>
            </div>

            <div class="summary-card">
                <h3>Total Workouts</h3>
                <p>{{ $totalWorkouts ?? 0 }}</p>
            </div>

            <div class="summary-card">
                <h3>Pending Member Requests</h3>
                <p>{{ $pendingRequestCount }}</p>
            </div>
        </div>

        <h2>Recent Payments</h2>

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

                @forelse($recentPayments ?? [] as $payment)
                    @php
                        $paymentStatus = strtolower($payment->status ?? 'pending');

                        $statusClass = match($paymentStatus) {
                            'paid', 'approved' => 'badge-paid',
                            default => 'badge-pending',
                        };

                        $statusText = match($paymentStatus) {
                            'paid', 'approved' => 'Paid',
                            default => ucfirst($paymentStatus),
                        };
                    @endphp

                    <tr>
                        <td>{{ $payment->member->full_name ?? 'N/A' }}</td>
                        <td>{{ $payment->membership->plan_name ?? 'N/A' }}</td>
                        <td>₱{{ number_format($payment->amount ?? 0, 2) }}</td>
                        <td>{{ ucfirst($payment->method ?? 'N/A') }}</td>
                        <td>
                            <span class="badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>
                            {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d') : ($payment->created_at ? $payment->created_at->format('Y-m-d') : 'N/A') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">No recent payments found.</td>
                    </tr>
                @endforelse
            </table>
        </div>

        <h2>Memberships Expiring Soon</h2>

        <div class="table-wrap">
            <table>
                <tr>
                    <th>Member Name</th>
                    <th>Plan</th>
                    <th>End Date</th>
                    <th>Days Left</th>
                </tr>

                @forelse($expiringMemberships ?? [] as $membership)
                    @php
                        $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($membership->end_date), false);
                    @endphp

                    <tr>
                        <td>{{ $membership->member->full_name ?? 'N/A' }}</td>
                        <td>{{ $membership->plan_name ?? 'N/A' }}</td>
                        <td>{{ $membership->end_date ?? 'N/A' }}</td>
                        <td>{{ $daysLeft > 0 ? $daysLeft . ' days' : 'Expired' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty">No memberships expiring soon.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</body>
</html>