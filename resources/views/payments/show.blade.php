<!DOCTYPE html>
<html>
<head>
    <title>Payment Details</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 760px;
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
            margin-bottom: 25px;
        }

        .details-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 220px 1fr;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .label {
            background: #f9fafb;
            padding: 16px;
            font-weight: bold;
            color: #374151;
            border-right: 1px solid #e5e7eb;
        }

        .value {
            padding: 16px;
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
            font-size: 13px;
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

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            .detail-row {
                grid-template-columns: 1fr;
            }

            .label {
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Details</h1>
        <p class="subtitle">View complete payment information.</p>

        <a href="{{ route('payments.index') }}" class="btn btn-back">Back</a>

        <div class="details-card">
            <div class="detail-row">
                <div class="label">Member</div>
                <div class="value">
                    {{ $payment->member->full_name ?? 'N/A' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="label">Membership</div>
                <div class="value">
                    {{ $payment->membership->plan_name ?? 'N/A' }}
                </div>
            </div>

            <div class="detail-row">
                <div class="label">Amount</div>
                <div class="value amount">
                    ₱{{ number_format($payment->amount, 2) }}
                </div>
            </div>

            <div class="detail-row">
                <div class="label">Payment Method</div>
                <div class="value">
                    @if($payment->method == 'online')
                        Online Payment
                    @else
                        {{ ucfirst($payment->method ?? 'N/A') }}
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="label">Status</div>
                <div class="value">
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
                </div>
            </div>

            <div class="detail-row">
                <div class="label">Payment Date</div>
                <div class="value">
                    {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d') : ($payment->created_at ? $payment->created_at->format('Y-m-d') : 'N/A') }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>