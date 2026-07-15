<!DOCTYPE html>
<html>
<head>
    <title>My Requests</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 35px 15px;
            min-height: 100vh;
            color: #ffffff;
            background:
                linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.78)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            padding: 36px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.30);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.38);
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
            margin-top: 10px;
            margin-bottom: 30px;
            color: #dbeafe;
            font-size: 15px;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-back {
            background: rgba(107, 114, 128, 0.95);
            color: white;
        }

        .btn-new {
            background: #2563eb;
            color: white;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .btn-new:hover {
            background: #1d4ed8;
        }

        .success {
            background: rgba(220, 252, 231, 0.95);
            color: #166534;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            overflow: hidden;
            border-radius: 14px;
        }

        th {
            background: #0f172a;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 14px;
        }

        td {
            padding: 14px;
            border: 1px solid #d1d5db;
            text-align: center;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: rgba(249, 250, 251, 0.92);
        }

        .request-type {
            font-weight: bold;
            color: #2563eb;
            text-transform: capitalize;
        }

        .message-cell {
            text-align: left;
            max-width: 350px;
            line-height: 1.5;
        }

        .badge {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .approved {
            background: #dcfce7;
            color: #166534;
        }

        .resolved {
            background: #dcfce7;
            color: #166534;
        }

        .rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-box {
            background: rgba(255, 255, 255, 0.90);
            color: #374151;
            border-radius: 14px;
            padding: 28px;
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            border: 1px solid rgba(203, 213, 225, 0.9);
        }

        .empty-box span {
            display: block;
            font-size: 34px;
            margin-bottom: 8px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 24px;
            }

            h1 {
                font-size: 30px;
            }

            table {
                min-width: 800px;
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
            <a href="{{ route('member.requests.create') }}" class="btn btn-new">Send New Request</a>
        </div>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if(isset($requests) && $requests->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Request Type</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date Sent</th>
                    </tr>

                    @foreach($requests as $request)
                        @php
                            $status = strtolower($request->status ?? 'pending');

                            $statusClass = match($status) {
                                'approved' => 'approved',
                                'resolved' => 'resolved',
                                'rejected' => 'rejected',
                                default => 'pending',
                            };
                        @endphp

                        <tr>
                            <td class="request-type">
                                {{ $request->type ?? $request->request_type ?? 'General Request' }}
                            </td>

                            <td class="message-cell">
                                {{ $request->message ?? $request->description ?? 'No message provided.' }}
                            </td>

                            <td>
                                <span class="badge {{ $statusClass }}">
                                    {{ ucfirst($status) }}
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
            <div class="empty-box">
                <span>📩</span>
                No requests found.
            </div>
        @endif
    </div>
</body>
</html>