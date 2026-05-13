@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h2 class="fw-bold mb-1">➕ Tambah User</h2>
    <p class="text-muted mb-0">Buat akun baru untuk admin, kasir, atau dapur</p>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 26px;">
    <div class="card-body p-4">

        @if($errors->any())
            <div class="alert alert-danger rounded-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/users" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       style="border-radius:16px;padding:13px;"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Kasir 1">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       style="border-radius:16px;padding:13px;"
                       value="{{ old('email') }}"
                       placeholder="kasir@email.com">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       style="border-radius:16px;padding:13px;"
                       placeholder="Minimal 6 karakter">
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Role</label>
                <select name="role"
                        class="form-control"
                        style="border-radius:16px;padding:13px;">
                    <option value="">-- Pilih Role --</option>
                    <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="dapur" {{ old('role') == 'dapur' ? 'selected' : '' }}>Dapur</option>
                </select>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-save"></i>
                    Simpan
                </button>

                <a href="/users"
                   class="btn btn-light rounded-pill px-4">
                    Kembali
                </a>
            </div>

        </form>

    </div>
</div>

@endsection