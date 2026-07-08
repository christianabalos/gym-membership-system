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
            max-width: 650px;
            margin: 55px auto;
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
            margin-bottom: 28px;
        }

        .top-actions {
            margin-bottom: 22px;
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
        }

        .btn-submit {
            width: 100%;
            background: #111827;
            color: white;
            padding: 13px;
            margin-top: 18px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font-size: 14px;
            box-sizing: border-box;
            margin-bottom: 14px;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .hint {
            color: #6b7280;
            font-size: 13px;
            margin-top: -7px;
            margin-bottom: 14px;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .error-box p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Send Request to Admin</h1>
        <p class="subtitle">Write your concern or request and wait for admin response.</p>

        <div class="top-actions">
    <a href="{{ route('member.dashboard') }}" class="btn btn-back">Back</a>
</div>

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('member.requests.store') }}" method="POST" novalidate>
            @csrf

            <label>Subject:</label>
            <input
                type="text"
                name="subject"
                value="{{ old('subject') }}"
                placeholder="Example: Change schedule request"
            >

            <p class="hint">Use a short title for your request.</p>

            <label>Message:</label>
            <textarea
                name="message"
                placeholder="Type your request here..."
            >{{ old('message') }}</textarea>

            <p class="hint">Include important details like schedule, payment, membership, or trainer concern.</p>

            <button type="submit" class="btn btn-submit">Send Request</button>
        </form>
    </div>
</body>
</html>