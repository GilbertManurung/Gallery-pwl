<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Gallery PWL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: system-ui, sans-serif;
            background-color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            background: #fff;
            padding: 2.5rem;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        input {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 0.7rem;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 0.7rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #1d4ed8;
        }

        .link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.95rem;
        }

        .error {
            color: #dc2626;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .success {
            color: #16a34a;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Login</h1>

        {{-- Pesan sukses (dari register) --}}
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        {{-- Pesan error (misal login gagal) --}}
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        {{-- Form login --}}
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="password" name="password" placeholder="Password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <button type="submit">Login</button>
        </form>

        <div class="link">
            Belum punya akun? <a href="{{ route('register.form') }}">Register</a>
        </div>
    </div>
</body>
</html>
