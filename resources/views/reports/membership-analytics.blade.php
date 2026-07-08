<!DOCTYPE html>
<html>
<head>
    <title>Membership Analytics</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 1100px;
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

        h2 {
            margin-top: 35px;
            margin-bottom: 18px;
            font-size: 24px;
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
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-bottom: 30px;
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
            font-size: 14px;
            color: #6b7280;
        }

        .summary-card p {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            color: #111827;
        }

        .active {
            color: #166534 !important;
        }

        .expired {
            color: #991b1b !important;
        }

        .cancelled {
            color: #92400e !important;
        }

        .revenue {
            color: #2563eb !important;
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
            margin-bottom: 25px;
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

        .plan-name {
            font-weight: bold;
            color: #111827;
        }

        .amount {
            font-weight: bold;
            color: #166534;
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

            h1 {
                font-size: 24px;
                margin-bottom: 8px;
            }

            h2 {
                font-size: 18px;
                margin-top: 18px;
            }

            .subtitle {
                margin-bottom: 18px;
            }

            .summary-grid {
                grid-template-columns: repeat(5, 1fr);
                gap: 8px;
                margin-bottom: 15px;
            }

            .summary-card {
                padding: 10px;
            }

            .summary-card h3 {
                font-size: 10px;
            }

            .summary-card p {
                font-size: 15px;
            }

            th {
                padding: 8px;
                font-size: 11px;
            }

            td {
                padding: 8px;
                font-size: 11px;
            }
        }

        @media (max-width: 900px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
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
                min-width: 700px;
            }
        }
    </style>
</head>
<body>
    @php
        $planAnalytics = $planAnalytics ?? [
            [
                'plan' => 'Monthly',
                'total_members' => $monthlyCount ?? 0,
                'total_revenue' => $monthlyRevenue ?? 0,
            ],
            [
                'plan' => 'Quarterly',
                'total_members' => $quarterlyCount ?? 0,
                'total_revenue' => $quarterlyRevenue ?? 0,
            ],
            [
                'plan' => 'Annual',
                'total_members' => $annualCount ?? 0,
                'total_revenue' => $annualRevenue ?? 0,
            ],
        ];
    @endphp

    <div class="container">
        <h1>Membership Analytics</h1>
        <p class="subtitle">Monitor membership totals, plan usage, and generated revenue.</p>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Analytics</button>
        </div>

        <h2>Membership Summary</h2>

        <div class="summary-grid">
            <div class="summary-card">
                <h3>Total Memberships</h3>
                <p>{{ $totalMemberships ?? 0 }}</p>
            </div>

            <div class="summary-card">
                <h3>Active Memberships</h3>
                <p class="active">{{ $activeMemberships ?? 0 }}</p>
            </div>

            <div class="summary-card">
                <h3>Expired Memberships</h3>
                <p class="expired">{{ $expiredMemberships ?? 0 }}</p>
            </div>

            <div class="summary-card">
                <h3>Cancelled Memberships</h3>
                <p class="cancelled">{{ $cancelledMemberships ?? 0 }}</p>
            </div>

            <div class="summary-card">
                <h3>Total Revenue</h3>
                <p class="revenue">₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
            </div>
        </div>

        <h2>Plan Analytics</h2>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Total Members</th>
                        <th>Total Revenue</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($planAnalytics as $analytics)
                        <tr>
                            <td class="plan-name">{{ $analytics['plan'] }}</td>
                            <td>{{ $analytics['total_members'] }}</td>
                            <td class="amount">₱{{ number_format($analytics['total_revenue'], 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No membership data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>