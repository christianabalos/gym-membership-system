<!DOCTYPE html>
<html>
<head>
    <title>Generate Workout Schedule</title>
</head>
<body>
    <h1>Generate Next Weekly Workout Schedule</h1>

    <a href="{{ route('workouts.index') }}">
        <button type="button">Back</button>
    </a>

    <br><br>

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('workouts.generate.store') }}" method="POST">
        @csrf

        <label>Member:</label><br>
        <select name="member_id" required>
            <option value="">Select Member</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->full_name }}</option>
            @endforeach
        </select>
        <br><br>

     <p style="color: green; font-weight: bold;">
    Trainer will be automatically based on the member's active membership.
</p>
<br>
        <label>Start Date:</label><br>
        <input type="date" name="start_date" required>
        <p>
    Note: Week 1 is automatically generated when the member registers membership.
    Use this page to generate Week 2, Week 3, or additional weekly schedules.
</p>

        <label>Workout Time:</label><br>
        <input type="time" name="workout_time" required>
        <br><br>

        <h3>Generated Schedule Preview</h3>

        <table border="1" cellpadding="10">
            <tr>
                <th>Day</th>
                <th>Workout Type</th>
                <th>Workout Name</th>
                <th>Description</th>
            </tr>
            <tr>
                <td>Monday</td>
                <td>Chest + Triceps</td>
                <td>Push Day Workout</td>
                <td>Bench press, incline press, chest fly, tricep pushdown, dips.</td>
            </tr>
            <tr>
                <td>Tuesday</td>
                <td>Back + Biceps</td>
                <td>Pull Day Workout</td>
                <td>Lat pulldown, seated row, deadlift, bicep curls, hammer curls.</td>
            </tr>
            <tr>
                <td>Wednesday</td>
                <td>Legs</td>
                <td>Leg Day Workout</td>
                <td>Squats, lunges, leg press, hamstring curls, calf raises.</td>
            </tr>
            <tr>
                <td>Thursday</td>
                <td>Shoulders + Core</td>
                <td>Shoulder and Core Workout</td>
                <td>Shoulder press, lateral raises, front raises, planks, crunches.</td>
            </tr>
            <tr>
                <td>Friday</td>
                <td>Full Body</td>
                <td>Full Body Strength Workout</td>
                <td>Push-ups, squats, rows, dumbbell press, burpees, mountain climbers.</td>
            </tr>
            <tr>
                <td>Saturday</td>
                <td>Cardio + Abs</td>
                <td>Cardio and Abs Workout</td>
                <td>Treadmill, jumping jacks, bicycle crunches, leg raises, plank.</td>
            </tr>
            <tr>
                <td>Sunday</td>
                <td>Rest Day</td>
                <td>Recovery Day</td>
                <td>Rest, stretching, hydration, light walking, and muscle recovery.</td>
            </tr>
        </table>

        <br>

        <button type="submit">Generate Weekly Schedule</button>
    </form>
</body>
</html>