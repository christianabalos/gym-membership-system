<!DOCTYPE html>
<html>
<head>
    <title>Send Request</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 620px;
            margin: 45px auto;
            background: white;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 32px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 28px;
        }

        .top-actions {
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .btn-primary {
            width: 100%;
            background: #111827;
            color: white;
            margin-top: 20px;
            padding: 12px;
            font-weight: bold;
        }

        .btn:hover {
            opacity: 0.9;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 11px;
            margin-top: 6px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            box-sizing: border-box;
            font-size: 14px;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .note {
            font-size: 13px;
            color: #6b7280;
            margin-top: 6px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
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
        <h1>Send Request to Admin</h1>
        <p class="subtitle">Write your concern or request and wait for admin response.</p>

        <div class="top-actions">
            <a href="{{ route('member.requests') }}" class="btn btn-back">Back</a>
        </div>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('member.requests.store') }}" method="POST">
            @csrf

            <label>Subject:</label>
            <input
                type="text"
                name="subject"
                value="{{ old('subject') }}"
                placeholder="Example: Change schedule request"
                required
            >

            <p class="note">Use a short title for your request.</p>

            <label>Message:</label>
            <textarea
                name="message"
                placeholder="Type your request here..."
                required
            >{{ old('message') }}</textarea>

            <p class="note">
                Include important details like schedule, payment, membership, or trainer concern.
            </p>

            <button type="submit" class="btn btn-primary">Send Request</button>
        </form>
    </div>
</body>
</html>