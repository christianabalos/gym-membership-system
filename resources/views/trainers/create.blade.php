<!DOCTYPE html>
<html>
<head>
    <title>Add Member</title>
</head>
<body>
    <h1>Add Member</h1>

    <a href="{{ route('members.index') }}">
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

    <form action="{{ route('members.store') }}" method="POST">
        @csrf

        <label>Full Name:</label><br>
        <input type="text" name="full_name" value="{{ old('full_name') }}" required>
        <br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required>
        <br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required>
        <br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" value="{{ old('phone') }}">
        <br><br>

        <label>Address:</label><br>
        <input type="text" name="address" value="{{ old('address') }}">
        <br><br>

        <label>Birth Date:</label><br>
        <input type="date" name="birth_date" value="{{ old('birth_date') }}">
        <br><br>

        <label>Gender:</label><br>
        <select name="gender">
            <option value="">Select Gender</option>
            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
        <br><br>

        <button type="submit">Save Member</button>
    </form>
</body>
</html>