@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold mb-1">👥 Manajemen User</h2>
        <p class="text-muted mb-0">Kelola akun owner, admin, kasir, dan dapur</p>
    </div>

    <a href="/users/create"
       class="btn btn-primary rounded-pill px-4 py-2">
        <i class="bi bi-plus-circle"></i>
        Tambah User
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success rounded-4">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger rounded-4">
        {{ $errors->first() }}
    </div>
@endif

<div class="card border-0 shadow-sm" style="border-radius: 26px; overflow:hidden;">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead style="background:#eff6ff;">
                <tr>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3 text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="px-4 py-3 fw-semibold">
                            {{ $user->name }}
                        </td>

                        <td class="px-4 py-3 text-muted">
                            {{ $user->email }}
                        </td>

                        <td class="px-4 py-3">
                            <span class="badge rounded-pill px-3 py-2
                                @if($user->role == 'owner') bg-dark
                                @elseif($user->role == 'admin') bg-primary
                                @elseif($user->role == 'kasir') bg-success
                                @else bg-warning text-dark
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>

                        <td class="px-4 py-3">
                            <div class="d-flex justify-content-end gap-2 flex-wrap">
                                <a href="/users/{{ $user->id }}/edit"
                                   class="btn btn-warning btn-sm rounded-pill px-3">
                                    <i class="bi bi-pencil-square"></i>
                                    Edit
                                </a>

                                <form action="/users/{{ $user->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm rounded-pill px-3"
                                            {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            Belum ada user
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection