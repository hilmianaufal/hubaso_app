@extends('layouts.app')

@section('content')

<div class="mb-4">

    <h2 class="fw-bold mb-1">
        ➕ Tambah Kategori
    </h2>

    <p class="text-muted mb-0">
        Buat kategori baru untuk menu restoran
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

        <form action="/categories" method="POST">

            @csrf

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Nama Kategori
                </label>

                <input type="text"
                       name="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       style="border-radius: 16px; padding: 13px;"
                       placeholder="Contoh: Bakso, Mie, Minuman"
                       value="{{ old('nama') }}">

                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="d-flex gap-2">

                <button type="submit"
                        class="btn btn-primary rounded-pill px-4">

                    <i class="bi bi-save"></i>
                    Simpan

                </button>

                <a href="/categories"
                   class="btn btn-light rounded-pill px-4">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection