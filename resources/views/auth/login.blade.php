<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - HUBASO</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f5f7fb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1050px;
            min-height: 620px;
            background: white;
            border-radius: 32px;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        }

        .login-hero {
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand {
            font-size: 34px;
            font-weight: 700;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 14px;
        }

        .hero-text {
            color: rgba(255,255,255,0.85);
            font-size: 15px;
            line-height: 1.7;
        }

        .hero-card {
            background: rgba(255,255,255,0.15);
            border-radius: 24px;
            padding: 22px;
            backdrop-filter: blur(14px);
        }

        .login-form {
            padding: 55px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-title {
            font-size: 30px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: #6b7280;
            margin-bottom: 35px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 14px 16px;
            font-size: 14px;
            outline: none;
            transition: 0.2s;
        }

        .input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.12);
        }

        .remember-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            font-size: 14px;
        }

        .forgot {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .login-btn {
            width: 100%;
            border: none;
            border-radius: 16px;
            padding: 14px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: 0.2s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(37,99,235,0.25);
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .status {
            background: #eff6ff;
            color: #2563eb;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        @media(max-width: 768px) {
            body {
                padding: 20px;
            }

            .login-wrapper {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .login-hero {
                padding: 32px;
                gap: 35px;
            }

            .hero-title {
                font-size: 30px;
            }

            .login-form {
                padding: 32px;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <div class="login-hero">

        <div class="brand">
            🍜 HUBASO
        </div>

        <div>
            <div class="hero-title">
                Kelola Restoran Bakso Lebih Mudah
            </div>

            <div class="hero-text">
                Masuk ke dashboard untuk mengelola menu, meja,
                order masuk, dapur, pembayaran, dan laporan penjualan.
            </div>
        </div>

        <div class="hero-card">
            <strong>POS Modern untuk UMKM</strong>
            <br>
            <small>
                Cepat, responsif, dan siap digunakan untuk operasional restoran harian.
            </small>
        </div>

    </div>

    <div class="login-form">

        <div class="form-title">
            Selamat Datang
        </div>

        <div class="form-subtitle">
            Login untuk melanjutkan ke dashboard HUBASO
        </div>

        @if (session('status'))
            <div class="status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">
                    Email
                </label>

                <input id="email"
                       class="input"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="username"
                       placeholder="Masukkan email">

                @error('email')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">
                    Password
                </label>

                <input id="password"
                       class="input"
                       type="password"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="Masukkan password">

                @error('password')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="remember-row">

                <label class="remember">
                    <input id="remember_me"
                           type="checkbox"
                           name="remember">

                    Ingat saya
                </label>

                @if (Route::has('password.request'))
                    <a class="forgot"
                       href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif

            </div>

            <button type="submit"
                    class="login-btn">
                Masuk Dashboard
            </button>

        </form>

    </div>

</div>

</body>
</html>