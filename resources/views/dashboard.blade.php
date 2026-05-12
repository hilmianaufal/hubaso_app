@extends('layouts.app')

@section('content')

<style>
    .dashboard-title {
        font-weight: 700;
        color: #111827;
    }

    .dashboard-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    .stat-card {
        border: none;
        border-radius: 24px;
        background: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        transition: 0.25s;
        overflow: hidden;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-4px);
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 18px;
        background: linear-gradient(135deg, #2563eb, #60a5fa);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 18px;
    }

    .stat-label {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
    }

    .modern-card {
        border: none;
        border-radius: 26px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .modern-card-header {
        background: linear-gradient(135deg, #2563eb, #60a5fa);
        color: white;
        padding: 18px 22px;
        font-weight: 700;
    }

    .best-menu-box {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .best-menu-icon {
        width: 64px;
        height: 64px;
        border-radius: 22px;
        background: #eff6ff;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .chart-box {
        height: 400px;
    }

    @media(max-width: 576px) {
        .stat-value {
            font-size: 24px;
        }

        .chart-box {
            height: 320px;
        }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <div>
        <h2 class="dashboard-title mb-1">
            📊 Dashboard
        </h2>

        <div class="dashboard-subtitle">
            Ringkasan performa penjualan hari ini
        </div>
    </div>

    <div class="badge rounded-pill px-4 py-3"
         style="background:#eff6ff; color:#2563eb; font-weight:600;">

        {{ now()->format('d M Y') }}

    </div>

</div>

<div class="row">

    <div class="col-6 col-lg-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-receipt"></i>
                </div>

                <div class="stat-label">
                    Order Hari Ini
                </div>

                <div class="stat-value">
                    {{ $totalOrderHariIni }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <div class="stat-label">
                    Pendapatan
                </div>

                <div class="stat-value">
                    Rp {{ number_format($totalPendapatanHariIni) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-cup-hot"></i>
                </div>

                <div class="stat-label">
                    Total Menu
                </div>

                <div class="stat-value">
                    {{ $totalMenu }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>

                <div class="stat-label">
                    Order Pending
                </div>

                <div class="stat-value">
                    {{ $totalPending }}
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-lg-4 mb-4">
        <div class="card modern-card h-100">
<div class="card modern-card mt-4">

    <div class="modern-card-header">
        🔥 Menu Terlaris
    </div>

            <div class="card-body">

                @forelse($topMenus as $index => $item)

                <div class="mb-4">

                    <div class="d-flex justify-content-between mb-2">

                        <div class="fw-semibold">

                            @if($index == 0)
                                🥇
                            @elseif($index == 1)
                                🥈
                            @elseif($index == 2)
                                🥉
                            @endif

                            {{ $item->menu->nama ?? 'Menu Dihapus' }}

                        </div>

                        <div class="text-muted">

                            {{ $item->total_qty }} terjual

                        </div>

                    </div>

                    <div class="progress"
                        style="height: 10px; border-radius:999px;">

                        <div class="progress-bar"
                            role="progressbar"
                            style="
                                width: {{ ($item->total_qty / $topMenus->max('total_qty')) * 100 }}%;
                                background: linear-gradient(135deg,#2563eb,#60a5fa);
                            ">
                        </div>

                    </div>

                </div>

                @empty

                <p class="text-muted mb-0">
                    Belum ada data penjualan
                </p>

                @endforelse

            </div>

        </div>

            <div class="card-body">

                @if($menuTerlaris)

                    <div class="best-menu-box">

                        <div class="best-menu-icon">
                            🍜
                        </div>

                        <div>
                            <h4 class="fw-bold mb-1">
                                {{ $menuTerlaris->menu->nama ?? 'Menu Dihapus' }}
                            </h4>

                            <p class="text-muted mb-0">
                                Total terjual:
                                <strong>{{ $menuTerlaris->total_qty }}</strong>
                            </p>
                        </div>

                    </div>

                @else

                    <p class="text-muted mb-0">
                        Belum ada data order
                    </p>

                @endif

            </div>

        </div>
    </div>

    <div class="col-lg-8 mb-4">
        <div class="card modern-card">

            <div class="modern-card-header">
                📈 Grafik Penjualan
            </div>

            <div class="card-body">

                <div class="chart-box">
                    <canvas id="salesChart"></canvas>
                </div>

            </div>

        </div>
    </div>

</div>

<script>
const ctx = document.getElementById('salesChart');

new Chart(ctx, {
    type: 'line',

    data: {
        labels: @json($labels),

        datasets: [
            {
                label: 'Total Order',
                data: @json($orderData),
                borderWidth: 3,
                tension: 0.4
            },
            {
                label: 'Pendapatan',
                data: @json($pendapatanData),
                borderWidth: 3,
                tension: 0.4
            }
        ]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                labels: {
                    usePointStyle: true
                }
            }
        },

        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

@endsection