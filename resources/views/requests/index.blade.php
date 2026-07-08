<!DOCTYPE html>
<html>
<head>
    <title>{{ request()->is('admin/*') ? 'Member Requests' : 'My Requests' }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 980px;
            margin: 70px auto;
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

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-update {
            background: #111827;
            color: white;
            margin-top: 8px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
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
            padding: 6px 12px;
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

        select {
            width: 100%;
            padding: 9px;
            border: 1px solid #9ca3af;
            border-radius: 7px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                margin: 30px auto;
                padding: 22px;
            }

            table {
                min-width: 800px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        @if(request()->is('admin/*'))
            <h1>Member Requests</h1>
            <p class="subtitle">View member concerns and update their request status.</p>
        @else
            <h1>My Requests</h1>
            <p class="subtitle">View your sent requests and their current status.</p>
        @endif

        <div class="top-actions">
            @if(request()->is('admin/*'))
                <a href="{{ route('dashboard') }}" class="btn btn-back">Back</a>
            @else
                <a href="{{ route('member.dashboard') }}" class="btn btn-back">Back</a>
                <a href="{{ route('member.requests.create') }}" class="btn btn-primary">Send New Request</a>
            @endif
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($requests->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        @if(request()->is('admin/*'))
                            <th>Member</th>
                        @endif

                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date Sent</th>

                        @if(request()->is('admin/*'))
                            <th>Action</th>
                        @endif
                    </tr>

                    @foreach($requests as $request)
                        @php
                            $status = strtolower($request->status ?? 'pending');

                            $statusClass = match($status) {
                                'resolved' => 'badge-resolved',
                                'rejected' => 'badge-rejected',
                                default => 'badge-pending',
                            };

                            $statusText = match($status) {
                                'resolved' => 'Resolved',
                                'rejected' => 'Rejected',
                                default => 'Pending',
                            };
                        @endphp

                        <tr>
                            @if(request()->is('admin/*'))
                                <td>
                                    {{ $request->member->full_name ?? $request->user->name ?? 'N/A' }}
                                </td>
                            @endif

                            <td class="subject">{{ $request->subject }}</td>

                            <td class="message">{{ $request->message }}</td>

                            <td>
                                <span class="badge {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            <td>
                                {{ $request->created_at ? $request->created_at->format('M d, Y') : 'N/A' }}
                            </td>

                            @if(request()->is('admin/*'))
                                <td>
                                    <form action="{{ url('/admin/requests/' . $request->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <select name="status" required>
                                            <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="resolved" {{ $status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        </select>

                                        <button type="submit" class="btn btn-update">Update</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No requests found.
            </div>
        @endif
    </div>
</body>
</html>