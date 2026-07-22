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
                linear-gradient(rgba(15, 23, 42, 0.82), rgba(15, 23, 42, 0.82)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 1250px;
            margin: auto;
            padding: 38px 36px;
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 38px;
            font-weight: 900;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 10px 0 30px;
            color: #dbeafe;
            font-size: 15px;
            font-weight: 600;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 26px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 800;
            transition: 0.2s ease;
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

        .section-title {
            margin: 0 0 18px;
            font-size: 26px;
            font-weight: 900;
            color: #ffffff;
            text-shadow: 0 2px 10px rgba(0,0,0,0.35);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
            align-items: stretch;
        }

        .summary-card {
            min-height: 145px;
            padding: 20px 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.94);
            color: #111827;
            border: 1px solid rgba(203, 213, 225, 0.95);
            box-shadow: 0 10px 22px rgba(0,0,0,0.18);
            text-align: center;

            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .summary-card .label {
            margin: 0 0 14px;
            min-height: 24px;
            font-size: 13px;
            color: #475569;
            font-weight: 900;
            line-height: 1.2;
            text-align: center;
            white-space: nowrap;
        }

        .summary-card .value {
            margin: 0;
            min-height: 36px;
            font-size: 30px;
            font-weight: 900;
            line-height: 1;
            color: #111827;

            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .value.active {
            color: #166534;
        }

        .value.expired {
            color: #991b1b;
        }

        .value.cancelled {
            color: #92400e;
        }

        .value.revenue {
            color: #2563eb;
            font-size: 29px;
        }

        .table-card {
            padding: 18px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow: 0 12px 28px rgba(0,0,0,0.25);
        }

        .table-wrap {
            overflow-x: auto;
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.08);
        }

        th {
            background: rgba(15, 23, 42, 0.96);
            color: #ffffff;
            padding: 15px;
            font-size: 14px;
            font-weight: 900;
            text-align: center;
            white-space: nowrap;
        }

        td {
            padding: 15px;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.14);
        }

        .plan-badge {
            display: inline-block;
            min-width: 95px;
            padding: 8px 13px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
        }

        .plan-monthly {
            background: rgba(219, 234, 254, 0.95);
            color: #1d4ed8;
        }

        .plan-quarterly {
            background: rgba(237, 233, 254, 0.95);
            color: #6d28d9;
        }

        .plan-annual {
            background: rgba(220, 252, 231, 0.95);
            color: #166534;
        }

        .money {
            color: #86efac;
            font-weight: 900;
        }

        @media (max-width: 1200px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .summary-card .label {
                white-space: normal;
            }
        }

        @media (max-width: 650px) {
            body {
                padding: 18px 12px;
            }

            .container {
                padding: 24px 16px;
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

            table {
                min-width: 700px;
            }
        }

        @media print {
            body {
                background: #ffffff !important;
                color: #111827 !important;
                padding: 0;
            }

            .container {
                max-width: 100%;
                box-shadow: none;
                border: none;
                background: #ffffff !important;
                backdrop-filter: none;
                padding: 20px;
            }

            .top-actions {
                display: none;
            }

            h1,
            .subtitle,
            .section-title {
                color: #111827 !important;
                text-shadow: none;
            }

            .summary-grid {
                grid-template-columns: repeat(5, 1fr);
                gap: 8px;
            }

            .summary-card {
                min-height: 95px;
                padding: 10px;
            }

            .summary-card .label {
                font-size: 10px;
                white-space: normal;
            }

            .summary-card .value {
                font-size: 18px;
            }

            .summary-card,
            .table-card,
            table,
            th,
            td {
                box-shadow: none !important;
                background: #ffffff !important;
                color: #111827 !important;
                border: 1px solid #d1d5db !important;
            }

            th {
                background: #111827 !important;
                color: #ffffff !important;
            }

            .money,
            .value,
            .value.active,
            .value.expired,
            .value.cancelled,
            .value.revenue {
                color: #111827 !important;
            }

            .plan-badge {
                background: #ffffff !important;
                color: #111827 !important;
                border: 1px solid #d1d5db;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Membership Analytics</h1>
        <p class="subtitle">Monitor membership totals, plan usage, and generated revenue.</p>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Analytics</button>
        </div>

        <h2 class="section-title">Membership Summary</h2>

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
                <p class="label">Cancelled Memberships</p>
                <p class="value cancelled">{{ $cancelledMemberships ?? 0 }}</p>
            </div>

            <div class="summary-card">
                <p class="label">Total Revenue</p>
                <p class="value revenue">₱{{ number_format($totalRevenue ?? 0, 2) }}</p>
            </div>
        </div>

        <h2 class="section-title">Plan Analytics</h2>

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
    @forelse($planAnalytics ?? [] as $item)
        @php
            $plan = strtolower($item['plan'] ?? '');
            $planClass = 'plan-' . $plan;
        @endphp

        <tr>
            <td>
                <span class="plan-badge {{ $planClass }}">
                    {{ $item['plan'] ?? 'N/A' }}
                </span>
            </td>

            <td>
                {{ $item['total_members'] ?? 0 }}
            </td>

            <td class="money">
                ₱{{ number_format($item['total_revenue'] ?? 0, 2) }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="3">No analytics data available.</td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>