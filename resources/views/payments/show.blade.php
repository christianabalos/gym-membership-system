<!DOCTYPE html>
<html>
<head>
    <title>Payment Details</title>
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
            max-width: 820px;
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
            margin-bottom: 25px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(107, 114, 128, 0.9);
            color: white;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid rgba(255,255,255,0.15);
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .details-box {
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.20);
            background: rgba(255,255,255,0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            font-size: 14px;
        }

        th {
            width: 35%;
            text-align: left;
            background: rgba(15, 23, 42, 0.75);
            color: #ffffff;
            font-weight: 800;
        }

        td {
            color: #ffffff;
            background: rgba(255,255,255,0.08);
            font-weight: 700;
        }

        .amount {
            color: #86efac;
            font-weight: 900;
        }

        .method-badge,
        .status-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
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

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 30px;
            }

            th,
            td {
                display: block;
                width: 100%;
            }

            th {
                border-bottom: none;
            }
        }
    </style>
</head>

<body>
    @php
        $method = strtolower($payment->payment_method ?? $payment->method ?? 'N/A');
        $status = strtolower($payment->status ?? 'pending');

        $methodClass = in_array($method, ['cash', 'online'])
            ? 'method-' . $method
            : 'method-na';

        $statusClass = 'status-' . $status;
    @endphp

    <div class="container">
        <h1>Payment Details</h1>
        <p class="subtitle">View complete payment information.</p>

        <div class="top-actions">
            <a href="{{ route('payments.index') }}" class="btn-back">Back</a>
        </div>

        <div class="details-box">
            <table>
                <tr>
                    <th>Member</th>
                    <td>{{ $payment->member->full_name ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Membership</th>
                    <td>{{ $payment->membership->plan_name ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Amount</th>
                    <td class="amount">₱{{ number_format($payment->amount ?? 0, 2) }}</td>
                </tr>

                <tr>
                    <th>Payment Method</th>
                    <td>
                        <span class="method-badge {{ $methodClass }}">
                            {{ $method !== 'n/a' ? ucfirst($method) : 'N/A' }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        <span class="status-badge {{ $statusClass }}">
                            {{ ucfirst($payment->status ?? 'Pending') }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>Payment Date</th>
                    <td>
                        {{ $payment->payment_date
                            ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d')
                            : ($payment->paid_at
                                ? \Carbon\Carbon::parse($payment->paid_at)->format('Y-m-d')
                                : ($payment->created_at ? $payment->created_at->format('Y-m-d') : 'N/A'))
                        }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>