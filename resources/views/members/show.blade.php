<!DOCTYPE html>
<html>
<head>
    <title>Member Details</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 35px;
            color: #111827;
        }

        .container {
            max-width: 800px;
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
            font-weight: bold;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .details-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px;
            background: #f9fafb;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 190px 1fr;
            padding: 14px 0;
            border-bottom: 1px solid #e5e7eb;
            align-items: center;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: bold;
            color: #374151;
        }

        .value {
            color: #111827;
        }

        .trainer-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 7px 12px;
            border-radius: 999px;
            font-weight: bold;
            font-size: 13px;
        }

        .no-data {
            color: #6b7280;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 22px;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Member Details</h1>
        <p class="subtitle">View complete member information.</p>

        <div class="top-actions">
            <a href="{{ route('members.index') }}" class="btn btn-back">Back</a>
        </div>

        <div class="details-card">
            <div class="detail-row">
                <div class="label">Full Name:</div>
                <div class="value">{{ $member->full_name ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Email:</div>
                <div class="value">{{ $member->user->email ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Trainer:</div>
                <div class="value">
                    @if($member->trainer)
                        <span class="trainer-badge">{{ $member->trainer->name }}</span>
                    @else
                        <span class="no-data">No Trainer</span>
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="label">Phone:</div>
                <div class="value">{{ $member->phone ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Address:</div>
                <div class="value">{{ $member->address ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Birth Date:</div>
                <div class="value">{{ $member->birth_date ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Gender:</div>
                <div class="value">{{ $member->gender ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Registration Date:</div>
                <div class="value">
                    {{ $member->created_at ? $member->created_at->format('Y-m-d') : 'N/A' }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>