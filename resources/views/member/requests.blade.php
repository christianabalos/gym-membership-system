<!DOCTYPE html>
<html>
<head>
    <title>My Requests</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 950px;
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
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
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
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .subject {
            font-weight: bold;
            color: #1d4ed8;
        }

        .message {
            color: #374151;
            line-height: 1.4;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-resolved {
            background: #dcfce7;
            color: #166534;
        }

        .badge-rejected {
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
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            table {
                min-width: 700px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Requests</h1>
        <p class="subtitle">View your sent requests and their current status.</p>

        <div class="top-actions">
            <a href="{{ route('member.dashboard') }}" class="btn btn-back">Back</a>
            <a href="{{ route('member.requests.create') }}" class="btn btn-primary">Send New Request</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($requests->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date Sent</th>
                    </tr>

                    @foreach($requests as $request)
                        <tr>
                            <td class="subject">
                                {{ $request->subject }}
                            </td>

                            <td class="message">
                                {{ $request->message }}
                            </td>

                            <td>
                                @php
                                    $statusClass = match($request->status) {
                                        'resolved' => 'badge-resolved',
                                        'rejected' => 'badge-rejected',
                                        default => 'badge-pending',
                                    };
                                @endphp

                                <span class="badge {{ $statusClass }}">
                                    {{ $request->status }}
                                </span>
                            </td>

                            <td>
                                {{ $request->created_at ? $request->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No requests found. Click <strong>Send New Request</strong> to create one.
            </div>
        @endif
    </div>
</body>
</html>