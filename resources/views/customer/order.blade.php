<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Order Menu - HUBASO</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    @include('customer.partials.styles')

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background:
                radial-gradient(circle at top left, rgba(37,99,235,.18), transparent 34%),
                radial-gradient(circle at top right, rgba(96,165,250,.22), transparent 34%),
                #f3f7ff;
            padding-bottom: 110px;
        }

        .customer-hero {
            background: linear-gradient(135deg, #1d4ed8, #2563eb, #60a5fa);
            color: white;
            border-radius: 0 0 34px 34px;
            padding: 26px 18px 80px;
            box-shadow: 0 22px 50px rgba(37,99,235,.32);
            animation: blueGlow 2.5s infinite alternate;
        }

        @keyframes blueGlow {
            from {
                box-shadow: 0 18px 40px rgba(37,99,235,.25);
            }
            to {
                box-shadow: 0 28px 65px rgba(37,99,235,.55);
            }
        }

        .brand-title {
            font-size: 30px;
            font-weight: 800;
        }

        .hero-subtitle {
            color: rgba(255,255,255,.88);
            font-size: 14px;
        }

        .clock-pill {
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 20px;
            padding: 10px 14px;
            backdrop-filter: blur(8px);
            text-align: center;
        }

        .clock-time {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .clock-date {
            font-size: 10px;
            opacity: .85;
        }

        .order-type-badge {
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 999px;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
            margin-top: 14px;
        }

        .main-card {
            background: white;
            border-radius: 30px;
            padding: 18px;
            margin-top: -55px;
            box-shadow: 0 18px 45px rgba(15,23,42,.10);
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

        #categoryFilter::-webkit-scrollbar {
            display: none;
        }

        .category-btn {
            border-radius: 999px;
            padding: 10px 18px;
            font-weight: 700;
            white-space: nowrap;
            border: none;
            transition: .2s;
        }

        .category-btn.active {
            background: linear-gradient(135deg, #1d4ed8, #60a5fa) !important;
            color: white !important;
            box-shadow: 0 10px 24px rgba(37,99,235,.35);
        }

        .menu-card {
            border-radius: 26px !important;
            overflow: hidden;
            background: white;
            box-shadow: 0 12px 30px rgba(15,23,42,.08);
            transition: .25s;
            border: 1px solid rgba(219,234,254,.9) !important;
        }

        .menu-card:active {
            transform: scale(.97);
        }

        .menu-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 45px rgba(37,99,235,.18);
        }

        .menu-img {
            height: 155px;
            object-fit: cover;
        }

        .menu-name {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
        }

        .menu-price {
            color: #2563eb;
            font-size: 16px;
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

        .cart-box-modern {
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

        .checkout-btn-modern {
            border: none;
            border-radius: 18px;
            padding: 15px;
            font-weight: 800;
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            box-shadow: 0 12px 25px rgba(22,163,74,.25);
        }

        .floating-cart {
            background: linear-gradient(135deg, #0f172a, #1d4ed8);
            box-shadow: 0 18px 40px rgba(37,99,235,.35);
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
            .container {
                padding-left: 14px;
                padding-right: 14px;
            }

            .customer-hero {
                padding: 24px 16px 78px;
            }

            .brand-title {
                font-size: 26px;
            }

            .clock-pill {
                width: 100%;
                margin-top: 10px;
            }

            .main-card {
                padding: 14px;
                border-radius: 26px;
            }

            .menu-img {
                height: 130px;
            }

            .menu-name {
                font-size: 13px;
            }

            .menu-price {
                font-size: 14px;
            }

            .menu-card .card-body {
                padding: 13px;
            }
        }
    </style>
</head>

<body>

@php
    $cart = session('cart', []);
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['harga'] * $item['qty'];
    }
@endphp

<div class="customer-hero">

    <div class="container">

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

            <div>
                <div class="brand-title">
                    🍜 HUBASO
                </div>

                <div class="hero-subtitle">
                    Pilih menu favorit kamu dengan cepat
                </div>

                <div class="order-type-badge">
                    @if(session('jenis_pesanan') == 'Makan Di Tempat')
                        🪑 Meja {{ session('nomor_meja') }}
                    @else
                        🛍️ Bungkus
                    @endif
                </div>
            </div>

            <div class="clock-pill">
                <div id="liveClock" class="clock-time">
                    00:00:00
                </div>

                <div id="liveDate" class="clock-date">
                    Loading...
                </div>
            </div>

        </div>

    </div>

</div>

<div class="container">

    <div class="main-card mb-4">

        @if(session('success'))
            <div class="alert alert-success rounded-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger rounded-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <input type="text"
               id="searchMenu"
               class="form-control search-input mb-4"
               placeholder="🔍 Cari menu... contoh: Bakso Urat">

        <div class="mb-4 d-flex gap-2 overflow-auto pb-2"
             id="categoryFilter">

            <button class="btn btn-light category-btn active"
                    data-category="all">
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
                                <img src="{{ asset('storage/' . $menu->foto) }}"
                                     class="card-img-top menu-img">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light"
                                     style="height:150px;">
                                    <span class="text-muted small">
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

                                <div class="menu-name mt-1">
                                    {{ $menu->nama }}
                                </div>

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

                <div id="cart"
                     class="card cart-box-modern mb-4 desktop-cart-sticky">

                    <div class="cart-header-modern">
                        🛒 Keranjang
                    </div>

                    <div class="card-body">

                        <div id="cart-items">

                            @forelse($cart as $id => $item)

                                <div class="cart-item"
                                     data-id="{{ $id }}">

                                    <div class="d-flex justify-content-between align-items-center mb-2">

                                        <div>
                                            <strong>
                                                {{ $item['nama'] }}
                                            </strong>

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

                        <h5 class="text-end fw-bold"
                            id="cart-total">
                            Total: Rp {{ number_format($total) }}
                        </h5>

                        <button type="button"
                                id="checkout-button"
                                class="btn checkout-btn-modern w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#checkoutModal"
                                {{ empty($cart) ? 'disabled' : '' }}>
                            Checkout
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<div id="floating-cart"
     class="floating-cart d-md-none {{ empty($cart) ? 'd-none' : '' }}">

    <div class="floating-info">

        <div class="floating-icon">
            🛒
        </div>

        <div>
            <div class="floating-title" id="floating-count">
                {{ count($cart) }} item
            </div>

            <div class="floating-total" id="sticky-total">
                Rp {{ number_format($total) }}
            </div>
        </div>

    </div>

    <a href="#cart"
       class="floating-btn">
        Lihat
    </a>

</div>

<div class="modal fade" id="checkoutModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header border-0">

                <h5 class="modal-title fw-bold">
                    Checkout Pesanan
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <form action="/checkout-page" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Nama Customer
                        </label>

                        <input type="text"
                               name="nama_customer"
                               class="form-control @error('nama_customer') is-invalid @enderror"
                               placeholder="Masukkan nama kamu"
                               value="{{ old('nama_customer') }}">

                        @error('nama_customer')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="alert alert-primary rounded-4">

                        <strong>Jenis Pesanan:</strong>
                        {{ session('jenis_pesanan') }}

                        @if(session('jenis_pesanan') == 'Makan Di Tempat')
                            <br>
                            <strong>Meja:</strong>
                            {{ session('nomor_meja') }}
                        @endif

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button type="button"
                            class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button class="btn btn-success rounded-pill px-4"
                            onclick="playSound('sound-checkout')">
                        Lanjut Bayar
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<audio id="sound-click" src="/audio/click.mp3" preload="auto"></audio>
<audio id="sound-add" src="/audio/add.mp3" preload="auto"></audio>
<audio id="sound-checkout" src="/audio/checkout.mp3" preload="auto"></audio>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@include('customer.partials.scripts')

<script>
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
            month: 'long'
        });

        document.getElementById('liveClock').innerText = time;
        document.getElementById('liveDate').innerText = date;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>

</body>
</html>