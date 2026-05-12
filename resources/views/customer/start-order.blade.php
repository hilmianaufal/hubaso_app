<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Mulai Order - HUBASO</title>

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
        }

        .page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hero {
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            padding: 34px 22px 90px;
            border-radius: 0 0 34px 34px;
        }

        .brand {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .hero h1 {
            font-size: 25px;
            line-height: 1.25;
            margin: 0 0 10px;
            font-weight: 800;
        }

        .hero p {
            margin: 0;
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            line-height: 1.6;
        }

        .card-box {
            background: white;
            margin: -58px 18px 24px;
            border-radius: 30px;
            padding: 22px;
            box-shadow: 0 18px 45px rgba(0,0,0,0.12);
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 14px;
        }

        .type-wrapper {
            display: grid;
            gap: 14px;
        }

        .type-card {
            position: relative;
            border: 2px solid #e5e7eb;
            border-radius: 24px;
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            background: white;
            cursor: pointer;
            transition: 0.2s;
        }

        .type-card input {
            display: none;
        }

        .type-card.active {
            border-color: #2563eb;
            background: #eff6ff;
            box-shadow: 0 10px 25px rgba(37,99,235,0.12);
            transform: translateY(-2px);
        }

        .type-icon {
            width: 58px;
            height: 58px;
            border-radius: 20px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .type-title {
            font-size: 16px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 3px;
        }

        .type-desc {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.4;
        }

        .check-dot {
            position: absolute;
            top: 14px;
            right: 14px;
            width: 24px;
            height: 24px;
            border-radius: 999px;
            background: #2563eb;
            color: white;
            font-size: 14px;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .type-card.active .check-dot {
            display: flex;
        }

        .field-box {
            margin-top: 18px;
            animation: fadeUp 0.25s ease;
        }

        label {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
            display: block;
        }

        .input {
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 15px 16px;
            font-size: 15px;
            outline: none;
        }

        .input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.12);
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            border-radius: 18px;
            padding: 14px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .btn-start {
            width: 100%;
            margin-top: 22px;
            border: none;
            border-radius: 20px;
            padding: 16px;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            font-size: 15px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 14px 28px rgba(37,99,235,0.24);
        }

        .btn-start:active {
            transform: scale(0.98);
        }

        .note {
            margin-top: 18px;
            background: #f8fafc;
            border-radius: 20px;
            padding: 14px;
            font-size: 12px;
            color: #6b7280;
            line-height: 1.5;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (min-width: 768px) {
            body {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .page {
                width: 100%;
                max-width: 520px;
                min-height: auto;
            }

            .hero {
                border-radius: 34px 34px 0 0;
            }

            .card-box {
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
</head>
<body>

<div class="page">

    <div class="hero">
        <div class="brand">
            🍜 HUBASO
        </div>

        <h1>
            Mau makan di tempat atau dibungkus?
        </h1>

        <p>
            Pilih jenis pesanan terlebih dahulu sebelum melihat menu favorit kamu.
        </p>
    </div>

    <div class="card-box">

        @if ($errors->any())
            <div class="error-box">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/order/start"
              method="POST">

            @csrf

            <div class="section-title">
                Pilih jenis pesanan
            </div>

            <div class="type-wrapper">

                <label class="type-card active">
                    <input type="radio"
                           name="jenis_pesanan"
                           value="Makan Di Tempat"
                           checked>

                    <div class="type-icon">
                        🍽️
                    </div>

                    <div>
                        <div class="type-title">
                            Makan di Tempat
                        </div>

                        <div class="type-desc">
                            Pesanan akan diantar ke nomor meja kamu.
                        </div>
                    </div>

                    <div class="check-dot">
                        ✓
                    </div>
                </label>

                <label class="type-card">
                    <input type="radio"
                           name="jenis_pesanan"
                           value="Bungkus">

                    <div class="type-icon">
                        🛍️
                    </div>

                    <div>
                        <div class="type-title">
                            Bungkus
                        </div>

                        <div class="type-desc">
                            Pesanan disiapkan untuk dibawa pulang.
                        </div>
                    </div>

                    <div class="check-dot">
                        ✓
                    </div>
                </label>

            </div>

            <div id="mejaBox"
                 class="field-box">

                <label>
                    Nomor Meja
                </label>

                <input type="text"
                       name="nomor_meja"
                       class="input"
                       placeholder="Contoh: Meja 1">

            </div>

            <button class="btn-start">
                Mulai Pesan
            </button>

            <div class="note">
                Pastikan pilihan pesanan sudah benar. Untuk makan di tempat, nomor meja wajib diisi.
            </div>

        </form>

    </div>

</div>

<script>
    const cards = document.querySelectorAll('.type-card');

    function toggleMeja()
    {
        const selected = document.querySelector(
            'input[name="jenis_pesanan"]:checked'
        ).value;

        const mejaBox = document.getElementById('mejaBox');

        if (selected === 'Makan Di Tempat') {
            mejaBox.style.display = 'block';
        } else {
            mejaBox.style.display = 'none';
        }
    }

    cards.forEach(card => {
        card.addEventListener('click', function () {
            cards.forEach(item => item.classList.remove('active'));

            this.classList.add('active');
            this.querySelector('input').checked = true;

            toggleMeja();
        });
    });

    toggleMeja();
</script>

</body>
</html>