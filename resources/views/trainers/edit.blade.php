<!DOCTYPE html>
<html>
<head>
    <title>Edit Trainer</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 700px;
            margin: auto;
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
            margin-bottom: 20px;
        }

        .btn-submit {
            background: #2563eb;
            color: white;
            width: 100%;
            margin-top: 25px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 18px;
            margin-bottom: 7px;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .note {
            color: #6b7280;
            font-size: 13px;
            margin-top: 6px;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Trainer</h1>
        <p class="subtitle">Update trainer information below.</p>

        <a href="{{ route('trainers.index') }}" class="btn btn-back">Back</a>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('trainers.update', $trainer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Name:</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $trainer->name) }}"
                required
            >

            <label>Email:</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $trainer->email) }}"
                required
            >

            <label>Phone:</label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone', $trainer->phone) }}"
                required
            >

            <label>Specialization:</label>
            <select name="specialization" required>
                <option value="">Select Specialization</option>

                <option value="Cardio Training"
                    {{ old('specialization', $trainer->specialization) == 'Cardio Training' ? 'selected' : '' }}>
                    Cardio Training
                </option>

                <option value="Weight Loss"
                    {{ old('specialization', $trainer->specialization) == 'Weight Loss' ? 'selected' : '' }}>
                    Weight Loss
                </option>

                <option value="Strength Training"
                    {{ old('specialization', $trainer->specialization) == 'Strength Training' ? 'selected' : '' }}>
                    Strength Training
                </option>

                <option value="Flexibility / General Fitness"
                    {{ old('specialization', $trainer->specialization) == 'Flexibility / General Fitness' ? 'selected' : '' }}>
                    Flexibility / General Fitness
                </option>
            </select>

            <p class="note">
                Specialization affects the generated workout program for members.
            </p>

            <button type="submit" class="btn btn-submit">Update Trainer</button>
        </form>
    </div>
</body>
</html>