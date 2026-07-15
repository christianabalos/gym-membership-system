<!DOCTYPE html>
<html>
<head>
    <title>Member Details</title>
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

        .details-box {
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 18px;
            padding: 22px;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.16);
            align-items: center;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: 800;
            color: #ffffff;
            font-size: 14px;
        }

        .value {
            color: #f9fafb;
            font-size: 14px;
            font-weight: 600;
        }

        .trainer-badge {
            display: inline-block;
            background: rgba(219, 234, 254, 0.95);
            color: #1d4ed8;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .no-trainer {
            display: inline-block;
            background: rgba(255, 255, 255, 0.18);
            color: #e5e7eb;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 24px 16px;
            }

            h1 {
                font-size: 28px;
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
            <a href="{{ route('members.index') }}" class="btn-back">Back</a>
        </div>

        <div class="details-box">
            <div class="detail-row">
                <div class="label">Full Name:</div>
                <div class="value">{{ $member->full_name }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Email:</div>
                <div class="value">{{ $member->user->email ?? $member->email ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="label">Trainer:</div>
                <div class="value">
                    @php
                        $latestMembership = $member->memberships
                            ? $member->memberships->sortByDesc('created_at')->first()
                            : null;

                        $trainer = $member->trainer ?? ($latestMembership->trainer ?? null);
                    @endphp

                    @if($trainer)
                        <span class="trainer-badge">{{ $trainer->name }}</span>
                    @else
                        <span class="no-trainer">No Trainer</span>
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
                <div class="value">
                    {{ $member->birth_date ? \Carbon\Carbon::parse($member->birth_date)->format('Y-m-d') : 'N/A' }}
                </div>
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