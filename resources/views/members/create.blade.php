<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 750px;
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
        <h1>Add Member</h1>
        <p class="subtitle">Create a new gym member account.</p>

        <a href="{{ route('members.index') }}" class="btn btn-back">Back</a>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('members.store') }}" method="POST">
            @csrf

            <label>Full Name:</label>
            <input
                type="text"
                name="full_name"
                value="{{ old('full_name') }}"
                required
            >

            <label>Email:</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
            >

            <label>Password:</label>
            <input
                type="password"
                name="password"
                required
            >

            <label>Phone:</label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                required
            >

            <label>Address:</label>
            <input
                type="text"
                name="address"
                value="{{ old('address') }}"
                required
            >

            <label>Birth Date:</label>
            <input
                type="date"
                name="birth_date"
                value="{{ old('birth_date') }}"
                required
            >

            <label>Gender:</label>
            <select name="gender" required>
                <option value="">Select Gender</option>

                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                    Male
                </option>

                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                    Female
                </option>
            </select>

            <p class="note">
                This will create a member account and save the member profile.
            </p>

            <button type="submit" class="btn btn-submit">Save Member</button>
        </form>
    </div>
</body>
</html>