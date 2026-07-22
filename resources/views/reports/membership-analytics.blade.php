<!DOCTYPE html>
<html>
<head>
    <title>Membership Analytics</title>
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
                linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.78)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 38px 30px;
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 34px;
            font-weight: 900;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 12px 0 30px;
            color: #dbeafe;
            font-size: 15px;
            font-weight: 600;
        }

        h2 {
            margin: 0 0 18px;
            font-size: 24px;
            font-weight: 900;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.30);
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 800;
            transition: 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .btn-back {
            background: rgba(107, 114, 128, 0.95);
            color: #ffffff;
        }

        .btn-print {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-print:hover {
            background: #1d4ed8;
        }

        .summary-section {
            margin-bottom: 30px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 14px;
            align-items: stretch;
        }

        .summary-card {
            min-height: 140px;
            padding: 18px 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.95);
            color: #111827;
            border: 1px solid rgba(203, 213, 225, 0.95);
            box-shadow: 0 10px 24px rgba(0,0,0,0.18);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .summary-card .label {
            margin: 0 0 12px;
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 13px;
            line-height: 1.25;
            font-weight: 900;
            color: #475569;
        }

        .summary-card .value {
            margin: 0;
            min-height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 25px;
            font-weight: 900;
            line-height: 1;
            color: #111827;
        }

        .value.active {
            color: #166534;
        }

        .value.expired {
            color: #b91c1c;
        }

        .value.cancelled {
            color: #b45309;
        }

        .value.revenue {
            color: #2563eb;
        }

        .table-card {
            border-radius: 22px;
            padding: 16px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.08);
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 14px;
            background: rgba(255,255,255,0.20);
        }

        th {
            background: #0f172a;
            color: #ffffff;
            padding: 15px 14px;
            text-align: center;
            font-size: 14px;
            font-weight: 800;
        }

        td {
            padding: 14px;
            border: 1px solid rgba(203, 213, 225, 0.35);
            text-align: center;
            font-size: 14px;
            color: #ffffff;
            font-weight: 600;
        }

        tbody tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.05);
        }

        .plan-badge {
            display: inline-block;
            min-width: 82px;
            padding: 7px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
        }

        .monthly {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .quarterly {
            background: #ede9fe;
            color: #7c3aed;
        }

        .annual {
            background: #dcfce7;
            color: #15803d;
        }

        .amount {
            color: #86efac;
            font-weight: 900;
        }

        @media print {
            @page {
                size: landscape;
                margin: 12mm;
            }

            body {
                background: #ffffff;
                padding: 0;
                margin: 0;
                color: #000000;
            }

            .container {
                max-width: 100%;
                width: 100%;
                padding: 0;
                border-radius: 0;
                box-shadow: none;
                border: none;
                background: #ffffff;
                color: #000000;
                backdrop-filter: none;
            }

            .top-actions {
                display: none;
            }

            h1, h2 {
                color: #000000;
                text-shadow: none;
            }

            .subtitle {
                color: #374151;
            }

            .summary-card {
                background: #ffffff;
                color: #111827;
                box-shadow: none;
                border: 1px solid #cbd5e1;
            }

            .table-card {
                background: #ffffff;
                border: none;
                box-shadow: none;
                padding: 0;
            }

            table {
                background: #ffffff;
            }

            th {
                background: #111827 !important;
                color: #ffffff !important;
            }

            td {
                color: #111827 !important;
                border: 1px solid #d1d5db;
            }

            .amount {
                color: #166534 !important;
            }
        }

        @media (max-width: 1000px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 18px 12px;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 28px;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .summary-card {
                min-height: 120px;
            }

            .table-wrap {
                overflow-x: auto;
            }

            table {
                min-width: 650px;
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

        <div class="summary-section">
            <h2>Membership Summary</h2>

            <div class="summary-grid">
                <div class="summary-card">
                    <p class="label">Total Memberships</p>
                    <p class="value">{{ $totalMemberships ?? 0 }}</p>
                </div>

                <div class="summary-card">
                    <p class="label">Active Memberships</p>
                    <p class="value active">{{ $activeMemberships ?? 0 }}</p>
                </div>

                <div class="summary-card">
                    <p class="label">Expired Memberships</p>
                    <p class="value expired">{{ $expiredMemberships ?? 0 }}</p>
                </div>

                <div class="summary-card">
                    <p class="label">Cancelled<br>Memberships</p>
                    <p class="value cancelled">{{ $cancelledMemberships ?? 0 }}</p>
                </div>

                <div class="summary-card">
                    <p class="label">Total Revenue</p>
                    <p class="value revenue">₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <div>
            <h2>Plan Analytics</h2>

            <div class="table-card">
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
                                    <td>
                                        <span class="plan-badge {{ strtolower($analytics['plan']) }}">
                                            {{ $analytics['plan'] }}
                                        </span>
                                    </td>
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
        </div>
    </div>
</body>
</html>