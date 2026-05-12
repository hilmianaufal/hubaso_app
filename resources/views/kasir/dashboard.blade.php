@extends('layouts.app')

@section('content')

<style>
    .stat-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 12px 32px rgba(0,0,0,0.06);
        transition: .25s;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .icon-box {
        width: 64px;
        height: 64px;
        border-radius: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <div>
        <h2 class="fw-bold mb-1">
            💳 Dashboard Kasir
        </h2>

        <p class="text-muted mb-0">
            Ringkasan transaksi hari ini
        </p>
    </div>

    <a href="/kasir/orders"
       class="btn btn-primary rounded-pill px-4">

        🧾 Lihat Order

    </a>

</div>

<div class="row">

    <div class="col-md-6 col-xl-3 mb-4">

        <div class="card stat-card">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Order
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $totalOrderHariIni }}
                        </h2>

                    </div>

                    <div class="icon-box"
                         style="background:#dbeafe;color:#2563eb;">

                        🧾

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3 mb-4">

        <div class="card stat-card">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Pending Payment
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $pendingPayment }}
                        </h2>

                    </div>

                    <div class="icon-box"
                         style="background:#fee2e2;color:#dc2626;">

                        ⏳

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3 mb-4">

        <div class="card stat-card">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total Cash
                        </small>

                        <h4 class="fw-bold mt-2">
                            Rp {{ number_format($totalCash) }}
                        </h4>

                    </div>

                    <div class="icon-box"
                         style="background:#dcfce7;color:#16a34a;">

                        💵

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3 mb-4">

        <div class="card stat-card">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <small class="text-muted">
                            Total QRIS
                        </small>

                        <h4 class="fw-bold mt-2">
                            Rp {{ number_format($totalQris) }}
                        </h4>

                    </div>

                    <div class="icon-box"
                         style="background:#ede9fe;color:#7c3aed;">

                        📱

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection