<!DOCTYPE html>
<html>
<head>
    <title>Edit Trainer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            padding: 35px 15px;
            color: #ffffff;
            background:
                linear-gradient(rgba(15, 23, 42, 0.84), rgba(15, 23, 42, 0.84)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 760px;
            margin: auto;
            padding: 34px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.28);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 34px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 10px 0 28px;
            color: #dbeafe;
            font-size: 15px;
        }

        .top-actions {
            margin-bottom: 24px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(15, 23, 42, 0.92);
            color: white;
            padding: 10px 18px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid rgba(255,255,255,0.18);
        }

        .btn-back:hover {
            background: #2563eb;
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        form {
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 16px;
            padding: 22px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.22);
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #ffffff;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid rgba(203, 213, 225, 0.95);
            border-radius: 9px;
            font-size: 14px;
            background: rgba(255,255,255,0.92);
            color: #111827;
            outline: none;
        }

        input:focus,
        select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.22);
        }

        .note {
            margin-top: 7px;
            color: #dbeafe;
            font-size: 13px;
            line-height: 1.4;
        }

        .submit-btn {
            width: 100%;
            margin-top: 10px;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            h1 {
                font-size: 28px;
            }

            form {
                padding: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Trainer</h1>
        <p class="subtitle">Update trainer information below.</p>

        <div class="top-actions">
            <a href="{{ route('trainers.index') }}" class="btn-back">Back</a>
        </div>

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('trainers.update', $trainer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label>Name:</label>
                <input type="text" name="name" value="{{ old('name', $trainer->name) }}" required>
            </div>

            <div class="field">
                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email', $trainer->email) }}" required>
            </div>

            <div class="field">
                <label>Phone:</label>
                <input type="text" name="phone" value="{{ old('phone', $trainer->phone) }}" required>
            </div>

            <div class="field">
                <label>Specialization:</label>
                <select name="specialization" required>
                    <option value="">Select Specialization</option>
                    <option value="Weight Loss" {{ old('specialization', $trainer->specialization) == 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                    <option value="Cardio Training" {{ old('specialization', $trainer->specialization) == 'Cardio Training' ? 'selected' : '' }}>Cardio Training</option>
                    <option value="Strength Training" {{ old('specialization', $trainer->specialization) == 'Strength Training' ? 'selected' : '' }}>Strength Training</option>
                    <option value="Flexibility / General Fitness" {{ old('specialization', $trainer->specialization) == 'Flexibility / General Fitness' ? 'selected' : '' }}>Flexibility / General Fitness</option>
                </select>

                <div class="note">
                    Specialization affects the generated workout program for members.
                </div>
            </div>

            <button type="submit" class="submit-btn">Update Trainer</button>
        </form>
    </div>
</body>
</html>