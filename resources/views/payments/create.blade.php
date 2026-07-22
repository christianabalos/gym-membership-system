<!DOCTYPE html>
<html>
<head>
    <title>Payments</title>
</head>
<body>
    <h1>Payments</h1>

    <a href="{{ route('payments.index') }}">
        <button type="button">Back</button>
    </a>

    <br><br>

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('payments.store') }}" method="POST">
        @csrf

        <label>Member:</label><br>
        <select name="member_id" required>
            <option value="">Select Member</option>
            @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->full_name }}</option>
            @endforeach
        </select>
        <br><br>

        <label>Membership:</label><br>
        <select name="membership_id">
            <option value="">No Membership</option>
            @foreach($memberships as $membership)
                <option value="{{ $membership->id }}">
                    {{ $membership->member->full_name ?? 'N/A' }} - {{ $membership->plan_name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Amount:</label><br>
        <input type="number" name="amount" step="0.01" required>
        <br><br>

        <label>Payment Method:</label><br>
        <select name="payment_method" required>
            <option value="cash">Cash</option>
            <option value="gcash">GCash</option>
            <option value="bank">Bank</option>
        </select>
        <br><br>

        <label>Status:</label><br>
        <select name="status" required>
            <option value="paid">Paid</option>
            <option value="pending">Pending</option>
            <option value="failed">Failed</option>
        </select>
        <br><br>

        <label>Payment Date:</label><br>
        <input type="date" name="payment_date" required>
        <br><br>

        <button type="submit">Save Payment</button>
    </form>
</body>
</html>
