@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1">🍜 Data Menu</h2>
        <p class="text-muted mb-0">Kelola menu makanan dan minuman restoran</p>
    </div>

    <a href="/menus/create" class="btn btn-primary rounded-pill px-4 py-2">
        <i class="bi bi-plus-circle"></i>
        Tambah Menu
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4">
        {{ session('success') }}
    </div>
@endif

<div class="row">

    @forelse($menus as $menu)

    <div class="col-6 col-md-4 col-xl-3 mb-4">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 24px; overflow: hidden;">

            @if($menu->foto)
                <img src="{{ asset($menu->foto) }}"
                    style="height: 180px; object-fit: cover;"
                    class="card-img-top">
            @else
                <div class="d-flex align-items-center justify-content-center bg-light"
                    style="height: 180px;">
                    <span class="text-muted">Tidak ada foto</span>
                </div>
            @endif

            <div class="card-body d-flex flex-column">

                <span class="badge rounded-pill mb-2 align-self-start"
                      style="background:#dbeafe; color:#2563eb;">
                    {{ $menu->category->nama ?? 'Tanpa Kategori' }}
                </span>

                <h5 class="fw-bold mb-1">
                    {{ $menu->nama }}
                </h5>

                <div class="fw-bold text-primary mb-2">
                    Rp {{ number_format($menu->harga) }}
                </div>

                <div class="mb-3">
                    @if($menu->stok <= 0)
                        <span class="badge bg-danger rounded-pill">Stok Habis</span>
                    @elseif($menu->stok <= 5)
                        <span class="badge bg-warning text-dark rounded-pill">
                            Stok Menipis: {{ $menu->stok }}
                        </span>
                    @else
                        <span class="badge bg-success rounded-pill">
                            Stok: {{ $menu->stok }}
                        </span>
                    @endif
                </div>

                <div class="d-flex gap-2 mt-auto">

                    <a href="/menus/{{ $menu->id }}/edit"
                       class="btn btn-warning btn-sm rounded-pill flex-fill">

                        <i class="bi bi-pencil-square"></i>
                        Edit

                    </a>

                    <form action="/menus/{{ $menu->id }}"
                          method="POST"
                          class="flex-fill">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm rounded-pill w-100"
                                onclick="return confirm('Yakin hapus menu ini?')">

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
             style="border-radius: 24px;">

            <div class="card-body py-5">
                <h5 class="fw-bold">Belum ada menu</h5>
                <p class="text-muted mb-3">Tambahkan menu pertama kamu sekarang.</p>

                <a href="/menus/create" class="btn btn-primary rounded-pill px-4">
                    Tambah Menu
                </a>
            </div>

        </div>
    </div>

    @endforelse

</div>

@endsection