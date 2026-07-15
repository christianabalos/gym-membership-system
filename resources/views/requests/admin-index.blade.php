<!DOCTYPE html>
<html>
<head>
    <title>Member Requests</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            padding: 35px;
            color: #ffffff;
            background:
                linear-gradient(rgba(15, 23, 42, 0.82), rgba(15, 23, 42, 0.82)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 34px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.28);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(14px);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            font-size: 34px;
            color: #ffffff;
        }

        .subtitle {
            text-align: center;
            color: #d1d5db;
            margin-bottom: 28px;
        }

        .top-actions {
            margin-bottom: 22px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .btn-save {
            background: #2563eb;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
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
            background: rgba(255,255,255,0.96);
            color: #111827;
            border-radius: 14px;
            overflow: hidden;
        }

        th {
            background: #0f172a;
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 13px;
        }

        td {
            padding: 13px;
            border: 1px solid #d1d5db;
            font-size: 13px;
            text-align: center;
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .message-cell {
            text-align: left;
            max-width: 300px;
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

        select {
            padding: 8px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 13px;
        }

        .action-form {
            display: inline-block;
            margin: 3px;
        }

        .empty {
            background: rgba(255,255,255,0.92);
            color: #475569;
            text-align: center;
            padding: 25px;
            border-radius: 14px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            table {
                min-width: 900px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Member Requests</h1>
        <p class="subtitle">View and manage requests sent by members.</p>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if(isset($requests) && $requests->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Member</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date Sent</th>
                        <th>Action</th>
                    </tr>

                    @foreach($requests as $request)
                        @php
                            $status = strtolower($request->status ?? 'pending');

                            $badgeClass = match($status) {
                                'resolved' => 'badge-resolved',
                                'rejected' => 'badge-rejected',
                                default => 'badge-pending',
                            };
                        @endphp

                        <tr>
                            <td>
                                {{ $request->member->full_name ?? $request->user->name ?? 'Member' }}
                            </td>

                            <td>
                                {{ $request->subject ?? 'N/A' }}
                            </td>

                            <td class="message-cell">
                                {{ $request->message ?? 'N/A' }}
                            </td>

                            <td>
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>

                            <td>
                                {{ $request->created_at ? $request->created_at->format('M d, Y') : 'N/A' }}
                            </td>

                            <td>
                                <form action="{{ route('admin.member-requests.updateStatus', $request->id) }}" method="POST" class="action-form">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status">
                                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="resolved" {{ $status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                    </select>

                                    <button type="submit" class="btn btn-save">Update</button>
                                </form>

                                <form action="{{ route('admin.member-requests.destroy', $request->id) }}" method="POST" class="action-form" onsubmit="return confirm('Delete this request?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No member requests found.
            </div>
        @endif
    </div>
</body>
</html>