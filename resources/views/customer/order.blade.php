<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Menu</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    @include('customer.partials.styles')
</head>
<body>

@php
    $cart = session('cart', []);
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['harga'] * $item['qty'];
    }
@endphp

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- HEADER -->
    <div class="hero-box p-4 mb-4">

        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h2 class="fw-bold mb-1">
                    🍜 BASO APP
                </h2>

                <p class="text-muted mb-0">
                    Silakan pilih menu favorit kamu
                </p>
            </div>

        <div class="table-badge">

            @if(session('jenis_pesanan') == 'Makan Di Tempat')
                {{ session('nomor_meja') }}
            @else
                Bungkus
            @endif

        </div>
        </div>

    </div>

    <!-- SEARCH -->
    <div class="mb-4">

        <input type="text"
               id="searchMenu"
               class="form-control"
               placeholder="Cari menu... contoh: Bakso Urat">

    </div>

    <!-- CATEGORY FILTER -->
    <div class="mb-4 d-flex gap-2 overflow-auto pb-2"
         id="categoryFilter">

        <button class="btn btn-dark rounded-pill px-4 category-btn active"
                data-category="all">
            Semua
        </button>

        @foreach($categories as $category)

            <button class="btn btn-light rounded-pill px-4 category-btn"
                    data-category="{{ strtolower($category->nama) }}">
                {{ $category->nama }}
            </button>

        @endforeach

    </div>

    <!-- MENU + CART DESKTOP -->
    <div class="row">

        <!-- MENU LIST -->
        <div class="col-lg-8">

            <div class="row">

                @foreach($menus as $menu)

                <div class="col-6 col-md-4 col-lg-4 mb-4 menu-item"
                     data-name="{{ strtolower($menu->nama) }}"
                     data-category="{{ strtolower($menu->category->nama ?? '') }}">

                    <div class="card menu-card border-0 h-100 {{ $menu->stok > 0 ? 'add-to-cart' : 'menu-disabled' }}"
                         data-id="{{ $menu->id }}"
                         style="cursor: {{ $menu->stok > 0 ? 'pointer' : 'not-allowed' }};">

                        @if($menu->foto)

                            <img src="{{ asset('storage/' . $menu->foto) }}"
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
                                    Stok tinggal {{ $menu->stok }}
                                </span>

                            @else

                                <span class="badge bg-success rounded-pill mb-2">
                                    Stok tersedia
                                </span>

                            @endif

                            <small class="text-muted">
                                {{ $menu->category->nama ?? 'Menu' }}
                            </small>

                            <h6 class="fw-bold mt-1">
                                {{ $menu->nama }}
                            </h6>

                            <h6 class="text-dark fw-bold mb-3">
                                Rp {{ number_format($menu->harga) }}
                            </h6>

                            <div class="d-flex justify-content-between align-items-center mt-auto">

                                <small class="text-muted">
                                    {{ $menu->stok > 0 ? 'Tap tambah' : 'Tidak tersedia' }}
                                </small>

                                @if($menu->stok > 0)
                                    <span class="badge rounded-pill"
                                        style="background:#eff6ff;color:#2563eb;">
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

        <!-- CART -->
        <div class="col-lg-4">

            <div id="cart"
                 class="card border-0 mb-4 cart-box desktop-cart-sticky">

                <div class="card-header bg-dark text-white"
                     style="border-radius: 24px 24px 0 0;">

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

                                        <div class="fw-bold cart-subtotal">
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

                        Total:
                        Rp {{ number_format($total) }}

                    </h5>

                    <button type="button"
                            id="checkout-button"
                            class="btn btn-success w-100 checkout-btn"
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

<!-- FLOATING CART MOBILE -->
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

<!-- CHECKOUT MODAL -->
<div class="modal fade" id="checkoutModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content"
             style="border-radius: 24px; border: none;">

            <div class="modal-header border-0">

                <h5 class="modal-title fw-bold">
                    Checkout Pesanan
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>
            <form action="/checkout-page" method="POST">
              

                @csrf

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Nama Customer
                        </label>

                        <input type="text"
                               name="nama_customer"
                               class="form-control @error('nama_customer') is-invalid @enderror"
                               placeholder="Masukkan nama"
                               value="{{ old('nama_customer') }}">

                        @error('nama_customer')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="mb-3">


                        <div class="alert alert-primary rounded-4">

                            <strong>Jenis Pesanan:</strong>
                            {{ session('jenis_pesanan') }}

                            @if(session('jenis_pesanan') == 'Makan Di Tempat')
                                <br>
                                <strong>Meja:</strong>
                                {{ session('nomor_meja') }}
                            @endif

                        </div>

                        @error('jenis_pesanan')
                            <div class="text-danger small mt-2">
                                {{ $message }}
                            </div>
                        @enderror

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

<!-- AUDIO -->
<audio id="sound-click" src="/audio/click.mp3" preload="auto"></audio>
<audio id="sound-add" src="/audio/add.mp3" preload="auto"></audio>
<audio id="sound-checkout" src="/audio/checkout.mp3" preload="auto"></audio>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@include('customer.partials.scripts')

</body>
</html>