<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Invoice</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

    <style>

    body {

        font-family: monospace;

        background: #eee;
    }

    .thermal {

        width: 300px;

        background: white;

        margin: auto;

        padding: 15px;
    }

    .center {

        text-align: center;
    }

    .line {

        border-top: 1px dashed black;

        margin: 10px 0;
    }

    @media print {

        body {

            background: white;
        }

        .no-print {

            display: none;
        }

    }

    </style>

</head>
<body>

<div class="thermal">

<div class="center">

    <h3>
        HUBASO
    </h3>

    <small>
        Struk Pembayaran
    </small>
    <h1>

        {{ $order->queue_number }}

    </h1>
</div>
<div class="line"></div>


@if($order->jenis_pesanan == 'Bungkus')
    Pesanan: Bungkus
@else
    Meja: {{ $order->nomor_meja_manual ?? '-' }}
@endif

<br>

Customer:
{{ $order->nama_customer }}

<br>

Jenis:
{{ $order->jenis_pesanan }}

<br>

Tanggal:
{{ $order->created_at }}

<div class="line"></div>

@foreach($order->items as $item)

<div>

    {{ $item->menu->nama }}

    <br>

    {{ $item->qty }} x
    {{ number_format($item->menu->harga) }}

    <span style="float:right">

        {{ number_format($item->subtotal) }}

    </span>

</div>

<br>

@endforeach
@if($order->catatan)

<div class="line"></div>

<strong>
    Catatan:
</strong>

<br>

{{ $order->catatan }}

@endif
<div class="line"></div>

<h4>

    TOTAL

    <span style="float:right">

        Rp {{ number_format($order->total) }}

    </span>

</h4>

<div class="line"></div>

<div class="center">

    Terima Kasih 🙏

</div>

    <!-- BUTTON -->

<div class="mt-3 no-print">

    <button onclick="window.print()"
            class="btn btn-dark w-100">

        🖨️ Print Thermal

    </button>

</div>

<div class="mt-2 no-print">

    @auth

        <a href="/kasir/manual-order"
           class="btn btn-primary w-100">

            🍜 Pesan Lagi

        </a>

    @else

        <a href="/order"
           class="btn btn-primary w-100">

            🍜 Pesan Lagi

        </a>

    @endauth

</div>

</div>
</body>
</html>