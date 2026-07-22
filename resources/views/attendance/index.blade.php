<!DOCTYPE html>
<html>
<head>

    <title>Attendance Records</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            font-family:Arial,sans-serif;
            margin:0;
            min-height:100vh;
            padding:35px 15px;
            color:#fff;

            background:
                linear-gradient(rgba(15,23,42,.82),rgba(15,23,42,.82)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");

            background-size:cover;
            background-position:center;
            background-attachment:fixed;
        }

        .container{

            max-width:1400px;
            margin:auto;

            padding:30px;

            border-radius:22px;

            background:rgba(255,255,255,.15);

            backdrop-filter:blur(15px);

            box-shadow:0 20px 40px rgba(0,0,0,.35);

        }        

        h1{

            color:white;

            margin-bottom:25px;

            text-shadow:0 3px 10px rgba(0,0,0,.5);

        }

        table{

            width:100%;

            border-collapse:collapse;

            background:rgba(255,255,255,.92);

            color:#111827;

            border-radius:15px;

            overflow:hidden;

        }

        th,td{

            border:1px solid #ddd;
            padding:12px;
            text-align:center;

        }

        th{

            background:#2563eb;
            color:white;

        }

        tr:nth-child(even){

            background:#f8fafc;

        }

        .dashboard-btn{
            display:inline-block;
            margin-bottom:20px;
            background:#1e293b;
            color:white;
            padding:12px 22px;
            border-radius:10px;
            text-decoration:none;
            font-weight:bold;
        }

        .dashboard-btn:hover{
            background:#2563eb;
        }

        .summary-grid{

            display:grid;

            grid-template-columns:repeat(3,1fr);

            gap:20px;

            margin-bottom:30px;

        }

        .summary-card{

            background:rgba(255,255,255,.15);

            backdrop-filter:blur(10px);

            border-radius:18px;

            padding:25px;

            text-align:center;

            color:white;

            box-shadow:0 10px 20px rgba(0,0,0,.2);

        }

        .summary-card .label{

            font-size:15px;

            opacity:.85;

            margin-bottom:10px;

        }

        .summary-card .value{

            font-size:40px;

            font-weight:bold;

        }

        .container {
            position: relative;
            z-index: 1;
        }

        .modal {
            z-index: 2000 !important;
        }

        .modal-backdrop {
            z-index: 1990 !important;
        }        

    </style>


    

</head>

<body>

<div class="container">

<a href="{{ route('dashboard') }}" class="dashboard-btn">
← Dashboard
</a>

<h1>Attendance Records</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
">

    <form method="GET" action="{{ route('attendance.index') }}" style="display:flex; gap:10px;">

        <input
            type="text"
            name="search"
            placeholder="Search member..."
            value="{{ request('search') }}"
            style="
                width:300px;
                padding:12px;
                border-radius:10px;
                border:none;
                font-size:15px;
            ">

        <button
            style="
                padding:12px 20px;
                border:none;
                border-radius:10px;
                background:#2563eb;
                color:white;
                font-weight:bold;
                cursor:pointer;
            ">
            Search
        </button>

    </form>

        <button
            type="button"
            data-bs-toggle="modal"
            data-bs-target="#manualAttendanceModal"
            style="
                padding:12px 20px;
                border:none;
                border-radius:10px;
                background:#16a34a;
                color:white;
                font-weight:bold;
                cursor:pointer;
            ">
            <i class="fas fa-user-check"></i>
            Manual Attendance
        </button>

</div>


<div class="summary-grid">

    <div class="summary-card">
        <div class="label">Today's Scans</div>
        <div class="value">{{ $todayScans }}</div>
    </div>

    <div class="summary-card">
        <div class="label">Currently Inside</div>
        <div class="value">{{ $insideNow }}</div>
    </div>

    <div class="summary-card">
        <div class="label">Time Outs Today</div>
        <div class="value">{{ $timeOuts }}</div>
    </div>

</div>

<table>

<tr>

<th>ID</th>
<th>Member</th>
<th>Date</th>
<th>Method</th>
<th>Time In</th>
<th>Time Out</th>
<th>Duration</th>
<th>Status</th>

</tr>

@foreach($attendances as $attendance)

<tr>

<td>{{ $attendance->id }}</td>

<td>{{ $attendance->member->full_name }}</td>

<td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('M d, Y') }}</td>

<td>
    @if($attendance->method == 'QR')
        <span class="badge bg-primary">QR</span>
    @else
        <span class="badge bg-success">Manual</span>
    @endif
</td>

<td>{{ $attendance->time_in }}</td>

<td>{{ $attendance->time_out ?? '-' }}</td>

<td>

@if($attendance->time_out)

{{ \Carbon\Carbon::parse($attendance->time_in)
    ->diff(\Carbon\Carbon::parse($attendance->time_out))
    ->format('%H hr %I min %S sec') }}

@else

-

@endif

</td>

<td>

@if($attendance->time_out)
    <span style="color:red;font-weight:bold;">🔴 Left</span>
@else
    <span style="color:green;font-weight:bold;">🟢 Inside</span>
@endif

</td>

</tr>

@endforeach

</table>

<br>

<div style="margin-top:25px;text-align:center;">

    @if($attendances->onFirstPage())
        <span style="padding:10px 16px;background:#ccc;border-radius:8px;">
            ← Previous
        </span>
    @else
        <a href="{{ $attendances->previousPageUrl() }}"
           class="dashboard-btn">
           ← Previous
        </a>
    @endif

    <span style="margin:0 20px;font-weight:bold;color:white;">
        Page {{ $attendances->currentPage() }}
        of
        {{ $attendances->lastPage() }}
    </span>

    @if($attendances->hasMorePages())
        <a href="{{ $attendances->nextPageUrl() }}"
           class="dashboard-btn">
           Next →
        </a>
    @else
        <span style="padding:10px 16px;background:#ccc;border-radius:8px;">
            Next →
        </span>
    @endif
</div>
</div>
<!-- Manual Attendance Modal -->
<div class="modal fade" id="manualAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
<form method="POST" action="{{ route('attendance.manual') }}">
    @csrf

    <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Manual Attendance</h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">

                <label class="form-label">
                    Search Member
                </label>

                <input
                    type="text"
                    id="memberSearch"
                    class="form-control"
                    placeholder="Search member..."
                    autocomplete="off">

                <input
                    type="hidden"
                    id="member_id"
                    name="member_id">

                <div id="memberResults" class="list-group mt-2"></div>

                <label class="form-label">
                    Attendance Type
                </label>

                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="attendance_type"
                        id="timeIn"
                        value="in"
                        checked>

                    <label class="form-check-label" for="timeIn">
                        Time In
                    </label>
                </div>

                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="radio"
                        name="attendance_type"
                        id="timeOut"
                        value="out">

                    <label class="form-check-label" for="timeOut">
                        Time Out
                    </label>
                </div>

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <button type="submit" class="btn btn-success">
                    Record Attendance
                </button>

            </div>

        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const searchInput = document.getElementById('memberSearch');
const resultsBox = document.getElementById('memberResults');
const memberId = document.getElementById('member_id');

searchInput.addEventListener('keyup', function () {

    let keyword = this.value.trim();

    if (keyword.length < 2) {
        resultsBox.innerHTML = '';
        return;
    }

    fetch("{{ route('attendance.searchMembers') }}?search=" + encodeURIComponent(keyword))
        .then(response => response.json())
        .then(data => {

            resultsBox.innerHTML = '';

            if (data.length === 0) {
                resultsBox.innerHTML =
                    '<div class="list-group-item">No member found.</div>';
                return;
            }

            data.forEach(member => {

                resultsBox.innerHTML += `
                    <button
                        type="button"
                        class="list-group-item list-group-item-action"
                        data-id="${member.id}"
                        data-name="${member.full_name}">
                        ${member.full_name}
                    </button>
                `;

            });

        });

});

resultsBox.addEventListener('click', function (e) {

    const button = e.target.closest('button');

    if (!button) return;

    searchInput.value = button.dataset.name;
    memberId.value = button.dataset.id;

    resultsBox.innerHTML = '';

});
</script>

</body>
</html>