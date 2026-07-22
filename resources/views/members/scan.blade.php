<!DOCTYPE html>
<html>
<head>
    <title>Scan Member QR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        *{
            box-sizing:border-box;
            font-family:Arial,Helvetica,sans-serif;
        }

        body{
            margin:0;
            min-height:100vh;
            background:
            linear-gradient(rgba(15,23,42,.82),rgba(15,23,42,.82)),
            url("https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1600&q=80");
            background-size:cover;
            background-position:center;
            color:white;
        }

        .container{
            max-width:700px;
            margin:40px auto;
            padding:30px;
            background:rgba(255,255,255,.12);
            border-radius:20px;
            backdrop-filter:blur(15px);
            box-shadow:0 20px 40px rgba(0,0,0,.4);
        }

        h1{
            text-align:center;
            margin-bottom:10px;
        }

        p{
            text-align:center;
            color:#ddd;
        }

        #reader{
            margin:25px auto;
            max-width:500px;
            border-radius:15px;
            overflow:hidden;
            border:4px solid white;
        }

        .btn{
            display:inline-block;
            margin-top:20px;
            padding:12px 20px;
            background:#2563eb;
            color:white;
            text-decoration:none;
            border-radius:10px;
            font-weight:bold;
        }

        .btn:hover{
            background:#1d4ed8;
        }

        .back{
            background:#6b7280;
        }

        .back:hover{
            background:#4b5563;
        }

        .buttons{
            text-align:center;
            margin-top:20px;
        }

        #result{
            margin-top:20px;
            padding:20px;
            border-radius:15px;
            text-align:center;
            font-weight:bold;
            display:none;
            animation: pop .3s ease;
        }

        #memberCard{
            display:none;
            margin-top:20px;
            padding:20px;
            border-radius:15px;
            background:rgba(255,255,255,.15);
            backdrop-filter:blur(12px);
            border:1px solid rgba(255,255,255,.25);
            color:white;
            animation:pop .3s ease;
        }

        #memberCard h2{
            margin-top:0;
            text-align:center;
            margin-bottom:15px;
        }

        .member-row{
            display:flex;
            justify-content:space-between;
            margin:10px 0;
            border-bottom:1px solid rgba(255,255,255,.1);
            padding-bottom:8px;
        }

        .member-label{
            font-weight:bold;
            color:#ddd;
        }

        .member-value{
            text-align:right;
        }        

        @keyframes pop{

            from{
                transform: scale(.8);
                opacity: 0;
            }

            to{
                transform: scale(1);
                opacity: 1;
            }

        }

    </style>
</head>

<body>

<div class="container">

    <h1>📷 Scan Member QR Code</h1>

    <p>Point the camera at the member's QR Code.</p>

    <div id="reader"></div>

    <!-- Member Information -->
    <div id="memberCard" style="display:none;"></div>

    <!-- Attendance Result -->
    <div id="result"></div>

    <div class="buttons">
        <a href="{{ route('members.index') }}" class="btn back">← Back</a>
    </div>

    <audio id="successSound">
        <source src="{{ asset('sounds/success.mp3') }}" type="audio/mpeg">
    </audio>    

    <audio id="expiredSound">
        <source src="{{ asset('sounds/expired.mp3') }}" type="audio/mpeg">
    </audio>    

</div>

<script>

let alreadyScanning = false;

function onScanSuccess(decodedText) {

    if (alreadyScanning) return;

    alreadyScanning = true;

    document.getElementById("result").style.display = "block";
    document.getElementById("result").innerHTML = "Processing attendance...";

    // Extract member ID from URL
    let parts = decodedText.split('/');
    let memberId = parts[parts.length - 1];

    fetch("{{ route('attendance.scan') }}", {

        method: "POST",

        headers: {

            "Content-Type": "application/json",

            "X-CSRF-TOKEN": "{{ csrf_token() }}",

            "Accept": "application/json"

        },

        body: JSON.stringify({

            member_id: memberId

        })

    })

    .then(response => response.json())

            .then(data => {

        const result = document.getElementById("result");
            
        const memberCard = document.getElementById("memberCard");

        memberCard.style.display = "block";

        memberCard.innerHTML = `
            <h2>👤 Member Information</h2>

            <div class="member-row">
                <span class="member-label">Name</span>
                <span class="member-value">${data.member}</span>
            </div>

            <div class="member-row">
                <span class="member-label">Phone</span>
                <span class="member-value">${data.phone}</span>
            </div>

            <div class="member-row">
                <span class="member-label">Trainer</span>
                <span class="member-value">${data.trainer}</span>
            </div>

            <div class="member-row">
                <span class="member-label">Membership</span>
                <span class="member-value">${data.membership}</span>
            </div>

            <div class="member-row">
                <span class="member-label">Expires</span>
                <span class="member-value">${data.expires}</span>
            </div>
        `;        

        result.style.display = "block";

        // Green = Time In
        if(data.status == "in"){
            result.style.background = "#16a34a";
        }

        // Blue = Time Out
        else{
            result.style.background = "#2563eb";
        }

        result.style.display = "block";
        result.style.color = "white";

        // Membership Expired
        if (data.expired) {

            result.style.background = "#dc2626";

            result.innerHTML = `
                <h2>❌ MEMBERSHIP EXPIRED</h2>

                <h2>${data.member}</h2>

                <p><strong>Expired on:</strong><br>${data.expires}</p>

                <p>Please renew your membership at the front desk.</p>
            `;
            document.getElementById("expiredSound").play();
        }
        // Successful Scan
        else {

            if (data.status == "in") {
                result.style.background = "#16a34a";
            } else {
                result.style.background = "#2563eb";
            }

            let icon = data.status == "in"
                ? "🟢 TIME IN"
                : "🔵 TIME OUT";

            result.innerHTML = `
                <h2>${icon}</h2>

                <h2>${data.member}</h2>

                <p>${data.message}</p>

                <small>${data.time}</small>
            `;

            document.getElementById("successSound").play();
        }

        setTimeout(() => {

            alreadyScanning = false;

        },3000);

    })

    .catch(error => {

        const result = document.getElementById("result");

        result.style.display = "block";
        result.style.background = "#dc2626";
        result.style.color = "white";

        result.innerHTML = "❌ An error occurred.";

        alreadyScanning = false;

    });

}

    

let scanner=new Html5QrcodeScanner(
    "reader",
    {
        fps:10,
        qrbox:250
    }
);

scanner.render(onScanSuccess);

</script>

</body>
</html>