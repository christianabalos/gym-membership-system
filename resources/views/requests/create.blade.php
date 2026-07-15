<!DOCTYPE html>
<html>
<head>
    <title>Send Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 35px 15px;
            min-height: 100vh;
            color: #ffffff;
            background:
                linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.78)),
                url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .container {
            max-width: 650px;
            margin: auto;
            padding: 36px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.30);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.38);
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
            margin-top: 10px;
            margin-bottom: 30px;
            color: #dbeafe;
            font-size: 15px;
        }

        .btn-back {
            display: inline-block;
            background: rgba(107, 114, 128, 0.95);
            color: white;
            padding: 10px 16px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        label {
            display: block;
            margin-top: 16px;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
            color: #ffffff;
        }

        input,
        textarea {
            width: 100%;
            padding: 13px 14px;
            border-radius: 10px;
            border: 1px solid rgba(203, 213, 225, 0.95);
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            font-size: 14px;
            outline: none;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.25);
        }

        .note {
            margin-top: 6px;
            color: #dbeafe;
            font-size: 12px;
        }

        .submit-btn {
            width: 100%;
            margin-top: 25px;
            padding: 14px;
            border: none;
            border-radius: 11px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .success {
            background: rgba(220, 252, 231, 0.95);
            color: #166534;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 24px;
            }

            h1 {
                font-size: 29px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Send Request</h1>
        <p class="subtitle">Send your concern to the admin and wait for response.</p>

       <a href="{{ url('/member/requests') }}" class="btn-back">Back</a>

        @if(session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ url('/member/requests') }}" method="POST">
            @csrf

            <label>Subject:</label>
            <input
                type="text"
                name="subject"
                value="{{ old('subject') }}"
                placeholder="Example: Change schedule request"
                required
            >

            <div class="note">
                Use a short title for your request.
            </div>

            <label>Message:</label>
            <textarea
                name="message"
                placeholder="Type your request here..."
                required
            >{{ old('message') }}</textarea>

            <div class="note">
                Include important details like schedule, payment, membership, or trainer concern.
            </div>

            <button type="submit" class="submit-btn">Send Request</button>
        </form>
    </div>
</body>
</html>