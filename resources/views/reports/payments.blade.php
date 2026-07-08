<!DOCTYPE html>
<html>
<head>
    <title>Payments Report</title>

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

        .btn-print {
            background: #2563eb;
            color: white;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 25px;
        }

        .summary-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px;
            background: #f9fafb;
            text-align: center;
        }

        .summary-card h3 {
            margin: 0 0 8px 0;
            font-size: 15px;
            color: #6b7280;
        }

        .summary-card p {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            color: #111827;
        }

        .summary-card .paid {
            color: #166534;
        }

        .summary-card .pending {
            color: #92400e;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            table-layout: fixed;
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
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .member-name {
            font-weight: bold;
            color: #111827;
        }

        .amount {
            color: #166534;
            font-weight: bold;
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

        @media print {
            @page {
                size: landscape;
                margin: 12mm;
            }

            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .container {
                max-width: 100%;
                width: 100%;
                box-shadow: none;
                border-radius: 0;
                padding: 0;
            }

            .top-actions {
                display: none;
            }

            .subtitle {
                margin-bottom: 18px;
            }

            .summary-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                margin-bottom: 15px;
            }

            .summary-card {
                padding: 10px;
            }

            .summary-card h3 {
                font-size: 11px;
            }

            .summary-card p {
                font-size: 15px;
            }

            .table-wrap {
                overflow: visible;
            }

            table {
                width: 100%;
                table-layout: fixed;
                border-radius: 0;
            }

            th {
                padding: 8px;
                font-size: 11px;
            }

            td {
                padding: 8px;
                font-size: 11px;
            }

            h1 {
                font-size: 24px;
                margin-bottom: 8px;
            }

            .badge {
                padding: 4px 8px;
                font-size: 10px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            table {
                min-width: 850px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payments Report</h1>
        <p class="subtitle">Summary of payment records, methods, amounts, and payment status.</p>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Report</button>
        </div>

        @php
            $totalPayments = $payments->sum('amount');

            $paidPayments = $payments->filter(function ($payment) {
                return in_array(strtolower($payment->status ?? ''), ['paid', 'approved']);
            })->sum('amount');

            $pendingPayments = $payments->filter(function ($payment) {
                return strtolower($payment->status ?? '') == 'pending';
            })->sum('amount');
        @endphp

        <div class="summary-grid">
            <div class="summary-card">
                <h3>Total Payments</h3>
                <p>₱{{ number_format($totalPayments, 2) }}</p>
            </div>

            <div class="summary-card">
                <h3>Paid Payments</h3>
                <p class="paid">₱{{ number_format($paidPayments, 2) }}</p>
            </div>

            <div class="summary-card">
                <h3>Pending Payments</h3>
                <p class="pending">₱{{ number_format($pendingPayments, 2) }}</p>
            </div>
        </div>

        @if($payments->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Member</th>
                        <th>Membership Plan</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
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
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No payment records found.
            </div>
        @endif
    </div>
</body>
</html>