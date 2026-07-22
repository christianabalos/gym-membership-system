<!DOCTYPE html>
<html>
<head>
    <title>Edit Payment</title>
</head>
<body>
    <h1>Edit Payment</h1>

    <a href="{{ route('payments.index') }}">Back</a>

    <br><br>

    @if ($errors->any())
        <div style="color: red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Member:</label><br>
        <input type="text" value="{{ $payment->member->full_name ?? 'N/A' }}" readonly>
        <input type="hidden" name="member_id" value="{{ $payment->member_id }}">
        <br><br>

        <label>Membership:</label><br>
        <select name="membership_id" id="membership_id" required>
            <option value="">Select Membership</option>

            @foreach($memberships as $membership)
                @if($membership->member_id == $payment->member_id)
                    <option 
                        value="{{ $membership->id }}"
                        data-price="{{ $membership->price }}"
                        {{ old('membership_id', $payment->membership_id) == $membership->id ? 'selected' : '' }}
                    >
                        {{ $membership->plan_name }} - ₱{{ number_format($membership->price, 2) }}
                    </option>
                @endif
            @endforeach
        </select>
        <br><br>

        <label>Amount:</label><br>
        <input type="number" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}" readonly>
        <br><br>

        <label>Payment Method:</label><br>

        @if(strtolower($payment->payment_method) === 'online' || strtolower($payment->payment_method) === 'online payment')
            <input type="text" value="Online Payment" readonly>
            <input type="hidden" name="payment_method" value="online">
        @else
            <select name="payment_method" required>
                <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="online" {{ old('payment_method', $payment->payment_method) == 'online' ? 'selected' : '' }}>Online Payment</option>
            </select>
        @endif

        <br><br>

        <label>Status:</label><br>

        @if(strtolower($payment->payment_method) === 'online' || strtolower($payment->payment_method) === 'online payment')
            <input type="text" value="Paid" readonly>
            <input type="hidden" name="status" value="paid">
        @else
            <select name="status" required>
                <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ old('status', $payment->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        @endif

        <br><br>

        <label>Payment Date:</label><br>
        <input 
            type="date" 
            name="payment_date" 
            value="{{ old('payment_date', $payment->payment_date) }}" 
            required
        >
        <br><br>

        <button type="submit">Update Payment</button>
    </form>

    <script>
        function updateAmount() {
            const membershipSelect = document.getElementById('membership_id');
            const amountInput = document.getElementById('amount');

            const selectedOption = membershipSelect.options[membershipSelect.selectedIndex];
            const price = selectedOption.getAttribute('data-price');

            if (price) {
                amountInput.value = price;
            } else {
                amountInput.value = '';
            }
        }

        document.getElementById('membership_id').addEventListener('change', updateAmount);
        updateAmount();
    </script>
</body>
</html>
