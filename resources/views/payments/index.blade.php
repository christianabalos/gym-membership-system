<!DOCTYPE html>
<html>
<head>
    <title>Payments</title>
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
            max-width: 1200px;
            margin: auto;
            padding: 36px 28px;
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
            font-size: 36px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 10px 0 28px;
            color: #e5e7eb;
            font-size: 15px;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .btn-back {
            background: rgba(107, 114, 128, 0.9);
            color: white;
        }

        .btn-view {
            background: #2563eb;
            color: white;
        }

        .success {
            background: rgba(220, 252, 231, 0.95);
            color: #166534;
            border: 1px solid #86efac;
            padding: 13px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.18);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            overflow: hidden;
        }

        th {
            background: rgba(15, 23, 42, 0.95);
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 13px;
            white-space: nowrap;
        }

        td {
            padding: 14px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.16);
            vertical-align: middle;
            text-align: center;
            font-size: 13px;
            white-space: nowrap;
        }

        .member-name {
            font-weight: 800;
            color: #ffffff;
            text-align: left;
        }

        .membership-name {
            color: #dbeafe;
            font-weight: 700;
        }

        .amount {
            color: #86efac;
            font-weight: 900;
        }

        .method-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            text-transform: capitalize;
        }

        .method-cash {
            background: rgba(254, 243, 199, 0.95);
            color: #92400e;
        }

        .method-online {
            background: rgba(219, 234, 254, 0.95);
            color: #1d4ed8;
        }

        .method-na {
            background: rgba(255, 255, 255, 0.18);
            color: #e5e7eb;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            text-transform: capitalize;
        }

        .status-paid,
        .status-approved,
        .status-active {
            background: rgba(220, 252, 231, 0.95);
            color: #166534;
        }

        .status-pending {
            background: rgba(254, 243, 199, 0.95);
            color: #92400e;
        }

        .status-failed,
        .status-cancelled,
        .status-rejected {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }

        .empty {
            text-align: center;
            color: #e5e7eb;
            padding: 25px;
            font-weight: bold;
        }

        @media (max-width: 900px) {
            table {
                min-width: 950px;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            h1 {
                font-size: 30px;
            }

            .top-actions {
                flex-direction: column;
            }

            .btn {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Payments</h1>
        <p class="subtitle">View member payment records and payment status.</p>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="table-wrap">
            <table>
                <tr>
                    <th>Member</th>
                    <th>Membership</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>

                @forelse($payments as $payment)
                    @php
                        $method = strtolower($payment->payment_method ?? $payment->method ?? 'N/A');
                        $status = strtolower($payment->status ?? 'pending');

                        $methodClass = in_array($method, ['cash', 'online'])
                            ? 'method-' . $method
                            : 'method-na';

                        $statusClass = 'status-' . $status;
                    @endphp

                    <tr>
                        <td class="member-name">
                            {{ $payment->member->full_name ?? 'N/A' }}
                        </td>

                        <td class="membership-name">
                            {{ $payment->membership->plan_name ?? 'N/A' }}
                        </td>

                        <td class="amount">
                            ₱{{ number_format($payment->amount ?? 0, 2) }}
                        </td>

                        <td>
                            <span class="method-badge {{ $methodClass }}">
                                {{ $method !== 'n/a' ? ucfirst($method) : 'N/A' }}
                            </span>
                        </td>

                        <td>
                            <span class="status-badge {{ $statusClass }}">
                                {{ ucfirst($payment->status ?? 'Pending') }}
                            </span>
                        </td>

                        <td>
                            {{ $payment->payment_date
                                ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d')
                                : ($payment->paid_at
                                    ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d')
                                    : ($payment->created_at ? $payment->created_at->format('Y-m-d') : 'N/A'))
                            }}
                        </td>

                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-view">View</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">No payments found.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</body>
</html>