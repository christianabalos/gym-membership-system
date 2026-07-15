<!DOCTYPE html>
<html>
<head>
    <title>Payments</title>

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

        h1 {
            text-align: center;
            margin-top: 0;
            font-size: 32px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 30px;
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
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .btn-view {
            background: #2563eb;
            color: white;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-weight: bold;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #111827;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 14px;
        }

        td {
            padding: 14px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
            font-size: 14px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .member-name {
            font-weight: bold;
            color: #111827;
        }

        .amount {
            font-weight: bold;
            color: #166534;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .badge-paid,
        .badge-approved {
            background: #dcfce7;
            color: #166534;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-rejected,
        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 30px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #f9fafb;
            font-size: 15px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            table {
                min-width: 800px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payments</h1>
        <p class="subtitle">View member payment records and payment status.</p>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Dashboard</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($payments->count() > 0)
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

                    @foreach($payments as $payment)
                        <tr>
                            <td class="member-name">
                                {{ $payment->member->full_name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $payment->membership->plan_name ?? 'N/A' }}
                            </td>

                            <td class="amount">
                                ₱{{ number_format($payment->amount, 2) }}
                            </td>

                            <td>
                                @if($payment->method == 'online')
                                    Online Payment
                                @else
                                    {{ ucfirst($payment->method ?? 'N/A') }}
                                @endif
                            </td>

                            <td>
                                @php
                                    $status = strtolower($payment->status ?? 'pending');

                                    $statusClass = match($status) {
                                        'paid' => 'badge-paid',
                                        'approved' => 'badge-approved',
                                        'rejected' => 'badge-rejected',
                                        'cancelled' => 'badge-cancelled',
                                        default => 'badge-pending',
                                    };

                                    $statusText = match($status) {
                                        'approved' => 'Paid',
                                        default => ucfirst($status),
                                    };
                                @endphp

                                <span class="badge {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            <td>
                                {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d') : ($payment->created_at ? $payment->created_at->format('Y-m-d') : 'N/A') }}
                            </td>

                            <td>
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-view">View</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No payments found.
            </div>
        @endif
    </div>
</body>
</html>
