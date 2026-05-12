@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold mb-1">✏️ Edit Menu</h2>
    <p class="text-muted mb-0">Perbarui informasi menu restoran</p>
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

        <form action="/menus/{{ $menu->id }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Menu</label>

                    <input type="text"
                           name="nama"
                           class="form-control @error('nama') is-invalid @enderror"
                           style="border-radius: 16px; padding: 13px;"
                           value="{{ old('nama', $menu->nama) }}">

                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Kategori</label>

                    <select name="category_id"
                            class="form-control @error('category_id') is-invalid @enderror"
                            style="border-radius: 16px; padding: 13px;">

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->nama }}
                            </option>
                        @endforeach

                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Harga</label>

                    <input type="number"
                           name="harga"
                           class="form-control @error('harga') is-invalid @enderror"
                           style="border-radius: 16px; padding: 13px;"
                           value="{{ old('harga', $menu->harga) }}">

                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Stok</label>

                    <input type="number"
                           name="stok"
                           class="form-control @error('stok') is-invalid @enderror"
                           style="border-radius: 16px; padding: 13px;"
                           value="{{ old('stok', $menu->stok) }}">

                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($menu->foto)
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Foto Saat Ini</label>

                    <img src="{{ asset('storage/' . $menu->foto) }}"
                         class="w-100 shadow-sm"
                         style="height: 180px; object-fit: cover; border-radius: 20px;">
                </div>
                @endif

                <div class="{{ $menu->foto ? 'col-md-8' : 'col-12' }} mb-4">
                    <label class="form-label fw-semibold">Ganti Foto</label>

                    <input type="file"
                           name="foto"
                           class="form-control @error('foto') is-invalid @enderror"
                           style="border-radius: 16px; padding: 13px;"
                           accept="image/*">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti foto.
                    </small>

                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="d-flex gap-2 flex-wrap">

                <button class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-check-circle"></i>
                    Update
                </button>

                <a href="/menus"
                   class="btn btn-light rounded-pill px-4">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

@endsection