@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f3f6fb;
    }

    .page-hero {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: white;
        border-radius: 28px;
        padding: 28px;
        box-shadow: 0 18px 40px rgba(37, 99, 235, .18);
    }

    .modern-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 12px 32px rgba(15, 23, 42, .07);
        overflow: hidden;
    }

    .summary-card {
        background: white;
        border-radius: 24px;
        padding: 22px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .06);
        height: 100%;
    }

    .summary-label {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .summary-value {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
    }

    .form-control {
        border-radius: 16px;
        padding: 13px;
        border: 1px solid #e2e8f0;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .12);
    }

    .btn-modern {
        border-radius: 16px;
        padding: 13px 20px;
        font-weight: 700;
    }

    .table thead th {
        background: #eff6ff;
        color: #1e40af;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-bottom: none;
    }

    .table tbody td {
        vertical-align: middle;
        border-color: #eef2f7;
    }

    .order-type {
        background: #f8fafc;
        color: #334155;
        border-radius: 999px;
        padding: 7px 12px;
        font-weight: 700;
        font-size: 13px;
        display: inline-block;
    }

    .amount {
        color: #2563eb;
        font-weight: 800;
    }

    .badge-status {
        border-radius: 999px;
        padding: 8px 13px;
        font-size: 12px;
        font-weight: 700;
    }

    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-process {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-done {
        background: #dcfce7;
        color: #166534;
    }

    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #64748b;
    }
</style>

<div class="page-hero mb-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>
            <h2 class="fw-bold mb-2">
                📊 Laporan Penjualan
            </h2>

            <p class="mb-0" style="opacity:.85;">
                Generate, cek, dan export laporan transaksi HUBASO
            </p>
        </div>

        <div class="badge rounded-pill px-4 py-3"
             style="background:rgba(255,255,255,.16);">
            Restaurant POS Report
        </div>

    </div>

</div>

<div class="card modern-card mb-4">
    <div class="card-body p-4">

        <form action="/reports/generate" method="POST">
            @csrf

            <div class="row g-3 align-items-end">

                <div class="col-md-5">
                    <label class="form-label fw-bold">
                        Pilih Tanggal Laporan
                    </label>

                    <input type="date"
                           name="tanggal"
                           class="form-control"
                           value="{{ old('tanggal', $tanggal ?? '') }}"
                           required>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary btn-modern w-100">
                        🔍 Generate
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@if(isset($orders))

<div class="row g-4 mb-4">

    <div class="col-md-4">
        <div class="summary-card">
            <div class="summary-label">Tanggal</div>
            <div class="summary-value">
                {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="summary-card">
            <div class="summary-label">Total Order</div>
            <div class="summary-value">
                {{ $orders->count() }}
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="summary-card">
            <div class="summary-label">Total Pendapatan</div>
            <div class="summary-value text-primary">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </div>
        </div>
    </div>

</div>

<div class="d-flex gap-2 mb-4 flex-wrap">

    <a href="/reports/pdf?tanggal={{ $tanggal }}"
       class="btn btn-danger btn-modern">
        📄 Export PDF
    </a>

    <a href="/reports/excel?tanggal={{ $tanggal }}"
       class="btn btn-success btn-modern">
        📗 Export Excel
    </a>

</div>

<div class="card modern-card">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead>
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Tipe</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Meja / Bungkus</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($orders as $order)

                    <tr>
                        <td class="px-4 py-3 fw-bold">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="order-type">
                                {{ $order->jenis_pesanan ?? '-' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 fw-semibold">
                            {{ $order->nama_customer ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            @if($order->jenis_pesanan == 'Bungkus')
                                🛍️ Bungkus
                            @else
                                🪑 Meja {{ $order->table->nomor_meja ?? $order->nomor_meja_manual ?? '-' }}
                            @endif
                        </td>

                        <td class="px-4 py-3 amount">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </td>

                        <td class="px-4 py-3">
                            @if($order->status == 'pending')
                                <span class="badge-status badge-pending">
                                    Pending
                                </span>
                            @elseif($order->status == 'diproses')
                                <span class="badge-status badge-process">
                                    Diproses
                                </span>
                            @elseif($order->status == 'selesai')
                                <span class="badge-status badge-done">
                                    Selesai
                                </span>
                            @else
                                <span class="badge bg-secondary rounded-pill">
                                    {{ $order->status ?? '-' }}
                                </span>
                            @endif
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div style="font-size:52px;">📭</div>
                                <h5 class="fw-bold mt-3">
                                    Tidak ada data laporan
                                </h5>
                                <p class="mb-0">
                                    Belum ada transaksi pada tanggal ini.
                                </p>
                            </div>
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endif

@endsection