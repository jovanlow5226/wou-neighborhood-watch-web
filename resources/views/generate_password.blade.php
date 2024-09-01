<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Hashed Password</title>
</head>
<body>
    <h1>Generate Hashed Password</h1>
    <form action="{{ route('generate.password') }}" method="POST">
        @csrf
        <label for="password">Enter Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Generate Hash</button>
        @if (!empty($hashedPassword))
            <div>
                <label for="hashed-password">Hashed Password:</label><br>
                <input type="text" id="hashed-password" value="{{ $hashedPassword }}" readonly>
            </div>
        @endif
    </form>
</body>
</html>
