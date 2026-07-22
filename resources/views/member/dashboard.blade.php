<!DOCTYPE html>
<html>
<head>
    <title>Member Dashboard</title>
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
            max-width: 1050px;
            margin: auto;
            padding: 38px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.17);
            border: 1px solid rgba(255, 255, 255, 0.30);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.38);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .badge-wrap {
            text-align: center;
            margin-bottom: 14px;
        }

        .badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.25);
            color: #dbeafe;
            border: 1px solid rgba(147, 197, 253, 0.45);
            font-size: 13px;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            margin: 0;
            font-size: 38px;
            font-weight: 800;
            color: #ffffff;
            text-shadow: 0 3px 12px rgba(0,0,0,0.45);
        }

        .welcome {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 32px;
            color: #dbeafe;
            font-size: 17px;
        }

        .profile-header{
            text-align:center;
            margin-bottom:30px;
        }

        .profile-avatar{
            width:110px;
            height:110px;
            border-radius:50%;
            object-fit:cover;
            border:4px solid rgba(255,255,255,.9);
            box-shadow:0 10px 25px rgba(0,0,0,.35);
            transition:.25s;
            cursor:pointer;
        }

        .profile-avatar:hover{
            transform:scale(1.05);
        }

        .profile-name{
            margin:15px 0 5px;
            font-size:24px;
            font-weight:800;
            color:#fff;
        }

        .profile-link{
            color:#93c5fd;
            text-decoration:none;
            font-weight:bold;
        }

        .profile-link:hover{
            text-decoration:underline;
        }        

        /* --- QR CARD STYLES --- */
        .qr-card-container {
            max-width: 350px; 
            margin: 0 auto 40px auto; 
            background: rgba(255, 255, 255, 0.08); 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            border-radius: 18px; 
            padding: 25px 20px; 
            text-align: center; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.25); 
            backdrop-filter: blur(10px);
        }
        
        .qr-pass-label {
            font-size: 11px; 
            text-transform: uppercase; 
            letter-spacing: 2px; 
            color: #a5f3fc; 
            font-weight: bold; 
            display: block; 
            margin-bottom: 5px;
        }

        .qr-member-name {
            margin: 0 0 15px 0; 
            font-size: 20px; 
            font-weight: 800; 
            color: #ffffff;
        }

        .qr-image-wrapper {
            background: white; 
            padding: 12px; 
            display: inline-block; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .qr-instructions {
            font-size: 12px; 
            color: #dbeafe; 
            margin: 15px 0 0 0;
        }
        /* ------------------------ */

        .module-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .module-card {
            background: rgba(255, 255, 255, 0.92);
            color: #111827;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.18);
            border-left: 6px solid #2563eb;
            transition: 0.2s ease;
        }

        .module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 30px rgba(0,0,0,0.25);
        }

        .module-title {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 10px;
            color: #0f172a;
        }

        .module-desc {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.5;
            min-height: 44px;
            margin-bottom: 18px;
        }

        .module-btn {
            display: inline-block;
            width: 100%;
            text-align: center;
            padding: 12px 16px;
            background: #0f172a;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 14px;
            transition: 0.2s ease;
        }

        .module-btn:hover {
            background: #2563eb;
        }

        .logout-area {
            text-align: center;
            margin-top: 30px;
        }

        .logout-btn {
            padding: 12px 30px;
            border: none;
            border-radius: 10px;
            background: #dc2626;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 8px 18px rgba(220, 38, 38, 0.35);
        }

        .logout-btn:hover {
            background: #b91c1c;
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            .container {
                padding: 24px;
            }

            h1 {
                font-size: 30px;
            }

            .module-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="profile-header">

            <a href="{{ route('member.profile') }}">
                <img
                    src="{{ auth()->user()->member && auth()->user()->member->profile_photo
                        ? asset('storage/' . auth()->user()->member->profile_photo)
                        : asset('images/default-avatar.png') }}"
                    alt="Profile"
                    class="profile-avatar">
            </a>

            <div class="profile-name">
                {{ auth()->user()->name }}
            </div>

            <a href="{{ route('member.profile') }}" class="profile-link">
                ✏ Edit Profile
            </a>

        </div>

            <h1>Member Dashboard</h1>
        <div class="qr-card-container">
            <span class="qr-pass-label">
                Official Gym Pass
            </span>
            <h3 class="qr-member-name">
                {{ auth()->user()->name ?? 'Member Pass' }}
            </h3>

            <div class="qr-image-wrapper">
                @if(auth()->check() && auth()->user()->member)
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('members.show', auth()->user()->member->id)) }}" 
                         alt="Member QR Code" 
                         style="display: block;"
                    >
                @else
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(url('/profile/' . auth()->id())) }}" 
                         alt="User QR Code" 
                         style="display: block;"
                    >
                @endif
            </div>

            <p class="qr-instructions">
            </p>
        </div>
        <div class="module-grid">
            <div class="module-card">
                <div class="module-title">Register Membership</div>
                <div class="module-desc">
                    Apply for a gym membership plan.
                </div>
                <a href="{{ route('member.registerMembership') }}" class="module-btn">Open</a>
            </div>

            <div class="module-card">
                <div class="module-title">View Schedules</div>
                <div class="module-desc">
                    View your workout and training schedules.
                </div>
                <a href="{{ route('member.schedules') }}" class="module-btn">Open</a>
            </div>

            <div class="module-card">
                <div class="module-title">Track Payments</div>
                <div class="module-desc">
                    Check your payment records and status.
                </div>
                <a href="{{ route('member.payments') }}" class="module-btn">Open</a>
            </div>

            <div class="module-card">
                <div class="module-title">BMI Calculator</div>
                <div class="module-desc">
                    Calculate your Body Mass Index.
                </div>
                <a href="{{ route('member.bmi') }}" class="module-btn">Open</a>
            </div>

            <div class="module-card">
                <div class="module-title">My Requests</div>
                <div class="module-desc">
                    View your sent requests or concerns.
                </div>
                <a href="{{ url('/member/requests') }}" class="module-btn">Open</a>
            </div>

            <div class="module-card">
                <div class="module-title">Send Request</div>
                <div class="module-desc">
                    Send a concern to the admin.
                </div>
                <a href="{{ url('/member/requests/create') }}" class="module-btn">Open</a>
            </div>
        </div>

        <div class="logout-area">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>