<!DOCTYPE html>
<html>
<head>
    <title>Memberships</title>

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
            font-size: 34px;
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

        .btn-view {
            background: #2563eb;
            color: white;
        }

        .btn-edit {
            background: #6b7280;
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
            white-space: nowrap;
        }

        td {
            padding: 14px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
            font-size: 14px;
            white-space: nowrap;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        .member-name {
            font-weight: bold;
            color: #111827;
        }

        .trainer-name {
            color: #374151;
        }

        .price {
            font-weight: bold;
            color: #166534;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
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

        .actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .delete-form {
            display: inline;
            margin: 0;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 30px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            background: #f9fafb;
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
        <h1>Memberships</h1>
        <p class="subtitle">Manage all member membership records.</p>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back</a>
            <a href="{{ route('memberships.create') }}" class="btn btn-primary">Add Membership</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

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
                        <th>Action</th>
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

                            <td>
                                <div class="actions">
                                    <a href="{{ route('memberships.show', $membership->id) }}" class="btn btn-view">View</a>

                                    <a href="{{ route('memberships.edit', $membership->id) }}" class="btn btn-edit">Edit</a>

                                    <form action="{{ route('memberships.destroy', $membership->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Delete this membership?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @else
            <div class="empty">
                No memberships found. Click <strong>Add Membership</strong> to create one.
            </div>
        @endif
    </div>
</body>
</html>