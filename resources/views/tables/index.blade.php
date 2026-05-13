@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <div>
        <h2 class="fw-bold mb-1">
            🪑 Data Meja
        </h2>

        <p class="text-muted mb-0">
            Kelola meja dan QR order customer
        </p>
    </div>

    <a href="/tables/create"
       class="btn btn-primary rounded-pill px-4 py-2">

        <i class="bi bi-plus-circle"></i>
        Tambah Meja

    </a>

</div>

@if(session('success'))
    <div class="alert alert-success rounded-4">
        {{ session('success') }}
    </div>
@endif

<div class="row">

    @forelse($tables as $table)

    <div class="col-12 col-md-6 col-xl-4 mb-4">

        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 26px; overflow: hidden;">

            <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start mb-3">

                    <div>
                        <span class="badge rounded-pill mb-2"
                              style="background:#dbeafe; color:#2563eb;">
                            #{{ $table->id }}
                        </span>

                        <h4 class="fw-bold mb-1">
                            {{ $table->nomor_meja }}
                        </h4>

                        <p class="text-muted mb-0">
                            Scan QR untuk order
                        </p>
                    </div>

                    <div class="rounded-4 d-flex align-items-center justify-content-center"
                         style="width:52px;height:52px;background:#eff6ff;color:#2563eb;font-size:24px;">
                        <i class="bi bi-qr-code"></i>
                    </div>

                </div>

                <div class="text-center p-3 rounded-4 mb-3"
                     style="background:#f8fafc;">

                    {!! QrCode::size(150)
                        ->generate(url('/order')) !!}

                </div>

                <div class="d-flex gap-2 flex-wrap">

                    <a href="{{ url('/order') }}"
                    target="_blank"
                    class="btn btn-light rounded-pill flex-fill">

                        <i class="bi bi-box-arrow-up-right"></i>
                        Buka Order

                    </a>

                    <a href="data:image/png;base64,{!! base64_encode(
                            QrCode::format('svg')
                                ->size(500)
                                ->margin(2)
                                ->generate(url('/order'))
                        ) !!}"
                    download="QR-{{ $table->nomor_meja }}.png"
                    class="btn btn-primary rounded-pill flex-fill">

                        <i class="bi bi-download"></i>
                        Download QR

                    </a>

                    <form action="{{ route('tables.destroy', $table->id) }}"
                        method="POST"
                        class="flex-fill"
                        onsubmit="return confirm('Yakin ingin menghapus meja ini?')">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger rounded-pill w-100">
                            <i class="bi bi-trash"></i>
                            Hapus
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    @empty

    <div class="col-12">

        <div class="card border-0 shadow-sm text-center"
             style="border-radius: 26px;">

            <div class="card-body py-5">

                <div class="mb-3"
                     style="font-size:48px;">
                    🪑
                </div>

                <h5 class="fw-bold">
                    Belum ada meja
                </h5>

                <p class="text-muted">
                    Tambahkan meja agar customer bisa scan QR dan order.
                </p>

                <a href="/tables/create"
                   class="btn btn-primary rounded-pill px-4">

                    Tambah Meja

                </a>

            </div>

        </div>

    </div>

    @endforelse

</div>

@endsection