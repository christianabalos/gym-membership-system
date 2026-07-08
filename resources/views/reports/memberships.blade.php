<!DOCTYPE html>
<html>
<head>
    <title>Memberships Report</title>

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

        .summary-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: bold;
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

        .trainer-name {
            color: #2563eb;
            font-weight: bold;
        }

        .price {
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

        .badge-approved,
        .badge-active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-expired {
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

            .summary-box {
                padding: 10px;
                margin-bottom: 15px;
                font-size: 12px;
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

            table {
                min-width: 850px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Memberships Report</h1>
        <p class="subtitle">List of membership records, assigned trainers, plans, dates, and status.</p>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Report</button>
        </div>

        <div class="summary-box">
            Total Memberships: {{ $memberships->count() }}
        </div>

        @if($memberships->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Member</th>
                        <th>Trainer</th>
                        <th>Plan</th>
                        <th>Price</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>

                    @foreach($memberships as $membership)
                        <tr>
                            <td class="member-name">
                                {{ $membership->member->full_name ?? 'N/A' }}
                            </td>

                            <td class="trainer-name">
                                {{ $membership->trainer->name ?? 'No Trainer' }}
                            </td>

                            <td>
                                {{ $membership->plan_name ?? 'N/A' }}
                            </td>

                            <td class="price">
                                ₱{{ number_format($membership->price, 2) }}
                            </td>

                            <td>
                                {{ $membership->start_date ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $membership->end_date ?? 'N/A' }}
                            </td>

                            <td>
                                @php
                                    $status = strtolower($membership->status ?? 'pending');

                                    $statusClass = match($status) {
                                        'approved' => 'badge-approved',
                                        'active' => 'badge-active',
                                        'expired' => 'badge-expired',
                                        default => 'badge-pending',
                                    };

                                    $statusText = match($status) {
                                        'active' => 'Approved',
                                        default => ucfirst($status),
                                    };
                                @endphp

                                <span class="badge {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No memberships found.
            </div>
        @endif
    </div>
</body>
</html>