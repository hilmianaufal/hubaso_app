@extends('layouts.app')

@section('content')

<style>
    .kitchen-card {
        border: none;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 12px 32px rgba(0,0,0,0.07);
        transition: 0.25s;
    }

    .kitchen-card:hover {
        transform: translateY(-4px);
    }

    .kitchen-header {
        background: linear-gradient(135deg, #2563eb, #60a5fa);
        color: white;
        padding: 22px;
    }

    .queue-box {
        width: 58px;
        height: 58px;
        border-radius: 20px;
        background: rgba(255,255,255,0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        flex-shrink: 0;
    }

    .menu-item-box {
        background: #f8fafc;
        border-radius: 18px;
        padding: 14px;
        margin-bottom: 12px;
    }

    .done-btn {
        border-radius: 16px;
        padding: 13px;
        font-weight: 700;
    }

    .sound-btn {
        border-radius: 999px;
        padding: 11px 18px;
        font-weight: 600;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <div>
        <h2 class="fw-bold mb-1">
            🍳 Monitor Dapur
        </h2>

        <p class="text-muted mb-0">
            Pantau pesanan yang sedang menunggu dimasak
        </p>
    </div>

    <div class="d-flex gap-2 flex-wrap">

        <button id="enableSoundBtn"
                class="btn btn-primary sound-btn">
            🔔 Aktifkan Suara
        </button>

        <button id="testSoundBtn"
                class="btn btn-light sound-btn">
            Tes Suara
        </button>

        <span class="badge rounded-pill px-4 py-3"
              style="background:#eff6ff;color:#2563eb;">
            {{ count($orders) }} Pesanan
        </span>

    </div>

</div>

<div class="row">

@forelse($orders as $order)

<div class="col-12 col-md-6 col-xl-4 mb-4">

    <div class="card kitchen-card h-100"
         data-order-id="{{ $order->id }}">

        <div class="kitchen-header">

            <div class="d-flex justify-content-between align-items-start gap-3">

                <div class="flex-grow-1">

                    <div class="d-flex align-items-center gap-2 flex-wrap mb-3">

                        <div class="badge rounded-pill px-3 py-2"
                             style="background:rgba(255,255,255,0.18);font-size:15px;">
                            🎟️ {{ $order->queue_number ?? '-' }}
                        </div>

                        @if($order->status == 'pending')
                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                🔴 Pending
                            </span>
                        @elseif($order->status == 'diproses')
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                🟡 Diproses
                            </span>
                        @elseif($order->status == 'selesai')
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                🟢 Selesai
                            </span>
                        @endif

                    </div>

                    <h4 class="fw-bold mb-2">

                        @if($order->jenis_pesanan == 'Bungkus')
                            🛍️ Bungkus
                        @else
                            🪑 Meja {{ $order->nomor_meja_manual ?? '-' }}
                        @endif

                    </h4>

                    <div class="small mb-2"
                         style="opacity:.92;">
                        👤 {{ $order->nama_customer }}
                    </div>

                    @php
                        $minutes = floor($order->created_at->diffInMinutes(now()));
                    @endphp

                    <div>
                        @if($minutes >= 20)
                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                🔥 {{ $minutes }} menit lalu
                            </span>
                        @elseif($minutes >= 10)
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                ⏰ {{ $minutes }} menit lalu
                            </span>
                        @else
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                🟢 {{ $minutes }} menit lalu
                            </span>
                        @endif
                    </div>

                </div>

                <div class="queue-box">
                    🍜
                </div>

            </div>

        </div>

        <div class="card-body p-4">

            @foreach($order->items as $item)

                <div class="menu-item-box">

                    <div class="d-flex justify-content-between align-items-center gap-3">

                        <div>
                            <h5 class="fw-bold mb-1">
                                {{ $item->menu->nama ?? 'Menu Dihapus' }}
                            </h5>

                            <small class="text-muted">
                                Qty pesanan
                            </small>
                        </div>

                        <span class="badge rounded-pill px-3 py-2"
                              style="background:#dbeafe;color:#2563eb;font-size:15px;">
                            x{{ $item->qty }}
                        </span>

                    </div>

                </div>

            @endforeach

            @if($order->catatan)

                <div class="mt-3 p-3 rounded-4"
                     style="background:#fef3c7;">

                    <small class="fw-bold text-dark">
                        📝 Catatan
                    </small>

                    <div class="small text-muted mt-1">
                        {{ $order->catatan }}
                    </div>

                </div>

            @endif

            <div class="d-flex gap-2 mt-4">

                @if($order->status == 'pending')

                    <form action="/kitchen/{{ $order->id }}/process"
                          method="POST"
                          class="flex-fill">

                        @csrf
                        @method('PUT')

                        <button class="btn btn-warning w-100 done-btn">
                            👨‍🍳 Sedang Dimasak
                        </button>

                    </form>

                @elseif($order->status == 'diproses')

                    <form action="/kitchen/{{ $order->id }}/done"
                          method="POST"
                          class="flex-fill">

                        @csrf
                        @method('PUT')

                        <button class="btn btn-success w-100 done-btn">
                            ✅ Siap Diambil
                        </button>

                    </form>

                @else

                    <button class="btn btn-secondary w-100 done-btn"
                            disabled>
                        ✔ Sudah Selesai
                    </button>

                @endif

            </div>

        </div>

    </div>

</div>

@empty

<div class="col-12">

    <div class="card border-0 shadow-sm text-center"
         style="border-radius:28px;">

        <div class="card-body py-5">

            <div style="font-size:56px;">
                🍳
            </div>

            <h5 class="fw-bold mt-3">
                Tidak ada pesanan dapur
            </h5>

            <p class="text-muted mb-0">
                Pesanan baru akan muncul otomatis di sini.
            </p>

        </div>

    </div>

</div>

@endforelse

</div>

<audio id="notifSound" preload="auto" playsinline>
    <source src="{{ asset('audio/dapur.mp3') }}" type="audio/mpeg">
</audio>

<script>
    const sound = document.getElementById('notifSound');
    const enableSoundBtn = document.getElementById('enableSoundBtn');
    const testSoundBtn = document.getElementById('testSoundBtn');

    let soundEnabled = localStorage.getItem('hubasoKitchenSound') === 'active';

    let lastOrderId = Math.max(
        ...Array.from(document.querySelectorAll('.kitchen-card'))
            .map(card => parseInt(card.dataset.orderId))
            .filter(id => !isNaN(id)),
        0
    );

    function updateSoundButton()
    {
        if (!enableSoundBtn) return;

        if (soundEnabled) {
            enableSoundBtn.innerHTML = '✅ Suara Aktif';
            enableSoundBtn.classList.remove('btn-primary');
            enableSoundBtn.classList.add('btn-success');
        } else {
            enableSoundBtn.innerHTML = '🔔 Aktifkan Suara';
            enableSoundBtn.classList.remove('btn-success');
            enableSoundBtn.classList.add('btn-primary');
        }
    }

    function unlockSound()
    {
        sound.muted = true;
        sound.currentTime = 0;

        return sound.play()
            .then(() => {
                sound.pause();
                sound.currentTime = 0;
                sound.muted = false;

                soundEnabled = true;
                localStorage.setItem('hubasoKitchenSound', 'active');

                updateSoundButton();
            })
            .catch(() => {
                soundEnabled = false;
                localStorage.removeItem('hubasoKitchenSound');

                updateSoundButton();
            });
    }

    function playNotification()
    {
        if (!soundEnabled) return;

        sound.muted = false;
        sound.currentTime = 0;

        sound.play().catch(() => {
            soundEnabled = false;
            localStorage.removeItem('hubasoKitchenSound');
            updateSoundButton();
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateSoundButton();

        // Coba aktifkan otomatis saat halaman dibuka
        unlockSound();
    });

    enableSoundBtn.addEventListener('click', function () {
        unlockSound();
    });

    testSoundBtn.addEventListener('click', function () {
        soundEnabled = true;
        localStorage.setItem('hubasoKitchenSound', 'active');
        updateSoundButton();

        sound.muted = false;
        sound.currentTime = 0;

        sound.play().catch(error => {
            alert('Suara gagal diputar. Cek file audio atau izin browser.');
            console.log(error);
        });
    });

    setInterval(() => {
        fetch('/kitchen')
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const html = parser.parseFromString(data, 'text/html');

                const ids = Array.from(html.querySelectorAll('.kitchen-card'))
                    .map(card => parseInt(card.dataset.orderId))
                    .filter(id => !isNaN(id));

                const newestOrderId = ids.length > 0 ? Math.max(...ids) : 0;

                if (newestOrderId > lastOrderId) {
                    lastOrderId = newestOrderId;

                    playNotification();

                    setTimeout(() => {
                        location.reload();
                    }, 2500);
                }
            })
            .catch(error => {
                console.log('Gagal cek order dapur:', error);
            });
    }, 5000);
</script>
@endsection