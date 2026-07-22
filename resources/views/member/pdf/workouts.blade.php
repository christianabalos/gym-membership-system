<!DOCTYPE html>
<html>
<head>
    <title>Workout Schedule</title>

    <style>
        body{
            font-family: DejaVu Sans;
            font-size:12px;
        }

        h2{
            text-align:center;
            margin-bottom:5px;
        }

        p{
            margin:3px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table,th,td{
            border:1px solid black;
        }

        th{
            background:#eeeeee;
            padding:8px;
        }

        td{
            padding:6px;
        }
    </style>

</head>
<body>

<h2>Workout Schedule</h2>

<p><strong>Member:</strong> {{ $member->full_name }}</p>

<table>

<tr>
    <th>Date</th>
    <th>Time</th>
    <th>Workout</th>
    <th>Type</th>
    <th>Trainer</th>
    <th>Status</th>
</tr>

@foreach($workouts as $workout)

<tr>

<td>{{ $workout->workout_date }}</td>

<td>{{ $workout->workout_time }}</td>

<td>{{ $workout->workout_name }}</td>

<td>{{ $workout->workout_type }}</td>

<td>{{ optional($workout->trainer)->name }}</td>

<td>{{ ucfirst($workout->status) }}</td>

</tr>

@endforeach

</table>

</body>
</html>