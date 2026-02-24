<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register - Gallery PWL</title>
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
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
            color: #111827;
        }

        input {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 0.5rem;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 0.7rem;
            background: #16a34a;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover {
            background: #15803d;
        }

        .link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.95rem;
        }

        .link a {
            color: #2563eb;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }

        .error {
            color: #dc2626;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .success {
            color: #16a34a;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Register</h1>

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        {{-- Form Register --}}
        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="password" name="password" placeholder="Password">
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password">

            <button type="submit">Register</button>
        </form>

        <div class="link">
            Sudah punya akun? <a href="{{ route('login.form') }}">Login</a>
        </div>
    </div>
</body>
</html>
