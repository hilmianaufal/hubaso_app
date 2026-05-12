@extends('layouts.app')

@section('content')

<style>
    .page-title {
        font-weight: 700;
        color: #111827;
    }

    .order-card {
        border: none;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        transition: 0.25s;
    }

    .order-card:hover {
        transform: translateY(-3px);
    }

    .order-header {
        background: linear-gradient(135deg, #2563eb, #60a5fa);
        color: white;
        padding: 22px;
    }

    .queue-badge {
        background: rgba(255,255,255,0.18);
        border-radius: 18px;
        padding: 12px 16px;
        font-size: 26px;
        font-weight: 700;
    }

    .info-chip {
        background: rgba(255,255,255,0.16);
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 13px;
        display: inline-block;
        margin-top: 8px;
    }

    .menu-row {
        background: #f8fafc;
        border-radius: 18px;
        padding: 14px;
        margin-bottom: 10px;
    }

    .form-select {
        border-radius: 14px;
        padding: 11px;
    }

    .btn-modern {
        border-radius: 14px;
        padding: 11px 16px;
        font-weight: 600;
        white-space: nowrap;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="page-title mb-1">
            🧾 Order Masuk
        </h2>

        <p class="text-muted mb-0">
            Pantau pesanan customer dan status pembayaran
        </p>
    </div>

    <span class="badge rounded-pill px-4 py-3"
          style="background:#eff6ff;color:#2563eb;">
        {{ count($orders) }} Order
    </span>
</div>
<div class="card border-0 shadow-sm mb-4"
     style="border-radius: 22px;">

    <div class="card-body">

        <div class="row g-3">

            <div class="col-md-5">
                <input type="text"
                       id="searchOrder"
                       class="form-control"
                       placeholder="Cari meja, nama customer, nomor antrian...">
            </div>

            <div class="col-md-3">
                <select id="filterPayment"
                        class="form-select">
                    <option value="all">Semua Pembayaran</option>
                    <option value="unpaid">Belum Bayar</option>
                    <option value="waiting_verification">Menunggu Verifikasi</option>
                    <option value="paid">Sudah Bayar</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>

            <div class="col-md-3">
                <select id="filterStatus"
                        class="form-select">
                    <option value="all">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <div class="col-md-1">
                <button type="button"
                        id="resetFilter"
                        class="btn btn-light w-100">
                    Reset
                </button>
            </div>

        </div>

    </div>

</div>
@forelse($orders as $order)

<div class="card order-card mb-4"
     data-search="{{ strtolower($order->queue_number . ' ' . $order->nama_customer . ' ' . $order->nomor_meja_manual . ' ' . $order->jenis_pesanan) }}"
     data-payment="{{ $order->payment_status }}"
     data-status="{{ $order->status }}">

    <div class="order-header">

<div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

    <div>

        <div class="queue-badge mb-3">
            {{ $order->queue_number }}
        </div>

        <h5 class="fw-bold mb-2">

            @if($order->jenis_pesanan == 'Bungkus')

                🛍️ Bungkus

            @else

                🪑 Meja {{ $order->nomor_meja_manual ?? '-' }}

            @endif

        </h5>

        <div class="d-flex flex-wrap gap-2">

            <div class="info-chip">
                👤 {{ $order->nama_customer }}
            </div>

            <div class="info-chip">
                🍽️ {{ $order->jenis_pesanan }}
            </div>

            @if($order->catatan)

                <div class="info-chip"
                     style="background:#fef3c7;color:#92400e;">

                    📝 {{ $order->catatan }}

                </div>

            @endif

        </div>

    </div>

    <div class="text-end">

        <div class="mb-2">

            @if($order->payment_status == 'unpaid')

                <span class="badge bg-danger rounded-pill">
                    Belum Bayar
                </span>

            @elseif($order->payment_status == 'waiting_verification')

                <span class="badge bg-warning text-dark rounded-pill">
                    Menunggu Verifikasi
                </span>

            @elseif($order->payment_status == 'paid')

                <span class="badge bg-success rounded-pill">
                    Sudah Bayar
                </span>

            @elseif($order->payment_status == 'rejected')

                <span class="badge bg-secondary rounded-pill">
                    Ditolak
                </span>

            @endif

        </div>

        <div class="mb-3">

            @if($order->status == 'pending')

                <span class="badge bg-warning text-dark rounded-pill">
                    Pending
                </span>

            @elseif($order->status == 'diproses')

                <span class="badge bg-primary rounded-pill">
                    Diproses
                </span>

            @elseif($order->status == 'selesai')

                <span class="badge bg-success rounded-pill">
                    Selesai
                </span>

            @endif

        </div>

        @if(auth()->check() && auth()->user()->role == 'admin')

            <form action="/orders/{{ $order->id }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus order ini?')">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger btn-sm rounded-pill px-3">

                    🗑️ Hapus

                </button>

            </form>

        @endif

    </div>

</div>

    </div>

    <div class="card-body p-4">

        @foreach($order->items as $item)

        <div class="menu-row d-flex justify-content-between align-items-center">

            <div>
                <strong>
                    {{ $item->menu->nama ?? 'Menu Dihapus' }}
                </strong>

                <br>

                <small class="text-muted">
                    Qty: {{ $item->qty }}
                </small>
            </div>

            <div class="fw-bold">
                Rp {{ number_format($item->subtotal) }}
            </div>

        </div>

        @endforeach

        <div class="d-flex justify-content-between align-items-center mt-3 mb-4">

            <span class="text-muted">
                Total Pembayaran
            </span>

            <h4 class="fw-bold mb-0 text-primary">
                Rp {{ number_format($order->total) }}
            </h4>

        </div>

        <div class="row g-3">

            <div class="col-md-6">

                <form action="/kasir/orders/{{ $order->id }}/status"
                      method="POST">

                    @csrf
                    @method('PUT')

                    <label class="form-label fw-semibold">
                        Status Order
                    </label>

                    <div class="d-flex gap-2">

                        <select name="status" class="form-select">

                            <option value="pending"
                                {{ $order->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="diproses"
                                {{ $order->status == 'diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>

                            <option value="selesai"
                                {{ $order->status == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>

                        </select>

                        <button class="btn btn-primary btn-modern">
                            Update
                        </button>

                    </div>

                </form>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-semibold">
                    Status Pembayaran
                </label>

                <div class="d-flex gap-2 flex-wrap">

                    <form action="/kasir/orders/{{ $order->id }}/payment"
                          method="POST"
                          class="d-flex gap-2 flex-grow-1">

                        @csrf
                        @method('PUT')

                        <select name="payment_status"
                                class="form-select">

                            <option value="unpaid"
                                {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>
                                Belum Bayar
                            </option>

                            <option value="waiting_verification"
                                {{ $order->payment_status == 'waiting_verification' ? 'selected' : '' }}>
                                Menunggu Verifikasi
                            </option>

                            <option value="paid"
                                {{ $order->payment_status == 'paid' ? 'selected' : '' }}>
                                Sudah Bayar
                            </option>

                            <option value="rejected"
                                {{ $order->payment_status == 'rejected' ? 'selected' : '' }}>
                                Ditolak
                            </option>

                        </select>

                        <button class="btn btn-success btn-modern">
                            Update
                        </button>

                    </form>

                    <a href="/invoice/{{ $order->id }}"
                       target="_blank"
                       class="btn btn-dark btn-modern">

                        🖨️ Print

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@empty

<div class="card border-0 shadow-sm text-center"
     style="border-radius:26px;">

    <div class="card-body py-5">

        <div style="font-size:48px;">
            🧾
        </div>

        <h5 class="fw-bold mt-3">
            Belum ada order masuk
        </h5>

        <p class="text-muted mb-0">
            Pesanan customer akan muncul di sini.
        </p>

    </div>

</div>

@endforelse

<audio id="notifSound" preload="auto">
    <source src="{{ asset('audio/notif.mp3') }}"
            type="audio/mpeg">
</audio>

<script>
let lastOrderCount = {{ count($orders) }};

setInterval(() => {
    fetch('/kasir/orders')
        .then(response => response.text())
        .then(data => {
            let parser = new DOMParser();

            let html = parser.parseFromString(data, 'text/html');

            let newCount = html.querySelectorAll('.order-card').length;

            if (newCount > lastOrderCount) {
                const sound = document.getElementById('notifSound');

                sound.currentTime = 0;

                sound.play().catch(() => {});

                lastOrderCount = newCount;

                setTimeout(() => {
                    location.reload();
                }, 2500);
            }
        });
}, 5000);
</script>
<script>
const searchOrder = document.getElementById('searchOrder');
const filterPayment = document.getElementById('filterPayment');
const filterStatus = document.getElementById('filterStatus');
const resetFilter = document.getElementById('resetFilter');

function filterOrders()
{
    const keyword = searchOrder.value.toLowerCase();
    const payment = filterPayment.value;
    const status = filterStatus.value;

    document.querySelectorAll('.order-card').forEach(card => {
        const searchText = card.dataset.search || '';
        const cardPayment = card.dataset.payment || '';
        const cardStatus = card.dataset.status || '';

        const matchSearch = searchText.includes(keyword);
        const matchPayment = payment === 'all' || cardPayment === payment;
        const matchStatus = status === 'all' || cardStatus === status;

        if (matchSearch && matchPayment && matchStatus) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}

searchOrder.addEventListener('keyup', filterOrders);
filterPayment.addEventListener('change', filterOrders);
filterStatus.addEventListener('change', filterOrders);

resetFilter.addEventListener('click', function () {
    searchOrder.value = '';
    filterPayment.value = 'all';
    filterStatus.value = 'all';
    filterOrders();
});
</script>
@endsection