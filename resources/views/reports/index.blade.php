@extends('layouts.app')

@section('content')

<style>
    .report-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .report-header {
        background: linear-gradient(135deg, #2563eb, #60a5fa);
        color: white;
        padding: 22px;
    }

    .summary-box {
        background: #f8fafc;
        border-radius: 20px;
        padding: 18px;
    }

    .form-control {
        border-radius: 14px;
        padding: 12px;
    }

    .btn-modern {
        border-radius: 14px;
        padding: 12px 18px;
        font-weight: 600;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1">📄 Laporan Penjualan</h2>
        <p class="text-muted mb-0">Generate dan export laporan penjualan harian</p>
    </div>
</div>

<div class="card report-card mb-4">
    <div class="card-body p-4">

        <form action="/reports/generate" method="POST">
            @csrf

            <div class="row g-3 align-items-end">

                <div class="col-md-5">
                    <label class="form-label fw-semibold">Pilih Tanggal</label>

                    <input type="date"
                           name="tanggal"
                           class="form-control"
                           value="{{ old('tanggal', $tanggal ?? '') }}"
                           required>
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary btn-modern w-100">
                        <i class="bi bi-search"></i>
                        Generate
                    </button>
                </div>

            </div>

        </form>

    </div>
</div>

@if(isset($orders))

<div class="row mb-4">

    <div class="col-md-4 mb-3">
        <div class="summary-box">
            <small class="text-muted">Tanggal</small>
            <h5 class="fw-bold mb-0">
                {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}
            </h5>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="summary-box">
            <small class="text-muted">Total Order</small>
            <h5 class="fw-bold mb-0">
                {{ $orders->count() }}
            </h5>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="summary-box">
            <small class="text-muted">Total Pendapatan</small>
            <h5 class="fw-bold text-primary mb-0">
                Rp {{ number_format($totalPendapatan) }}
            </h5>
        </div>
    </div>

</div>

<div class="d-flex gap-2 mb-4 flex-wrap">

    <a href="/reports/pdf?tanggal={{ $tanggal }}"
       class="btn btn-danger rounded-pill px-4">

        <i class="bi bi-file-earmark-pdf"></i>
        Export PDF

    </a>

    <a href="/reports/excel?tanggal={{ $tanggal }}"
       class="btn btn-success rounded-pill px-4">

        <i class="bi bi-file-earmark-excel"></i>
        Export Excel

    </a>

</div>

<div class="card report-card">

    <div class="report-header">
        <h5 class="mb-0 fw-bold">
            Hasil Laporan
        </h5>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead style="background:#eff6ff;">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Meja</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($orders as $order)

                    <tr>
                        <td class="px-4 py-3">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $order->table->nomor_meja ?? '-' }}
                        </td>

                        <td class="px-4 py-3 fw-semibold">
                            {{ $order->nama_customer }}
                        </td>

                        <td class="px-4 py-3 fw-bold text-primary">
                            Rp {{ number_format($order->total) }}
                        </td>

                        <td class="px-4 py-3">
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark rounded-pill">Pending</span>
                            @elseif($order->status == 'diproses')
                                <span class="badge bg-primary rounded-pill">Diproses</span>
                            @elseif($order->status == 'selesai')
                                <span class="badge bg-success rounded-pill">Selesai</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">{{ $order->status }}</span>
                            @endif
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            Tidak ada data laporan pada tanggal ini.
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