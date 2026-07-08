<!DOCTYPE html>
<html>
<head>
    <title>Trainer Report</title>

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

        .trainer-name {
            font-weight: bold;
            color: #111827;
        }

        .specialization {
            color: #2563eb;
            font-weight: bold;
        }

        .members-list {
            margin: 0;
            padding-left: 18px;
            text-align: left;
        }

        .members-list li {
            margin-bottom: 4px;
        }

        .no-members {
            color: #6b7280;
            font-style: italic;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: bold;
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
        <h1>Trainer Report</h1>
        <p class="subtitle">List of trainers, specializations, and assigned members.</p>

        <div class="top-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-back">Back</a>
            <button type="button" onclick="window.print()" class="btn btn-print">Print Report</button>
        </div>

        <div class="summary-box">
            Total Trainers: {{ $trainers->count() }}
        </div>

        @if($trainers->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Specialization</th>
                        <th>Members</th>
                    </tr>

                    @foreach($trainers as $trainer)
                        <tr>
                            <td class="trainer-name">
                                {{ $trainer->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $trainer->email ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $trainer->phone ?? 'N/A' }}
                            </td>

                            <td class="specialization">
                                {{ $trainer->specialization ?? 'N/A' }}
                            </td>

                            <td>
                                @php
                                    $uniqueMembers = $trainer->memberships
                                        ->whereIn('status', ['active', 'approved'])
                                        ->pluck('member')
                                        ->filter()
                                        ->unique('id');
                                @endphp

                                @if($uniqueMembers->count() > 0)
                                    <ul class="members-list">
                                        @foreach($uniqueMembers as $member)
                                            <li>{{ $member->full_name }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="no-members">No members</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No trainers found.
            </div>
        @endif
    </div>
</body>
</html>