<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
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
                linear-gradient(rgba(15, 23, 42, 0.82), rgba(15, 23, 42, 0.82)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 760px;
            margin: auto;
            padding: 36px 24px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
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
            margin: 8px 0 26px;
            color: #e5e7eb;
            font-size: 14px;
        }

        .top-actions {
            margin-bottom: 18px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(107, 114, 128, 0.9);
            color: white;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid rgba(255,255,255,0.15);
        }

        .btn-back:hover {
            background: #4b5563;
        }

        .form-box {
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 18px;
            padding: 22px;
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
            color: #ffffff;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 12px 14px;
            border-radius: 9px;
            border: 1px solid rgba(203, 213, 225, 0.95);
            font-size: 14px;
            background: rgba(255,255,255,0.95);
            color: #111827;
            outline: none;
        }

        input:focus,
        select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.22);
        }

        .note {
            margin-top: 6px;
            color: #e5e7eb;
            font-size: 12px;
            line-height: 1.4;
        }

        .submit-btn {
            width: 100%;
            margin-top: 18px;
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

        @media (max-width: 768px) {
            body {
                padding: 18px 12px;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Member</h1>
        <p class="subtitle">Update member information below.</p>

        <div class="top-actions">
            <a href="{{ route('members.index') }}" class="btn-back">Back</a>
        </div>

        <div class="form-box">
            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('members.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $member->full_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $member->phone) }}">
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $member->address) }}">
                </div>

                <div class="form-group">
                    <label for="birth_date">Birth Date:</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date', $member->birth_date) }}">
                </div>

                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>

                    <div class="note">
                        Make sure all member information is correct before saving changes.
                    </div>
                </div>

                <button type="submit" class="submit-btn">Update Member</button>
            </form>
        </div>
    </div>
</body>
</html>