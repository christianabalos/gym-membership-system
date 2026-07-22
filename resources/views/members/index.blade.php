<!DOCTYPE html>
<html>
<head>
    <title>Members</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            padding: 35px 15px;
            color: #ffffff;
            background: linear-gradient(rgba(15, 23, 42, 0.82), rgba(15, 23, 42, 0.82)), url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container {
            max-width: 1350px; 
            margin: auto;
            padding: 34px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.28);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        h1 { text-align: center; margin: 0; font-size: 36px; font-weight: 800; color: #ffffff; text-shadow: 0 3px 12px rgba(0,0,0,0.45); }
        .subtitle { text-align: center; margin: 10px 0 28px; color: #dbeafe; font-size: 15px; }
        .top-actions { display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap; }
        .data-panel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .export-group, .import-group { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .panel-label { font-size: 13px; font-weight: bold; color: #93c5fd; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            transition: 0.2s;
        }
        .btn:hover { transform: translateY(-1px); opacity: 0.95; }
        .btn-back { background: rgba(107, 114, 128, 0.88); color: white; }
        .btn-add { background: #2563eb; color: white; }
        .btn-view { background: #3b82f6; color: white; }
        .btn-edit { background: #6b7280; color: white; }
        .btn-delete { background: #dc2626; color: white; }
        .btn-csv { background: #0284c7; color: white; }
        .btn-xlsx { background: #16a34a; color: white; }
        .btn-json { background: #d97706; color: white; }
        .file-upload-wrapper {
            position: relative;
            display: inline-block;
        }

        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .btn-import-trigger {
            background: rgba(255,255,255,.15);
            color:#fff;
            border:1px dashed rgba(255,255,255,.3);
            padding:10px 16px;
            border-radius:9px;
            cursor:pointer;
            font-size:13px;
            font-weight:bold;
            transition:.2s;
        }
        .btn-import-trigger:hover { background: rgba(255, 255, 255, 0.25); }
        .success { background: rgba(220, 252, 231, 0.92); color: #166534; border: 1px solid #86efac; padding: 13px 15px; border-radius: 10px; margin-bottom: 20px; font-weight: bold; }
        .error-alert { background: rgba(254, 226, 226, 0.92); color: #991b1b; border: 1px solid #fca5a5; padding: 13px 15px; border-radius: 10px; margin-bottom: 20px; font-weight: bold; }
        .error-alert ul { margin: 8px 0 0 0; padding-left: 20px; font-size: 13px; }
        .table-wrap { width: 100%; overflow-x: auto; border-radius: 14px; }
        table { width: 100%; border-collapse: collapse; background: rgba(255, 255, 255, 0.08); color: #ffffff; border-radius: 14px; overflow: hidden; }
        th { background: rgba(15, 23, 42, 0.92); color: #ffffff; padding: 15px; text-align: center; font-size: 13px; }
        td { padding: 12px; background: rgba(255, 255, 255, 0.08); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.18); vertical-align: middle; text-align: center; font-size: 13px; }
        .member-name { font-weight: 800; color: #ffffff; text-align: left; }
        .trainer-badge { display: inline-block; background: rgba(219, 234, 254, 0.90); color: #1d4ed8; padding: 7px 12px; border-radius: 999px; font-size: 12px; font-weight: bold; }
        .no-trainer { display: inline-block; background: rgba(255, 255, 255, 0.18); color: #e5e7eb; padding: 7px 12px; border-radius: 999px; font-size: 12px; font-weight: bold; }
        .action-buttons { display: flex; gap: 6px; justify-content: center; align-items: center; flex-wrap: wrap; }
        .delete-form { display: inline; margin: 0; }
        .empty { text-align: center; color: #e5e7eb; padding: 25px; font-weight: bold; }
        .qr-thumbnail { background: white; padding: 4px; border-radius: 8px; display: inline-block; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
    </style>
</head>
<body>
    <div class="container">
        <h1>Members</h1>
        <p class="subtitle">Manage registered gym members.</p>
        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back</a>
            <a href="{{ route('members.create') }}" class="btn btn-add">Add Member</a>
            <a href="{{ route('members.scan') }}" class="btn btn-add">📷 Scan QR</a>
        </div>
        <div class="data-panel">
            <div class="export-group">
                <span class="panel-label">Export Members:</span>
                <a href="{{ route('members.export', 'csv') }}" class="btn btn-csv">CSV</a>
                <a href="{{ route('members.export', 'xlsx') }}" class="btn btn-xlsx">Excel (XLSX)</a>
                <a href="{{ route('members.export', 'json') }}" class="btn btn-json">JSON</a>
            </div>
                <div class="import-group">
                    <span class="panel-label">Import List:</span>

                    <form action="{{ route('members.import') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        id="importForm"
                        style="display:inline-block; margin:0;">

                        @csrf

                        <div class="file-upload-wrapper">
                            <button type="button" class="btn btn-import-trigger">
                                Upload CSV File
                            </button>

                            <input type="file"
                                name="import_file"
                                class="file-upload-input"
                                accept=".csv"
                                onchange="submitImportForm()"
                                required>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 20px; margin-top: 15px;">
            <form action="{{ route('members.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search member name or email..." style="padding: 8px 12px; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.3); background-color: rgba(0, 0, 0, 0.2); color: white; width: 300px; max-width: 100%; outline: none;">
                <button type="submit" style="padding: 8px 16px; border-radius: 6px; background-color: #3b82f6; color: white; border: none; cursor: pointer; font-weight: bold; transition: 0.2s;">Search</button>
                @if(request('search'))
                    <a href="{{ route('members.index') }}" style="padding: 8px 16px; border-radius: 6px; background-color: #6b7280; color: white; text-decoration: none; font-weight: bold; font-size: 13px;">Clear</a>
                @endif
            </form>
        </div>
        @if(session('success')) <div class="success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="error-alert">{{ session('error') }}</div> @endif
        @if($errors->any())
            <div class="error-alert">
                <span>Error</span>
                <ul> @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
            </div>
        @endif
        <div class="table-wrap">
            <table>
                <tr>
                <th>Name</th>
                <th>QR Pass</th>
                <th>Email</th>
                <th>Health</th>
                <th>Trainer</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Registration Date</th>
                <th>Action</th>
                </tr>
                @forelse($members as $member)
                    <tr>
                        <td class="member-name">{{ $member->full_name }}</td>
                        <td>
                            <div class="qr-thumbnail">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data={{ urlencode(route('members.show', $member->id)) }}" alt="QR Code" style="display: block; width: 65px; height: 65px;">
                            </div>
                        </td>
                        <td>{{ $member->user->email ?? $member->email ?? 'N/A' }}</td>
                        
                            <td>
                                @if($member->no_health_issue)
                                    <span style="
                                        background:#16a34a;
                                        color:white;
                                        padding:6px 10px;
                                        border-radius:999px;
                                        font-size:12px;
                                        font-weight:bold;
                                    ">
                                        🟢 None Declared
                                    </span>

                                @elseif($member->health_declaration)

                                    <span style="
                                        background:#facc15;
                                        color:#111827;
                                        padding:6px 10px;
                                        border-radius:999px;
                                        font-size:12px;
                                        font-weight:bold;
                                    ">
                                        🟠 Has Declaration
                                    </span>

                                @else

                                    <span style="
                                        background:#6b7280;
                                        color:white;
                                        padding:6px 10px;
                                        border-radius:999px;
                                        font-size:12px;
                                        font-weight:bold;
                                    ">
                                        —
                                    </span>

                                @endif
                            </td>
                        <td>
                            @php
                                $latestMembership = $member->memberships->sortByDesc('created_at')->first();
                                $trainer = $latestMembership?->trainer;
                            @endphp
                            @if($trainer) <span class="trainer-badge">{{ $trainer->name }}</span>
                            @else <span class="no-trainer">No Trainer</span> @endif
                        </td>
                        <td>{{ $member->phone ?? 'N/A' }}</td>
                        <td>{{ $member->gender ?? 'N/A' }}</td>
                        <td>{{ $member->created_at ? $member->created_at->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('members.show', $member->id) }}" class="btn btn-view">View</a>
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-edit">Edit</a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Delete this member?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr> <td colspan="9" class="empty">No members found.</td> </tr>
                @endforelse
            </table>
        </div>
    </div>
    <script>
        function submitImportForm() {
            const form = document.getElementById('importForm');
            if (confirm("Are you sure you want to import members from this CSV file?")) {
                form.submit();
            }
        }
    </script>
</body>
</html>