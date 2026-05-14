@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f3f6fb;
    }

    .payment-layout {
        min-height: calc(100vh - 80px);
    }

    .payment-card {
        border: none;
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15,23,42,.08);
        background: white;
    }

    .left-panel {
        padding: 28px;
        background: white;
    }

    .right-panel {
        background: linear-gradient(135deg, #111827, #1f2937);
        color: white;
        padding: 32px;
        height: 100%;
    }

    .queue-box {
        width: 82px;
        height: 82px;
        border-radius: 24px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 34px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .info-chip {
        background: #f8fafc;
        border-radius: 999px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }

    .menu-item-box {
        background: #f8fafc;
        border-radius: 22px;
        padding: 16px;
        margin-bottom: 14px;
        transition: .2s;
    }

    .menu-item-box:hover {
        transform: translateY(-2px);
    }

    .payment-method {
        border: 2px solid #e5e7eb;
        border-radius: 20px;
        padding: 16px;
        cursor: pointer;
        transition: .2s;
        background: white;
    }

    .payment-method.active {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .payment-method input {
        display: none;
    }

    .payment-total {
        font-size: 48px;
        font-weight: 800;
        line-height: 1;
    }

    .payment-label {
        color: rgba(255,255,255,.7);
        font-size: 14px;
    }

    .money-input {
        border: none;
        border-radius: 22px;
        padding: 22px;
        font-size: 34px;
        font-weight: 800;
        width: 100%;
        outline: none;
        text-align: right;
        background: #f8fafc;
    }

    .quick-money {
        border: none;
        border-radius: 18px;
        padding: 14px;
        font-weight: 700;
        background: rgba(255,255,255,.08);
        color: white;
        transition: .2s;
    }

    .quick-money:hover {
        background: rgba(255,255,255,.16);
    }

    .change-box {
        background: rgba(255,255,255,.08);
        border-radius: 24px;
        padding: 24px;
    }

    .change-value {
        font-size: 42px;
        font-weight: 800;
        line-height: 1;
    }

    .pay-button {
        border: none;
        width: 100%;
        border-radius: 24px;
        padding: 18px;
        font-size: 18px;
        font-weight: 800;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        color: white;
        box-shadow: 0 18px 35px rgba(22,163,74,.25);
        transition: .2s;
    }

    .pay-button:hover {
        transform: translateY(-2px);
    }

    .success-animation {
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,.75);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: white;
        backdrop-filter: blur(8px);
    }

    .success-circle {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #16a34a, #22c55e);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 58px;
        margin-bottom: 20px;
        animation: pop .35s ease;
    }

    @keyframes pop {
        from {
            transform: scale(.5);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    @media(max-width:991px)
    {
        .right-panel {
            border-radius: 32px 32px 0 0;
        }

        .payment-total {
            font-size: 38px;
        }

        .change-value {
            font-size: 34px;
        }

        .money-input {
            font-size: 28px;
        }
    }
</style>

<div class="container-fluid py-4 payment-layout">

    <form action="/kasir/payment/{{ $order->id }}"
          method="POST"
          id="paymentForm">

        @csrf

        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-7">

                <div class="payment-card h-100">

                    <div class="left-panel">

                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">

                            <div>

                                <h2 class="fw-bold mb-1">
                                    💳 Cash Payment
                                </h2>

                                <p class="text-muted mb-0">
                                    Selesaikan pembayaran customer
                                </p>

                            </div>

                            <div class="queue-box">
                                {{ $order->queue_number }}
                            </div>

                        </div>

                        <div class="d-flex flex-wrap gap-2 mb-4">

                            <div class="info-chip">
                                👤 {{ $order->nama_customer }}
                            </div>

                            <div class="info-chip">

                                @if($order->jenis_pesanan == 'Bungkus')

                                    🛍️ Bungkus

                                @else

                                    🪑 Meja {{ $order->nomor_meja_manual ?? '-' }}

                                @endif

                            </div>

                        </div>

                        <h5 class="fw-bold mb-3">
                            🍜 Pesanan
                        </h5>

                        @foreach($order->items as $item)

                        <div class="menu-item-box">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <div class="fw-bold mb-1">
                                        {{ $item->menu->nama ?? 'Menu Dihapus' }}
                                    </div>

                                    <small class="text-muted">
                                        Qty {{ $item->qty }}
                                    </small>

                                </div>

                                <div class="fw-bold text-primary">

                                    Rp {{ number_format($item->subtotal) }}

                                </div>

                            </div>

                        </div>

                        @endforeach

                        @if($order->catatan)

                        <div class="alert alert-warning rounded-4 mt-4 mb-0">

                            <strong>📝 Catatan:</strong>
                            <br>

                            {{ $order->catatan }}

                        </div>

                        @endif

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="col-lg-5">

                <div class="payment-card h-100">

                    <div class="right-panel d-flex flex-column">

                        <div class="mb-4">

                            <div class="payment-label mb-2">
                                Total Pembayaran
                            </div>

                            <div class="payment-total"
                                 id="totalDisplay"
                                 data-total="{{ $order->total }}">

                                Rp {{ number_format($order->total) }}

                            </div>

                        </div>

                        {{-- PAYMENT METHOD --}}
                        <div class="mb-4">

                            <div class="payment-label mb-3">
                                Metode Pembayaran
                            </div>

                            <div class="row g-3">

                                <div class="col-4">

                                    <label class="payment-method active w-100">

                                        <input type="radio"
                                               name="payment_method"
                                               value="cash"
                                               checked>

                                        <div class="text-center">

                                            <div style="font-size:28px;">
                                                💵
                                            </div>

                                            <div class="fw-bold mt-2">
                                                Cash
                                            </div>

                                        </div>

                                    </label>

                                </div>

                                <div class="col-4">

                                    <label class="payment-method w-100">

                                        <input type="radio"
                                               name="payment_method"
                                               value="qris">

                                        <div class="text-center">

                                            <div style="font-size:28px;">
                                                📱
                                            </div>

                                            <div class="fw-bold mt-2">
                                                QRIS
                                            </div>

                                        </div>

                                    </label>

                                </div>

                                <div class="col-4">

                                    <label class="payment-method w-100">

                                        <input type="radio"
                                               name="payment_method"
                                               value="debit">

                                        <div class="text-center">

                                            <div style="font-size:28px;">
                                                💳
                                            </div>

                                            <div class="fw-bold mt-2">
                                                Debit
                                            </div>

                                        </div>

                                    </label>

                                </div>

                            </div>

                        </div>
<div class="card border-0 shadow-sm mb-4"
     style="border-radius:20px;">

    <div class="card-body">

        <h5 class="fw-bold mb-3">
            🎁 Discount
        </h5>

        <div class="row g-3">

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Jenis Discount
                </label>

                <select name="discount_type"
                        id="discountType"
                        class="form-select">

                    <option value="">
                        Tanpa Discount
                    </option>

                    <option value="nominal">
                        Nominal
                    </option>

                    <option value="percent">
                        Persen
                    </option>

                </select>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Nilai Discount
                </label>

                <input type="number"
                       name="discount_value"
                       id="discountValue"
                       class="form-control"
                       value="0"
                       min="0">

            </div>

        </div>

        <div class="mt-3">

            <div class="d-flex justify-content-between mb-2">

                <span>
                    Potongan
                </span>

                <strong id="discountAmount">
                    Rp 0
                </strong>

            </div>

            <div class="d-flex justify-content-between">

                <span class="fw-bold">
                    Total Setelah Discount
                </span>

                <h4 class="fw-bold text-primary"
                    id="finalTotal">

                    Rp {{ number_format($order->total) }}

                </h4>

            </div>

        </div>

    </div>

</div>
                        {{-- INPUT --}}
                        <div class="mb-4">

                            <div class="payment-label mb-3">
                                Uang Bayar
                            </div>

                        <input type="number"
                            name="bayar"
                            id="bayarInput"
                            class="money-input"
                            placeholder="0"
                            required>

                        </div>

                        {{-- QUICK MONEY --}}
                        <div class="row g-3 mb-4">

                            <div class="col-6">
                                <button type="button"
                                        class="quick-money w-100 add-money"
                                        data-value="10000">

                                    +10rb

                                </button>
                            </div>

                            <div class="col-6">
                                <button type="button"
                                        class="quick-money w-100 add-money"
                                        data-value="20000">

                                    +20rb

                                </button>
                            </div>

                            <div class="col-6">
                                <button type="button"
                                        class="quick-money w-100 add-money"
                                        data-value="50000">

                                    +50rb

                                </button>
                            </div>

                            <div class="col-6">
                                <button type="button"
                                        class="quick-money w-100 add-money"
                                        data-value="100000">

                                    +100rb

                                </button>
                            </div>

                            <div class="col-12">
                                <button type="button"
                                        id="exactMoney"
                                        class="quick-money w-100">

                                    Uang Pas

                                </button>
                            </div>

                        </div>

                        {{-- CHANGE --}}
                        <div class="change-box mb-4">

                            <div class="payment-label mb-2">
                                Kembalian
                            </div>

                            <div class="change-value"
                                 id="kembalianDisplay">

                                Rp 0

                            </div>

                        </div>

                        <button type="submit"
                                class="pay-button">

                            ✅ BAYAR SEKARANG

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

{{-- SUCCESS --}}
<div class="success-animation"
     id="successAnimation">

    <div class="success-circle">
        ✓
    </div>

    <h2 class="fw-bold">
        Pembayaran Berhasil
    </h2>

    <p class="opacity-75">
        Invoice sedang diproses...
    </p>

</div>

<audio id="successSound">
    <source src="{{ asset('audio/success.mp3') }}"
            type="audio/mpeg">
</audio>

<script>
    const bayarInput = document.getElementById('bayarInput');
    const kembalianDisplay = document.getElementById('kembalianDisplay');
    const discountType = document.getElementById('discountType');
    const discountValue = document.getElementById('discountValue');
    const discountAmount = document.getElementById('discountAmount');
    const finalTotalDisplay = document.getElementById('finalTotal');
    const exactMoney = document.getElementById('exactMoney');

    const subtotal = parseInt(document.getElementById('totalDisplay').dataset.total);

    let finalTotal = subtotal;

    function formatRupiah(number)
    {
        return new Intl.NumberFormat('id-ID').format(Math.round(number));
    }

    function calculateDiscount()
    {
        const type = discountType.value;
        const value = parseInt(discountValue.value) || 0;

        let discount = 0;

        if (type === 'percent') {
            discount = subtotal * value / 100;
        } else if (type === 'nominal') {
            discount = value;
        }

        if (discount > subtotal) {
            discount = subtotal;
        }

        finalTotal = subtotal - discount;

        discountAmount.innerHTML = 'Rp ' + formatRupiah(discount);
        finalTotalDisplay.innerHTML = 'Rp ' + formatRupiah(finalTotal);

        updateKembalian();
    }

    function updateKembalian()
    {
        const bayar = parseInt(bayarInput.value) || 0;
        const kembalian = bayar - finalTotal;

        if (kembalian < 0) {
            kembalianDisplay.innerHTML =
                `Kurang Rp ${formatRupiah(Math.abs(kembalian))}`;

            kembalianDisplay.style.color = '#f87171';
        } else {
            kembalianDisplay.innerHTML =
                `Rp ${formatRupiah(kembalian)}`;

            kembalianDisplay.style.color = '#4ade80';
        }
    }

    bayarInput.addEventListener('input', updateKembalian);
    discountType.addEventListener('change', calculateDiscount);
    discountValue.addEventListener('input', calculateDiscount);

    document.querySelectorAll('.add-money').forEach(button => {
        button.addEventListener('click', function () {
            const value = parseInt(this.dataset.value);
            const current = parseInt(bayarInput.value) || 0;

            bayarInput.value = current + value;

            updateKembalian();
        });
    });

    exactMoney.addEventListener('click', function () {
        bayarInput.value = Math.round(finalTotal);
        updateKembalian();
    });

    document.querySelectorAll('.payment-method').forEach(method => {
        method.addEventListener('click', function () {
            document.querySelectorAll('.payment-method').forEach(item => {
                item.classList.remove('active');
            });

            this.classList.add('active');
        });
    });

    calculateDiscount();
</script>
@endsection