<!DOCTYPE html>
<html>

<head>

<title>Payment History</title>

<style>

body{
font-family: DejaVu Sans;
font-size:12px;
}

h2{
text-align:center;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

table,th,td{
border:1px solid black;
}

th{
background:#eeeeee;
padding:8px;
}

td{
padding:6px;
}

</style>

</head>

<body>

<h2>Payment History</h2>

<p><strong>Member:</strong> {{ $member->full_name }}</p>

<table>

<tr>

<th>Date</th>
<th>Plan</th>
<th>Amount</th>
<th>Method</th>
<th>Status</th>

</tr>

@foreach($payments as $payment)

<tr>

<td>{{ $payment->payment_date }}</td>

<td>{{ optional($payment->membership)->plan_name }}</td>

<td>₱{{ number_format($payment->amount,2) }}</td>

<td>{{ ucfirst($payment->method) }}</td>

<td>{{ ucfirst($payment->status) }}</td>

</tr>

@endforeach

</table>

</body>

</html>