<!DOCTYPE html>
<html>
<head>
    <title>Add Workout</title>
</head>
<body>
    <h1>Add Workout</h1>

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

    <form action="{{ route('workouts.store') }}" method="POST">
        @csrf

        <label>Member:</label><br>
        <select name="member_id" required>
            <option value="">Select Member</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->full_name }}</option>
            @endforeach
        </select>
        <br><br>

        <label>Trainer:</label><br>
        <select name="trainer_id">
            <option value="">No Trainer</option>
            @foreach($trainers as $trainer)
                <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
            @endforeach
        </select>
        <br><br>

        <label>Workout Type:</label><br>
        <select name="workout_type" required>
            <option value="">Select Workout Type</option>
            <option value="Chest">Chest</option>
            <option value="Back">Back</option>
            <option value="Biceps">Biceps</option>
            <option value="Triceps">Triceps</option>
            <option value="Shoulders">Shoulders</option>
            <option value="Legs">Legs</option>
            <option value="Core / Abs">Core / Abs</option>
            <option value="Cardio">Cardio</option>
            <option value="Full Body">Full Body</option>
        </select>
        <br><br>

        <label>Workout Name:</label><br>
        <input type="text" name="workout_name" required>
        <br><br>

        <label>Description:</label><br>
        <textarea name="description"></textarea>
        <br><br>

        <label>Workout Date:</label><br>
        <input type="date" name="workout_date" required>
        <br><br>

        <label>Workout Time:</label><br>
        <input type="time" name="workout_time" required>
        <br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="scheduled">Scheduled</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <br><br>

        <button type="submit">Save Workout</button>
    </form>
</body>
</html>
