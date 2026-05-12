<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Checkout - HUBASO</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f7fb;
            padding-bottom: 110px;
        }

        .checkout-hero {
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            border-radius: 0 0 32px 32px;
            padding: 28px 20px 80px;
        }

        .checkout-card {
            background: white;
            border-radius: 28px;
            padding: 22px;
            margin-top: -55px;
            box-shadow: 0 18px 45px rgba(0,0,0,0.1);
        }

        .order-item {
            background: #f8fafc;
            border-radius: 20px;
            padding: 14px;
            margin-bottom: 12px;
        }

        .summary-box {
            background: #eff6ff;
            border-radius: 22px;
            padding: 18px;
        }

        .form-control {
            border-radius: 16px;
            padding: 14px;
        }

        .pay-button {
            position: fixed;
            bottom: 18px;
            left: 18px;
            right: 18px;
            border: none;
            border-radius: 22px;
            padding: 16px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            font-weight: 800;
            box-shadow: 0 14px 35px rgba(22,163,74,0.3);
        }

        .type-badge {
            background: rgba(255,255,255,0.18);
            color: white;
            border-radius: 999px;
            padding: 8px 14px;
            font-size: 13px;
            display: inline-block;
        }

        @media(min-width: 768px) {
            .checkout-wrapper {
                max-width: 760px;
                margin: auto;
            }

            .pay-button {
                position: static;
                width: 100%;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

<div class="checkout-wrapper">

    <div class="checkout-hero">

        <a href="/order/menu"
           class="text-white text-decoration-none">
            ← Kembali
        </a>

        <h2 class="fw-bold mt-3 mb-2">
            Checkout Pesanan
        </h2>

        <p class="mb-3"
           style="color: rgba(255,255,255,0.85);">
            Periksa kembali pesanan kamu sebelum lanjut bayar
        </p>

        <div class="type-badge">
            {{ session('jenis_pesanan') }}

            @if(session('jenis_pesanan') == 'Makan Di Tempat')
                • Meja {{ session('nomor_meja') }}
            @endif
        </div>

    </div>

    <div class="container">

        <div class="checkout-card">

            @if ($errors->any())
                <div class="alert alert-danger rounded-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
<div class="summary-box mb-4">

    <div class="d-flex justify-content-between mb-3">

        <div>
            <small class="text-muted">Customer</small>
            <h6 class="fw-bold mb-0">
                {{ session('nama_customer') }}
            </h6>
        </div>

        <div style="font-size:26px;">
            👤
        </div>

    </div>

    <div class="d-flex justify-content-between mb-3">

        <div>
            <small class="text-muted">Jenis Pesanan</small>
            <h6 class="fw-bold mb-0">
                {{ session('jenis_pesanan') }}
            </h6>
        </div>

        <div style="font-size:26px;">
            {{ session('jenis_pesanan') == 'Bungkus' ? '🛍️' : '🍽️' }}
        </div>

    </div>

    @if(session('jenis_pesanan') == 'Makan Di Tempat')
        <div class="d-flex justify-content-between">

            <div>
                <small class="text-muted">Nomor Meja</small>
                <h6 class="fw-bold mb-0">
                    {{ session('nomor_meja') }}
                </h6>
            </div>

            <div style="font-size:26px;">
                🪑
            </div>

        </div>
    @endif

</div>
            <h5 class="fw-bold mb-3">
                🛒 Detail Pesanan
            </h5>

            @foreach($cart as $item)

                <div class="order-item">

                    <div class="d-flex justify-content-between align-items-start">

                        <div>
                            <strong>
                                {{ $item['nama'] }}
                            </strong>

                            <br>

                            <small class="text-muted">
                                {{ $item['qty'] }} x Rp {{ number_format($item['harga']) }}
                            </small>
                        </div>

                        <div class="fw-bold text-primary">
                            Rp {{ number_format($item['harga'] * $item['qty']) }}
                        </div>

                    </div>

                </div>

            @endforeach

            <div class="summary-box mt-4 mb-4">

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">
                        Total Item
                    </span>

                    <strong>
                        {{ collect($cart)->sum('qty') }} item
                    </strong>
                </div>

                <div class="d-flex justify-content-between align-items-center">

                    <span class="text-muted">
                        Total Bayar
                    </span>

                    <h4 class="fw-bold text-primary mb-0">
                        Rp {{ number_format($total) }}
                    </h4>

                </div>

            </div>

            <form action="/checkout"
                  method="POST">

                @csrf

                <div class="mb-3">


                    @error('nama_customer')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Catatan Pesanan
                    </label>

                    <textarea name="catatan"
                            class="form-control"
                            rows="3"
                            placeholder="Contoh: jangan pedas, kuah dipisah, tanpa bawang">{{ old('catatan') }}</textarea>

                    <small class="text-muted">
                        Opsional, boleh dikosongkan.
                    </small>

                </div>
                <button class="pay-button">
                    Lanjut Bayar • Rp {{ number_format($total) }}
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>