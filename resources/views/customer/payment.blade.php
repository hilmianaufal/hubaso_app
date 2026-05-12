<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pembayaran - HUBASO</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f5f7fb;
        }

        .payment-hero {
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            color: white;
            padding: 28px 20px 90px;
            border-radius: 0 0 34px 34px;
        }

        .payment-wrapper {
            max-width: 520px;
            margin: auto;
        }

        .payment-card {
            background: white;
            margin: -60px 18px 24px;
            border-radius: 30px;
            padding: 24px;
            box-shadow: 0 18px 45px rgba(0,0,0,0.12);
        }

        .queue-box {
            width: 86px;
            height: 86px;
            border-radius: 28px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            margin: 0 auto 18px;
        }

        .info-box {
            background: #f8fafc;
            border-radius: 22px;
            padding: 16px;
            margin-bottom: 14px;
        }

        .pay-button {
            border: none;
            border-radius: 20px;
            padding: 16px;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            font-weight: 800;
            width: 100%;
            box-shadow: 0 14px 30px rgba(22,163,74,0.25);
            transition: 0.2s;
        }

        .pay-button:hover {
            transform: translateY(-2px);
        }

        .secondary-link {
            display: block;
            text-align: center;
            margin-top: 16px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="payment-wrapper">

    <div class="payment-hero">

        <a href="/order/menu"
           class="text-white text-decoration-none">
            ← Kembali
        </a>

        <h2 class="fw-bold mt-3 mb-2">
            Pembayaran
        </h2>

        <p class="mb-0"
           style="color:rgba(255,255,255,0.85);">
            Selesaikan pembayaran pesanan kamu
        </p>

    </div>

    <div class="payment-card">

        <div class="text-center">

            <div class="queue-box">
                {{ $order->queue_number }}
            </div>

            <h4 class="fw-bold mb-1">
                HUBASO
            </h4>

            <p class="text-muted mb-4">
                Order berhasil dibuat
            </p>

        </div>

        <div class="info-box">
            <small class="text-muted">Customer</small>
            <h6 class="fw-bold mb-0">
                {{ $order->nama_customer }}
            </h6>
        </div>

        <div class="info-box">
            <small class="text-muted">Jenis Pesanan</small>
            <h6 class="fw-bold mb-0">
                {{ $order->jenis_pesanan }}

                @if($order->jenis_pesanan == 'Makan Di Tempat')
                    • Meja {{ $order->nomor_meja_manual }}
                @endif
            </h6>
        </div>

        <div class="info-box">
            <small class="text-muted">Total Pembayaran</small>
            <h3 class="fw-bold text-primary mb-0">
                Rp {{ number_format($order->total) }}
            </h3>
        </div>

        <button id="pay-button"
                class="pay-button mt-3">

            Bayar Sekarang

        </button>

        <a href="/invoice/{{ $order->id }}"
           class="secondary-link">
            Lihat invoice dulu
        </a>

    </div>

</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
document.getElementById('pay-button').addEventListener('click', function () {
    snap.pay('{{ $order->snap_token }}', {
        onSuccess: function(result) {
            window.location.href = '/payment/{{ $order->id }}/success';
        },
        onPending: function(result) {
            window.location.href = '/invoice/{{ $order->id }}';
        },
        onError: function(result) {
            alert('Pembayaran gagal');
        },
        onClose: function() {
            alert('Kamu menutup pembayaran');
        }
    });
});
</script>

</body>
</html>