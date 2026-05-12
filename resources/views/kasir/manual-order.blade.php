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

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1">
            🧾 Input Order Manual
        </h2>

        <p class="text-muted mb-0">
            Kasir bisa input pesanan customer langsung
        </p>
    </div>

    <a href="/kasir/orders"
       class="btn btn-light rounded-pill px-4">
        Lihat Order
    </a>
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

<div class="mb-4">
    <input type="text"
           id="searchMenu"
           class="form-control"
           placeholder="Cari menu... contoh: Bakso Urat">
</div>

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

<div class="row">

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

    <div class="col-lg-4">

        <div id="cart"
             class="card border-0 mb-4 cart-box desktop-cart-sticky">

            <div class="card-header bg-dark text-white"
                 style="border-radius: 24px 24px 0 0;">
                🛒 Keranjang Kasir
            </div>

            <div class="card-body">

                <div id="cart-items">

                    @forelse($cart as $id => $item)

                    <div class="cart-item"
                         data-id="{{ $id }}">

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
                    Total: Rp {{ number_format($total) }}
                </h5>

                <button type="button"
                        id="checkout-button"
                        class="btn btn-success w-100 checkout-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#kasirCheckoutModal"
                        {{ empty($cart) ? 'disabled' : '' }}>
                    Checkout
                </button>

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

<div class="modal fade" id="kasirCheckoutModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content"
             style="border-radius: 24px; border: none;">

            <div class="modal-header border-0">

                <h5 class="modal-title fw-bold">
                    Checkout Kasir
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <form action="/kasir/manual-order/checkout"
                  method="POST">

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

                            <option value="cash">
                                Cash
                            </option>

                            <option value="qris">
                                QRIS
                            </option>

                        </select>
                    </div>

                    <div id="qrisBox"
                        class="mt-3 text-center"
                        style="display:none;">

                        <div class="p-3 rounded-4"
                            style="background:#f8fafc;">

                            <h6 class="fw-bold mb-2">
                                Scan QRIS Pembayaran
                            </h6>

                            <img src="{{ asset('qris/qris.png') }}"
                                class="img-fluid rounded-4"
                                style="max-width:260px;">

                            <p class="text-muted small mt-2 mb-0">
                                Pastikan customer sudah melakukan pembayaran sebelum simpan order.
                            </p>

                        </div>

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
    if (jenisPesanan.value === 'Bungkus') {
        nomorMejaBox.style.display = 'none';
    } else {
        nomorMejaBox.style.display = 'block';
    }
}

jenisPesanan.addEventListener('change', toggleNomorMeja);

toggleNomorMeja();

const paymentMethod = document.getElementById('paymentMethod');
const qrisBox = document.getElementById('qrisBox');

function toggleQrisBox()
{
    if (paymentMethod.value === 'qris') {
        qrisBox.style.display = 'block';
    } else {
        qrisBox.style.display = 'none';
    }
}

paymentMethod.addEventListener('change', toggleQrisBox);

toggleQrisBox();
</script>

@endsection