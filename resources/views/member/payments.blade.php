<!DOCTYPE html>
<html>
<head>
    <title>My Payments</title>
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
            max-width: 1050px;
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

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            overflow: hidden;
            border-radius: 14px;
        }

        th {
            background: #0f172a;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 14px;
        }

        td {
            padding: 14px;
            border: 1px solid #d1d5db;
            text-align: center;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: rgba(249, 250, 251, 0.92);
        }

        .plan {
            font-weight: bold;
            color: #2563eb;
        }

        .amount {
            font-weight: bold;
            color: #166534;
        }

        .badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .paid {
            background: #dcfce7;
            color: #166534;
        }

        .approved {
            background: #dcfce7;
            color: #166534;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .failed {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-box {
            background: rgba(255, 255, 255, 0.90);
            color: #374151;
            border-radius: 14px;
            padding: 25px;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            border: 1px solid rgba(203, 213, 225, 0.9);
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.88);
            color: #111827;
            border-radius: 14px;
            padding: 18px;
            text-align: center;
            border-left: 6px solid #2563eb;
        }

        .summary-card small {
            display: block;
            color: #6b7280;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .summary-card strong {
            font-size: 22px;
            color: #0f172a;
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

            .summary {
                grid-template-columns: 1fr;
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

        <a href="{{ route('member.dashboard') }}" class="btn-back">Back</a>

        @php
            $myPayments = $payments ?? collect();

            $totalAmount = $myPayments->sum('amount');

            $paidCount = $myPayments->filter(function ($payment) {
                return in_array(strtolower($payment->status ?? ''), ['paid', 'approved']);
            })->count();

            $pendingCount = $myPayments->filter(function ($payment) {
                return strtolower($payment->status ?? '') === 'pending';
            })->count();
        @endphp

        @if($myPayments->count() > 0)
            <div class="summary">
                <div class="summary-card">
                    <small>Total Paid/Recorded</small>
                    <strong>₱{{ number_format($totalAmount, 2) }}</strong>
                </div>

                <div class="summary-card">
                    <small>Paid Payments</small>
                    <strong>{{ $paidCount }}</strong>
                </div>

                <div class="summary-card">
                    <small>Pending Payments</small>
                    <strong>{{ $pendingCount }}</strong>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Membership Plan</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                    </tr>

                    @foreach($myPayments as $payment)
                        @php
                            $status = strtolower($payment->status ?? 'pending');

                            $statusClass = match($status) {
                                'paid' => 'paid',
                                'approved' => 'approved',
                                'failed' => 'failed',
                                default => 'pending',
                            };

                            $method = $payment->payment_method
                                ?? $payment->method
                                ?? 'N/A';

                            $date = $payment->payment_date
                                ?? $payment->paid_at
                                ?? $payment->created_at
                                ?? null;
                        @endphp

                        <tr>
                            <td class="plan">
                                {{ $payment->membership->plan_name ?? 'N/A' }}
                            </td>

                            <td class="amount">
                                ₱{{ number_format($payment->amount ?? 0, 2) }}
                            </td>

                            <td>
                                {{ ucfirst($method) }}
                            </td>

                            <td>
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <td>
                                {{ $date ? \Carbon\Carbon::parse($date)->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty-box">
                No payment records found yet.
            </div>
        @endif
    </div>
</body>
</html>