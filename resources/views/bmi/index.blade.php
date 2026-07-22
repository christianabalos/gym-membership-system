<!DOCTYPE html>
<html>
<head>
    <title>BMI Calculator</title>
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
            max-width: 650px;
            margin: 70px auto;
            padding: 36px 34px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 18px 45px rgba(0,0,0,0.35);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 36px;
            font-weight: 900;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .subtitle {
            text-align: center;
            margin: 10px 0 28px;
            color: #dbeafe;
            font-size: 15px;
            font-weight: 600;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 13px;
            font-weight: 800;
            transition: 0.2s ease;
            text-align: center;
        }

        .btn:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .btn-back {
            background: rgba(107, 114, 128, 0.92);
            color: #ffffff;
        }

        .form-card {
            padding: 24px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.20);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #ffffff;
            font-size: 14px;
            font-weight: 900;
        }

        .form-group {
            margin-bottom: 18px;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border-radius: 11px;
            border: 1px solid rgba(203, 213, 225, 0.95);
            background: rgba(255, 255, 255, 0.95);
            color: #111827;
            font-size: 14px;
            outline: none;
        }

        input:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.25);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 11px;
            background: #2563eb;
            color: white;
            font-weight: 900;
            cursor: pointer;
            font-size: 15px;
            transition: 0.2s ease;
        }

        .submit-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        .error-box {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: 800;
        }

        .result-box {
            margin-top: 22px;
            padding: 22px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.95);
            color: #111827;
            border-left: 6px solid #2563eb;
            box-shadow: 0 10px 25px rgba(0,0,0,0.20);
        }

        .result-box h2 {
            margin: 0 0 14px;
            font-size: 24px;
            color: #0f172a;
        }

        .result-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .result-item {
            padding: 14px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            text-align: center;
        }

        .result-label {
            margin: 0 0 8px;
            color: #475569;
            font-size: 13px;
            font-weight: 900;
        }

        .result-value {
            margin: 0;
            color: #111827;
            font-size: 22px;
            font-weight: 900;
        }

        .category {
            color: #2563eb;
        }

        @media (max-width: 650px) {
            body {
                padding: 18px 12px;
            }

            .container {
                margin: 25px auto;
                padding: 24px 16px;
            }

            h1 {
                font-size: 30px;
            }

            .top-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .result-grid {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            body {
                background: white !important;
                color: #111827 !important;
                padding: 0;
            }

            .container {
                max-width: 100%;
                margin: 0;
                box-shadow: none;
                border: none;
                background: white !important;
                backdrop-filter: none;
            }

            .top-actions,
            .submit-btn {
                display: none;
            }

            h1,
            .subtitle,
            label {
                color: #111827 !important;
                text-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>BMI Calculator</h1>
        <p class="subtitle">Enter your age, weight, and height to calculate your BMI.</p>

        <div class="top-actions">
            <a href="{{ route('dashboard') }}" class="btn btn-back">Back</a>
        </div>

        <div class="form-card">
            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('bmi.calculate') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="age">Age:</label>
                    <input
                        type="number"
                        id="age"
                        name="age"
                        value="{{ old('age', $age ?? '') }}"
                        placeholder="Enter your age"
                        min="1"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="weight">Weight in kg:</label>
                    <input
                        type="number"
                        id="weight"
                        name="weight"
                        value="{{ old('weight', $weight ?? '') }}"
                        placeholder="Example: 60"
                        min="1"
                        step="0.01"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="height">Height in cm:</label>
                    <input
                        type="number"
                        id="height"
                        name="height"
                        value="{{ old('height', $height ?? '') }}"
                        placeholder="Example: 165"
                        min="1"
                        step="0.01"
                        required
                    >
                </div>

                <button type="submit" class="submit-btn">Calculate BMI</button>
            </form>

            @if(isset($bmi))
                <div class="result-box">
                    <h2>BMI Result</h2>

                    <div class="result-grid">
                        <div class="result-item">
                            <p class="result-label">Your BMI</p>
                            <p class="result-value">{{ number_format($bmi, 2) }}</p>
                        </div>

                        <div class="result-item">
                            <p class="result-label">Category</p>
                            <p class="result-value category">{{ $category ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>