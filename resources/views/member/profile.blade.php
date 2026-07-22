<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
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

        h1{
            text-align:center;
            margin-bottom:30px;
        }

        .form-group{
            margin-bottom:28px;
        }

        label{
            display:block;
            font-weight:bold;
            margin-bottom:6px;
        }

        input,
        textarea,
        select{
            width:100%;
            padding:10px;
            border:1px solid #ccc;
            border-radius:8px;
            font-size:15px;
        }

        textarea{
            resize:vertical;
        }

        .checkbox{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .checkbox input{
            width:auto;
        }

        .buttons{
            display:flex;
            justify-content:space-between;
            margin-top:30px;
        }

        .btn{
            text-decoration:none;
            padding:12px 20px;
            border-radius:8px;
            color:white;
            border:none;
            cursor:pointer;
            font-size:15px;
        }

        .save{
            background:#16a34a;
        }

        .back{
            background:#2563eb;
        }

        .alert{
            padding:15px;
            background:#dcfce7;
            color:#166534;
            border-radius:8px;
            margin-bottom:20px;
        }

        .password-wrapper{
            position:relative;
        }

        .password-wrapper{
            position:relative;
        }

        .password-wrapper input{
            width:100%;
            height:52px;
            padding:0 50px 0 15px;
            border:none;
            border-radius:12px;
            background:#fff;
            font-size:16px;
        }

        .toggle-password{
            position:absolute;
            right:18px;
            top:50%;
            transform:translateY(-50%);
            cursor:pointer;
            font-size:20px;
            color:#6b7280;
            transition:.2s;
        }

        .toggle-password:hover{
            color:#2563eb;
        }

        .password-strength{
            margin-top:8px;
            font-size:13px;
            font-weight:bold;
        }

        .strength-bar{
            width:100%;
            height:8px;
            background:#374151;
            border-radius:8px;
            margin-top:8px;
            overflow:hidden;
        }

        .strength-fill{
            width:0%;
            height:100%;
            background:#ef4444;
            border-radius:8px;
            transition:0.3s;
        }

        .strength-weak{
            color:#ef4444;
        }

        .strength-medium{
            color:#f59e0b;
        }

        .strength-strong{
            color:#22c55e;
        }

        .error-text{
            color:#fecaca;
            font-size:13px;
            margin-top:5px;
        }        

        .password-toggle{

            display:flex;
            justify-content:space-between;
            align-items:center;

            padding:18px 24px;

            border-radius:14px;

            background:rgba(255,255,255,.12);

            border:1px solid rgba(255,255,255,.15);

            transition:.25s;
        }

        .password-toggle:hover{
            background:rgba(255,255,255,.20);
        }

        .password-toggle span:first-child{
            font-size:20px;
            font-weight:bold;
        }

        #passwordArrow{
            font-size:24px;
            transition:.25s ease;
        }
        #passwordSection{
            display:none;
            margin-top:20px;
        }

        .password-content{
            max-width:850px;
            margin:25px auto 0;
        }        

    </style>
</head>

<body>

<div class="container">

    <h1>My Profile</h1>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('member.profile.update') }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Full Name</label>
            <input
                type="text"
                name="full_name"
                value="{{ old('full_name',$member->full_name) }}">
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone',$member->phone) }}">
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address">{{ old('address',$member->address) }}</textarea>
        </div>

        <div class="form-group">
            <label>Birth Date</label>
            <input
                type="date"
                name="birth_date"
                value="{{ old('birth_date',$member->birth_date) }}">
        </div>

        <div class="form-group">
            <label>Gender</label>

            <select name="gender">

                <option value="Male"
                    {{ $member->gender=='Male' ? 'selected' : '' }}>
                    Male
                </option>

                <option value="Female"
                    {{ $member->gender=='Female' ? 'selected' : '' }}>
                    Female
                </option>

            </select>

        </div>

        <hr>

        <h2>Health Information</h2>

        <div class="form-group">
            <label>Health Declaration</label>

            <textarea
                name="health_declaration">{{ old('health_declaration',$member->health_declaration) }}</textarea>
        </div>

        <div class="checkbox">

            <input
                type="checkbox"
                name="no_health_issue"
                value="1"
                {{ $member->no_health_issue ? 'checked' : '' }}>

            <label>No Health Issues</label>

        </div>

        <hr>

        <h2>Emergency Contact</h2>

        <div class="form-group">
            <label>Name</label>

            <input
                type="text"
                name="emergency_name"
                value="{{ old('emergency_name',$member->emergency_name) }}">
        </div>

        <div class="form-group">
            <label>Relationship</label>

            <input
                type="text"
                name="emergency_relationship"
                value="{{ old('emergency_relationship',$member->emergency_relationship) }}">
        </div>

        <div class="form-group">
            <label>Phone</label>

            <input
                type="text"
                name="emergency_phone"
                value="{{ old('emergency_phone',$member->emergency_phone) }}">
        </div>

        <hr>



        <div class="password-toggle"
            onclick="togglePasswordSection()">

            <span>🔒 Change Password</span>

            <span id="passwordArrow">▼</span>

        </div>

        <div id="passwordSection" class="password-content">

        <div class="form-group">
            <label>Current Password</label>

            <div class="password-wrapper">
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    placeholder="Enter current password">

                <span class="toggle-password"
                    onclick="togglePassword('current_password', this)">
                    👁
                </span>
            </div>

            @error('current_password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>New Password</label>

            <div class="password-wrapper">
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Minimum 8 characters">

                <span class="toggle-password"
                    onclick="togglePassword('password', this)">
                    👁
                </span>
            </div>

            <div id="strength" class="password-strength"></div>

            <div class="strength-bar">
                <div id="strengthFill" class="strength-fill"></div>
            </div>

            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
            </div>

        <div class="form-group">
            <label>Confirm Password</label>

            <div class="password-wrapper">
                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Confirm password">

                <span class="toggle-password"
                    onclick="togglePassword('password_confirmation', this)">
                    👁
                </span>
            </div>
        </div>

        </div> <!-- CLOSE passwordSection HERE -->

        <div class="buttons">

            <a href="{{ route('member.dashboard') }}" class="btn back">
                ← Back
            </a>

            <button type="submit" class="btn save">
                Save Changes
            </button>

        </div>

    </form>

</div>


    <script>
        function togglePassword(id, icon){

            const input = document.getElementById(id);

            if(input.type === "password"){
                input.type = "text";
                icon.textContent = "🙈";
            }else{
                input.type = "password";
                icon.textContent = "👁";
            }
        }

        const password = document.getElementById("password");
        const strength = document.getElementById("strength");
        const strengthFill = document.getElementById("strengthFill");

        password.addEventListener("input", function(){

            const value = this.value;

            if(value.length === 0){

                strength.textContent = "";

                strengthFill.style.width = "0%";

                return;

            }

            let score = 0;

            if(value.length >= 8) score++;
            if(/[A-Z]/.test(value)) score++;
            if(/[0-9]/.test(value)) score++;
            if(/[^A-Za-z0-9]/.test(value)) score++;

            if(score <= 1){

                strength.className = "password-strength strength-weak";
                strength.textContent = "🔴 Weak Password";

                strengthFill.style.width = "33%";
                strengthFill.style.background = "#ef4444";

            }else if(score <= 3){

                strength.className = "password-strength strength-medium";
                strength.textContent = "🟡 Medium Password";

                strengthFill.style.width = "66%";
                strengthFill.style.background = "#f59e0b";

            }else{

                strength.className = "password-strength strength-strong";
                strength.textContent = "🟢 Strong Password";

                strengthFill.style.width = "100%";
                strengthFill.style.background = "#22c55e";

            }
        });
    </script>

 
    <script>
        function togglePasswordSection() {

            const section = document.getElementById("passwordSection");
            const arrow = document.getElementById("passwordArrow");

            if (section.style.display === "none" || section.style.display === "") {
                section.style.display = "block";
                arrow.style.transform = "rotate(180deg)";
            } else {
                section.style.display = "none";
                arrow.style.transform = "rotate(0deg)";
            }

        }
    </script>
       
</body>
</html>