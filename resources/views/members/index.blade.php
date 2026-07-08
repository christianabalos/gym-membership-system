<!DOCTYPE html>
<html>
<head>
    <title>Members</title>

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

        .member-name {
            font-weight: bold;
            color: #111827;
        }

        .trainer-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .no-trainer {
            display: inline-block;
            background: #f3f4f6;
            color: #6b7280;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            gap: 7px;
            align-items: center;
            justify-content: center;
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
                min-width: 850px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Members</h1>
        <p class="subtitle">Manage registered gym members.</p>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back</a>
            <a href="{{ route('members.create') }}" class="btn btn-primary">Add Member</a>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if($members->count() > 0)
            <div class="table-wrap">
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Trainer</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Registration Date</th>
                        <th>Action</th>
                    </tr>

                    @foreach($members as $member)
                        <tr>
                            <td class="member-name">
                                {{ $member->full_name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $member->user->email ?? 'N/A' }}
                            </td>

                            <td>
                                @if($member->trainer)
                                    <span class="trainer-badge">
                                        {{ $member->trainer->name }}
                                    </span>
                                @else
                                    <span class="no-trainer">No Trainer</span>
                                @endif
                            </td>

                            <td>
                                {{ $member->phone ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $member->gender ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $member->created_at ? $member->created_at->format('Y-m-d') : 'N/A' }}
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('members.show', $member->id) }}" class="btn btn-view">View</a>

                                    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-edit">Edit</a>

                                    <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Delete this member?');">
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
                No members found.
            </div>
        @endif
    </div>
</body>
</html>