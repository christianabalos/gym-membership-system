<!DOCTYPE html>
<html>
<head>
    <title>My Payments</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 950px;
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
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-back {
            background: #6b7280;
            color: white;
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
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .amount {
            font-weight: bold;
            color: #111827;
        }

        .plan {
            font-weight: bold;
            color: #1d4ed8;
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

        .badge-failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .method {
            text-transform: capitalize;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 30px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #f9fafb;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            table {
                min-width: 750px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Payments</h1>
        <p class="subtitle">View your membership payment records and payment status.</p>

        <div class="top-actions">
            <a href="{{ route('member.dashboard') }}" class="btn btn-back">Back</a>
        </div>

        @if($payments->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Membership Plan</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                    </tr>

                    @foreach($payments as $payment)
                        <tr>
                            <td class="plan">
                                {{ $payment->membership->plan_name ?? 'N/A' }}
                            </td>

                            <td class="amount">
                                ₱{{ number_format($payment->amount, 2) }}
                            </td>

                            <td class="method">
                                {{ $payment->payment_method ?? 'N/A' }}
                            </td>

                            <td>
                                @php
                                    $statusClass = match($payment->status) {
                                        'paid' => 'badge-paid',
                                        'failed' => 'badge-failed',
                                        default => 'badge-pending',
                                    };
                                @endphp

                                <span class="badge {{ $statusClass }}">
                                    {{ $payment->status }}
                                </span>
                            </td>

                            <td>
                                {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No payment records found yet.
            </div>
        @endif
    </div>
</body>
</html>