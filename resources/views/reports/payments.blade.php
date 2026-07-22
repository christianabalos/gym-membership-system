<!DOCTYPE html>
<html>
<head>
    <title>Payments Report</title>
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
            max-width: 1150px;
            margin: auto;
            padding: 34px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
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
            color: #dbeafe;
            font-size: 15px;
            font-weight: 600;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 22px;
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
            text-align: center;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .btn-back {
            background: rgba(107, 114, 128, 0.92);
            color: #ffffff;
        }

        .btn-print {
            background: #2563eb;
            color: #ffffff;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 22px;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            border-radius: 14px;
            padding: 18px;
            border: 1px solid rgba(203, 213, 225, 0.9);
            text-align: center;
        }

        .summary-card .label {
            font-size: 13px;
            color: #475569;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .summary-card .value {
            font-size: 22px;
            font-weight: 900;
        }

        .value-total {
            color: #0f172a;
        }

        .value-paid {
            color: #166534;
        }

        .value-pending {
            color: #92400e;
        }

        .value-cancelled {
            color: #991b1b;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            overflow: hidden;
        }

        th {
            background: rgba(15, 23, 42, 0.95);
            color: #ffffff;
            padding: 14px 12px;
            text-align: center;
            font-size: 13px;
            white-space: nowrap;
        }

        td {
            padding: 14px 12px;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.18);
            background: rgba(255, 255, 255, 0.08);
            vertical-align: middle;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }

        .member-cell {
            font-weight: 900;
            text-align: left;
            white-space: nowrap;
        }

        .price-cell {
            color: #86efac;
            font-weight: 900;
            white-space: nowrap;
        }

        .method-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(254, 243, 199, 0.95);
            color: #92400e;
            font-weight: 900;
            text-transform: capitalize;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            text-transform: capitalize;
        }

        .status-paid,
        .status-approved {
            background: rgba(220, 252, 231, 0.95);
            color: #166534;
        }

        .status-pending {
            background: rgba(254, 243, 199, 0.95);
            color: #92400e;
        }

        .status-cancelled,
        .status-canceled {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
        }

        .empty {
            text-align: center;
            padding: 26px;
            color: #e5e7eb;
            font-weight: bold;
        }

        .print-header {
            display: none;
        }

        @media (max-width: 900px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

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

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .top-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0;
                margin: 0;
                font-family: Arial, sans-serif;
            }

            .container {
                max-width: none;
                width: 100%;
                margin: 0;
                padding: 20px;
                border: none;
                box-shadow: none;
                border-radius: 0;
                background: #ffffff !important;
                color: #000000 !important;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }

            .top-actions {
                display: none !important;
            }

            .print-header {
                display: block;
                text-align: center;
                margin-bottom: 18px;
                color: #000000;
            }

            .print-header h2 {
                margin: 0 0 5px;
                font-size: 24px;
            }

            .print-header p {
                margin: 0;
                font-size: 13px;
            }

            h1 {
                color: #000000 !important;
                text-shadow: none;
                font-size: 26px;
            }

            .subtitle {
                color: #374151 !important;
            }

            .summary-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
                margin-bottom: 14px;
            }

            .summary-card {
                background: #ffffff !important;
                color: #000000 !important;
                border: 1px solid #111827;
                padding: 10px;
            }

            .summary-card .label,
            .summary-card .value {
                color: #000000 !important;
            }

            .table-wrap {
                overflow: visible;
                border-radius: 0;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                background: #ffffff !important;
                color: #000000 !important;
                border-radius: 0;
            }

            th {
                background: #111827 !important;
                color: #ffffff !important;
                border: 1px solid #111827;
                padding: 9px;
                font-size: 11px;
            }

            td {
                background: #ffffff !important;
                color: #000000 !important;
                border: 1px solid #9ca3af;
                padding: 8px;
                font-size: 11px;
                font-weight: normal;
            }

            .member-cell,
            .price-cell {
                color: #000000 !important;
                font-weight: bold;
            }

            .method-badge,
            .status-badge {
                background: transparent !important;
                color: #000000 !important;
                padding: 0;
                border-radius: 0;
                font-weight: normal;
            }

            @page {
                size: landscape;
                margin: 12mm;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="print-header">
            <h2>Gym Membership Management System</h2>
            <p>Payments Report</p>
        </div>

        <h1>Payments Report</h1>
        <p class="subtitle">Summary of payment records, methods, amounts, and payment status.</p>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Report</button>
        </div>

        @php
            $paymentList = $payments ?? collect();

            $paidTotal = $paymentList
                ->filter(fn($payment) => in_array(strtolower($payment->status ?? ''), ['paid', 'approved']))
                ->sum('amount');

            $pendingTotal = $paymentList
                ->filter(fn($payment) => strtolower($payment->status ?? '') === 'pending')
                ->sum('amount');

            $cancelledTotal = $paymentList
                ->filter(fn($payment) => in_array(strtolower($payment->status ?? ''), ['cancelled', 'canceled']))
                ->sum('amount');

            $allTotal = $paymentList->sum('amount');
        @endphp

        <div class="summary-grid">
            <div class="summary-card">
                <div class="label">All Payment Records</div>
                <div class="value value-total">₱{{ number_format($allTotal, 2) }}</div>
            </div>

            <div class="summary-card">
                <div class="label">Collected Payments</div>
                <div class="value value-paid">₱{{ number_format($paidTotal, 2) }}</div>
            </div>

            <div class="summary-card">
                <div class="label">Pending Payments</div>
                <div class="value value-pending">₱{{ number_format($pendingTotal, 2) }}</div>
            </div>

            <div class="summary-card">
                <div class="label">Cancelled Payments</div>
                <div class="value value-cancelled">₱{{ number_format($cancelledTotal, 2) }}</div>
            </div>
        </div>

        @if($paymentList->count() > 0)
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Membership Plan</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($paymentList as $payment)
                            @php
                                $status = strtolower($payment->status ?? 'pending');

                                $statusClass = match($status) {
                                    'paid' => 'status-paid',
                                    'approved' => 'status-approved',
                                    'cancelled' => 'status-cancelled',
                                    'canceled' => 'status-canceled',
                                    default => 'status-pending',
                                };

                                $method = $payment->payment_method
                                    ?? $payment->method
                                    ?? 'N/A';
                            @endphp

                            <tr>
                                <td class="member-cell">
                                    {{ $payment->member->full_name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $payment->membership->plan_name ?? 'N/A' }}
                                </td>

                                <td class="price-cell">
                                    ₱{{ number_format($payment->amount ?? 0, 2) }}
                                </td>

                                <td>
                                    <span class="method-badge">
                                        {{ $method }}
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
                                            : ($payment->created_at
                                                ? $payment->created_at->format('Y-m-d')
                                                : 'N/A')) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
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