<!DOCTYPE html>
<html>
<head>
    <title>Memberships Report</title>
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

        .summary-box {
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 20px;
            border: 1px solid rgba(203, 213, 225, 0.9);
            font-weight: 800;
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

        .trainer-badge {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 999px;
            background: rgba(219, 234, 254, 0.95);
            color: #1d4ed8;
            font-weight: 900;
            line-height: 1.25;
        }

        .price-cell {
            color: #86efac;
            font-weight: 900;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            text-transform: capitalize;
        }

        .status-approved,
        .status-active {
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

            .summary-box {
                background: #ffffff !important;
                color: #000000 !important;
                border: 1px solid #111827;
                padding: 12px;
                margin-bottom: 14px;
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

            .member-cell {
                font-weight: bold;
            }

            .price-cell {
                color: #000000 !important;
                font-weight: bold;
            }

            .trainer-badge,
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
            <p>Memberships Report</p>
        </div>

        <h1>Memberships Report</h1>
        <p class="subtitle">List of membership records, assigned trainers, plans, dates, and status.</p>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Report</button>
        </div>

        @php
            $membershipList = $memberships ?? collect();
        @endphp

        <div class="summary-box">
            Total Memberships: {{ $membershipList->count() }}
        </div>

        @if($membershipList->count() > 0)
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Trainer</th>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($membershipList as $membership)
                            @php
                                $status = strtolower($membership->status ?? 'pending');

                                $statusClass = match($status) {
                                    'approved' => 'status-approved',
                                    'active' => 'status-active',
                                    'cancelled' => 'status-cancelled',
                                    'canceled' => 'status-canceled',
                                    default => 'status-pending',
                                };
                            @endphp

                            <tr>
                                <td class="member-cell">
                                    {{ $membership->member->full_name ?? 'N/A' }}
                                </td>

                                <td>
                                    <span class="trainer-badge">
                                        {{ $membership->trainer->name ?? 'No Trainer' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $membership->plan_name ?? 'N/A' }}
                                </td>

                                <td class="price-cell">
                                    ₱{{ number_format($membership->price ?? 0, 2) }}
                                </td>

                                <td>
                                    {{ $membership->start_date ? \Carbon\Carbon::parse($membership->start_date)->format('Y-m-d') : 'N/A' }}
                                </td>

                                <td>
                                    {{ $membership->end_date ? \Carbon\Carbon::parse($membership->end_date)->format('Y-m-d') : 'N/A' }}
                                </td>

                                <td>
                                    <span class="status-badge {{ $statusClass }}">
                                        {{ ucfirst($membership->status ?? 'Pending') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty">
                No membership records found.
            </div>
        @endif
    </div>
</body>
</html>