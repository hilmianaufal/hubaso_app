@extends('layouts.app')

@section('content')

@include('customer.partials.styles')

@php
    $cart = session('cart', []);
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['harga'] * $item['qty'];
    }
@endphp

<style>
    body {
        background:
            radial-gradient(circle at top left, rgba(37,99,235,.18), transparent 35%),
            radial-gradient(circle at top right, rgba(96,165,250,.20), transparent 35%),
            #f3f7ff;
    }

    .pos-hero {
        background: linear-gradient(135deg, #1d4ed8, #2563eb, #60a5fa);
        border-radius: 30px;
        padding: 26px;
        color: white;
        box-shadow: 0 22px 45px rgba(37,99,235,.25);
        position: relative;
        overflow: hidden;
        animation: blueGlow 2.4s infinite alternate;
    }

    @keyframes blueGlow {
        from {
            box-shadow: 0 15px 35px rgba(37,99,235,.25);
        }
        to {
            box-shadow: 0 25px 60px rgba(37,99,235,.55);
        }
    }

    .clock-box {
        background: rgba(255,255,255,.16);
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 20px;
        padding: 14px 18px;
        text-align: center;
        min-width: 170px;
        backdrop-filter: blur(8px);
    }

    .clock-time {
        font-size: 24px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .clock-date {
        font-size: 12px;
        opacity: .85;
    }

    .search-box {
        background: white;
        border-radius: 24px;
        padding: 16px;
        box-shadow: 0 12px 32px rgba(15,23,42,.07);
    }

    .search-input {
        border: none;
        background: #f8fafc;
        border-radius: 18px;
        padding: 15px 18px;
        font-weight: 600;
    }

    .search-input:focus {
        background: white;
        box-shadow: 0 0 0 4px rgba(37,99,235,.12);
    }

    .category-btn {
        border-radius: 999px;
        padding: 11px 20px;
        font-weight: 700;
        white-space: nowrap;
        transition: .2s;
    }

    .category-btn.active {
        background: linear-gradient(135deg, #1d4ed8, #60a5fa) !important;
        color: white !important;
        box-shadow: 0 10px 24px rgba(37,99,235,.35);
    }

    .menu-card {
        border-radius: 28px !important;
        overflow: hidden;
        background: white;
        box-shadow: 0 14px 32px rgba(15,23,42,.08);
        transition: .25s;
        border: 1px solid rgba(219,234,254,.9) !important;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 45px rgba(37,99,235,.20);
    }

    .menu-img {
        height: 165px;
        object-fit: cover;
    }

    .menu-price {
        color: #2563eb;
        font-size: 17px;
        font-weight: 800;
    }

    .plus-pill {
        background: linear-gradient(135deg, #2563eb, #60a5fa);
        color: white;
        width: 34px;
        height: 34px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        box-shadow: 0 8px 18px rgba(37,99,235,.35);
    }

    .cart-modern {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(15,23,42,.10);
    }

    .cart-header-modern {
        background: linear-gradient(135deg, #0f172a, #1d4ed8);
        color: white;
        padding: 18px;
        font-weight: 800;
    }

    .checkout-btn {
        border: none;
        border-radius: 18px;
        padding: 15px;
        font-weight: 800;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: white;
        box-shadow: 0 12px 25px rgba(22,163,74,.25);
    }

    .modal-content {
        border-radius: 28px !important;
        border: none !important;
        overflow: hidden;
    }

    .modal-header {
        background: linear-gradient(135deg, #1d4ed8, #60a5fa);
        color: white;
    }

    @media(max-width: 768px) {
        .pos-hero {
            border-radius: 24px;
            padding: 22px;
        }

        .clock-box {
            width: 100%;
        }

        .menu-img {
            height: 135px;
        }

        .menu-card h6 {
            font-size: 14px;
        }

        .menu-price {
            font-size: 14px;
        }
    }
</style>

<div class="pos-hero mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h2 class="fw-bold mb-1">
                ⚡ HUBASO Kasir POS
            </h2>
            <p class="mb-0" style="opacity:.88;">
                Input order manual cepat, modern, dan realtime
            </p>
        </div>

        <div class="clock-box">
            <div id="liveClock" class="clock-time">00:00:00</div>
            <div id="liveDate" class="clock-date">Loading...</div>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="search-box mb-4">
    <input type="text"
           id="searchMenu"
           class="form-control search-input"
           placeholder="🔍 Cari menu... contoh: Bakso Urat">
</div>

<div class="mb-4 d-flex gap-2 overflow-auto pb-2" id="categoryFilter">
    <button class="btn btn-light category-btn active" data-category="all">
        Semua
    </button>

    @foreach($categories as $category)
        <button class="btn btn-light category-btn"
                data-category="{{ strtolower($category->nama) }}">
            {{ $category->nama }}
        </button>
    @endforeach
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="row">

            @foreach($menus as $menu)
                <div class="col-6 col-md-4 col-lg-4 mb-4 menu-item"
                     data-name="{{ strtolower($menu->nama) }}"
                     data-category="{{ strtolower($menu->category->nama ?? '') }}">

                    <div class="card menu-card h-100 {{ $menu->stok > 0 ? 'add-to-cart' : 'menu-disabled' }}"
                         data-id="{{ $menu->id }}"
                         style="cursor: {{ $menu->stok > 0 ? 'pointer' : 'not-allowed' }};">

                        @if($menu->foto)
                            <img src="{{ asset($menu->foto) }}"
                                 class="card-img-top menu-img">
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light"
                                 style="height:160px;">
                                <span class="text-muted">
                                    Tidak ada foto
                                </span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">

                            @if($menu->stok <= 0)
                                <span class="badge bg-danger rounded-pill mb-2">
                                    Habis
                                </span>
                            @elseif($menu->stok <= 5)
                                <span class="badge bg-warning text-dark rounded-pill mb-2">
                                    Stok {{ $menu->stok }}
                                </span>
                            @else
                                <span class="badge rounded-pill mb-2"
                                      style="background:#dcfce7;color:#166534;">
                                    Tersedia
                                </span>
                            @endif

                            <small class="text-muted">
                                {{ $menu->category->nama ?? 'Menu' }}
                            </small>

                            <h6 class="fw-bold mt-1">
                                {{ $menu->nama }}
                            </h6>

                            <div class="menu-price mb-3">
                                Rp {{ number_format($menu->harga) }}
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <small class="text-muted">
                                    {{ $menu->stok > 0 ? 'Tap tambah' : 'Tidak tersedia' }}
                                </small>

                                @if($menu->stok > 0)
                                    <span class="plus-pill">
                                        +
                                    </span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="col-lg-4">
        <div id="cart" class="card cart-modern mb-4 desktop-cart-sticky">

            <div class="cart-header-modern">
                🛒 Keranjang Kasir
            </div>

            <div class="card-body">

                <div id="cart-items">
                    @forelse($cart as $id => $item)
                        <div class="cart-item" data-id="{{ $id }}">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <strong>{{ $item['nama'] }}</strong>
                                    <br>
                                    <small class="text-muted">
                                        Rp {{ number_format($item['harga']) }}
                                    </small>
                                </div>

                                <div class="text-end">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <button type="button"
                                                class="qty-btn decrease-cart"
                                                data-id="{{ $id }}">
                                            -
                                        </button>

                                        <strong class="cart-qty">
                                            {{ $item['qty'] }}
                                        </strong>

                                        <button type="button"
                                                class="qty-btn increase-cart"
                                                data-id="{{ $id }}">
                                            +
                                        </button>
                                    </div>

                                    <div class="fw-bold text-primary cart-subtotal">
                                        Rp {{ number_format($item['harga'] * $item['qty']) }}
                                    </div>
                                </div>
                            </div>

                            <button type="button"
                                    class="remove-btn remove-cart"
                                    data-id="{{ $id }}">
                                Hapus
                            </button>

                            <hr>
                        </div>
                    @empty
                        <p class="text-muted mb-0" id="empty-cart">
                            Keranjang masih kosong
                        </p>
                    @endforelse
                </div>

                <h5 class="text-end fw-bold" id="cart-total">
                    Total: Rp {{ number_format($total) }}
                </h5>

                <button type="button"
                        id="checkout-button"
                        class="btn checkout-btn w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#kasirCheckoutModal"
                        {{ empty($cart) ? 'disabled' : '' }}>
                    Checkout Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<div id="floating-cart"
     class="floating-cart d-md-none {{ empty($cart) ? 'd-none' : '' }}">

    <div class="floating-info">
        <div class="floating-icon">🛒</div>

        <div>
            <div class="floating-title" id="floating-count">
                {{ count($cart) }} item
            </div>

            <div class="floating-total" id="sticky-total">
                Rp {{ number_format($total) }}
            </div>
        </div>
    </div>

    <a href="#cart" class="floating-btn">
        Lihat
    </a>
</div>

<div class="modal fade" id="kasirCheckoutModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    Checkout Kasir
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <form action="/kasir/manual-order/checkout" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Customer
                        </label>

                        <input type="text"
                               name="nama_customer"
                               class="form-control"
                               value="Walk In Customer">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Jenis Pesanan
                        </label>

                        <select name="jenis_pesanan"
                                id="jenisPesanan"
                                class="form-control">
                            <option value="Makan Di Tempat">
                                Makan Di Tempat
                            </option>

                            <option value="Bungkus">
                                Bungkus
                            </option>
                        </select>
                    </div>

                    <div class="mb-3" id="nomorMejaBox">
                        <label class="form-label fw-semibold">
                            Nomor Meja
                        </label>

                        <input type="text"
                               name="nomor_meja"
                               class="form-control"
                               placeholder="Contoh: Meja 2">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Metode Pembayaran
                        </label>

                        <select name="payment_method"
                                id="paymentMethod"
                                class="form-control">
                            <option value="cash">Cash</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Catatan
                        </label>

                        <textarea name="catatan"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Contoh: jangan pedas, kuah dipisah"></textarea>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button class="btn btn-success rounded-pill px-4">
                        Simpan Order
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<audio id="sound-click" src="/audio/click.mp3" preload="auto"></audio>
<audio id="sound-add" src="/audio/add.mp3" preload="auto"></audio>
<audio id="sound-checkout" src="/audio/checkout.mp3" preload="auto"></audio>

@include('customer.partials.scripts')

<script>
    const jenisPesanan = document.getElementById('jenisPesanan');
    const nomorMejaBox = document.getElementById('nomorMejaBox');

    function toggleNomorMeja()
    {
        nomorMejaBox.style.display = jenisPesanan.value === 'Bungkus'
            ? 'none'
            : 'block';
    }

    jenisPesanan.addEventListener('change', toggleNomorMeja);
    toggleNomorMeja();

    function updateClock()
    {
        const now = new Date();

        const time = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });

        const date = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });

        document.getElementById('liveClock').innerText = time;
        document.getElementById('liveDate').innerText = date;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>

@endsection