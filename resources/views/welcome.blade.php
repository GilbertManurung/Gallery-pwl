<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Gallery PWL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
        }

        .wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: #ffffff;
            padding: 3rem;
            max-width: 520px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            text-align: center;
        }

        h1 {
            margin-bottom: 0.75rem;
            font-size: 2.25rem;
        }

        p {
            margin-bottom: 2rem;
            color: #6b7280;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-login {
            background-color: #2563eb;
            color: #ffffff;
        }

        .btn-login:hover {
            background-color: #1e40af;
        }

        .btn-register {
            border: 2px solid #2563eb;
            color: #2563eb;
        }

        .btn-register:hover {
            background-color: #eff6ff;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <h1>Gallery PWL</h1>

            <p>
                Platform web sederhana untuk membangun dan mengelola konten
                menggunakan Laravel, PostgreSQL, dan FrankenPHP.
            </p>

            <div class="actions">
                <a href="/login" class="btn btn-login">Login</a>
                <a href="/register" class="btn btn-register">Register</a>
            </div>
        </div>
    </div>
</body>
</html>
