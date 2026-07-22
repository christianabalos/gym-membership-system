<!DOCTYPE html>
<html>
<head>
    <title>Trainer Report</title>
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
            border: 1px solid rgba(255, 255, 255, 0.26);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 36px;
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

        .actions {
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
            color: white;
            transition: 0.2s;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .btn-back {
            background: rgba(107, 114, 128, 0.95);
        }

        .btn-print {
            background: #2563eb;
        }

        .summary-box {
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            border: 1px solid rgba(203, 213, 225, 0.9);
            border-radius: 10px;
            padding: 15px 18px;
            margin-bottom: 22px;
            font-size: 15px;
            font-weight: 800;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
            border: 1px solid rgba(203, 213, 225, 0.35);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.07);
        }

        th {
            background: rgba(15, 23, 42, 0.95);
            color: #ffffff;
            padding: 13px 12px;
            text-align: center;
            font-size: 13px;
            border: 1px solid rgba(203, 213, 225, 0.18);
            white-space: nowrap;
        }

        td {
            padding: 13px 12px;
            color: #f9fafb;
            border: 1px solid rgba(203, 213, 225, 0.18);
            background: rgba(255, 255, 255, 0.07);
            vertical-align: middle;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
        }

        .specialization-cell {
            color: #bfdbfe;
            font-weight: 900;
        }

        .member-list {
            text-align: left;
            margin: 0;
            padding-left: 18px;
            color: #ffffff;
        }

        .member-list li {
            margin: 4px 0;
        }

        .empty-text {
            color: #e5e7eb;
            font-style: italic;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            h1 {
                font-size: 30px;
            }

            table {
                min-width: 850px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }

        @media print {
            body {
                background: white !important;
                color: black !important;
                padding: 0;
            }

            .container {
                max-width: 100%;
                box-shadow: none;
                border: none;
                background: white !important;
                padding: 20px;
            }

            h1 {
                color: black !important;
                text-shadow: none;
                font-size: 26px;
            }

            .subtitle {
                color: #374151 !important;
            }

            .actions,
            .btn {
                display: none !important;
            }

            .summary-box {
                background: white !important;
                color: black !important;
                border: 1px solid #d1d5db;
            }

            .table-wrap {
                border: 1px solid #d1d5db;
                overflow: visible;
            }

            table {
                background: white !important;
                width: 100%;
            }

            th {
                background: #111827 !important;
                color: white !important;
                border: 1px solid #d1d5db;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            td {
                background: white !important;
                color: black !important;
                border: 1px solid #d1d5db;
            }

            .specialization-cell {
                color: black !important;
            }

            .member-list {
                color: black !important;
            }

            .empty-text {
                color: black !important;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Trainer Report</h1>
        <p class="subtitle">List of trainers, specializations, and assigned members.</p>

        <div class="actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Report</button>
        </div>

        <div class="summary-box">
            Total Trainers: {{ $trainers->count() }}
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Specialization</th>
                        <th>Members</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($trainers as $trainer)
                        @php
                            $assignedMembers = collect();

                            if ($trainer->relationLoaded('memberships')) {
                                $assignedMembers = $trainer->memberships
                                    ->filter(function ($membership) {
                                        return in_array(strtolower($membership->status ?? ''), ['active', 'approved']);
                                    })
                                    ->map(function ($membership) {
                                        return $membership->member ?? null;
                                    })
                                    ->filter()
                                    ->unique('id')
                                    ->values();
                            }
                        @endphp

                        <tr>
                            <td>{{ $trainer->name ?? 'N/A' }}</td>
                            <td>{{ $trainer->email ?? 'N/A' }}</td>
                            <td>{{ $trainer->phone ?? 'N/A' }}</td>
                            <td class="specialization-cell">
                                {{ $trainer->specialization ?? 'N/A' }}
                            </td>
                            <td>
                                @if($assignedMembers->count() > 0)
                                    <ul class="member-list">
                                        @foreach($assignedMembers as $member)
                                            <li>{{ $member->full_name ?? $member->name ?? 'N/A' }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="empty-text">No assigned members</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-text">
                                No trainers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>