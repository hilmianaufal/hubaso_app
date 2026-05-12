@extends('layouts.app')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        ➕ Tambah Meja
    </h2>

    <p class="text-muted mb-0">
        Buat nomor meja baru untuk QR order customer
    </p>

</div>

<div class="card border-0 shadow-sm"
     style="border-radius: 26px;">

    <div class="card-body p-4">

        @if ($errors->any())

            <div class="alert alert-danger rounded-4">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        <form action="/tables" method="POST">

            @csrf

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Nomor Meja
                </label>

                <input type="text"
                       name="nomor_meja"
                       class="form-control @error('nomor_meja') is-invalid @enderror"
                       style="border-radius: 16px; padding: 13px;"
                       placeholder="Contoh: Meja 1"
                       value="{{ old('nomor_meja') }}">

                @error('nomor_meja')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

                <small class="text-muted">
                    Setelah disimpan, QR Code otomatis tersedia di halaman data meja.
                </small>

            </div>

            <div class="d-flex gap-2 flex-wrap">

                <button class="btn btn-primary rounded-pill px-4">

                    <i class="bi bi-save"></i>
                    Simpan

                </button>

                <a href="/tables"
                   class="btn btn-light rounded-pill px-4">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection