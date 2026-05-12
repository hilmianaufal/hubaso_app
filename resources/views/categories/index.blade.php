@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <div>
        <h2 class="fw-bold mb-1">
            🏷️ Data Kategori
        </h2>

        <p class="text-muted mb-0">
            Kelola kategori menu restoran kamu
        </p>
    </div>

    <a href="/categories/create"
       class="btn btn-primary rounded-pill px-4 py-2">

        <i class="bi bi-plus-circle"></i>
        Tambah Kategori

    </a>

</div>

@if(session('success'))
    <div class="alert alert-success rounded-4">
        {{ session('success') }}
    </div>
@endif

<div class="card border-0 shadow-sm"
     style="border-radius: 26px; overflow: hidden;">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead style="background: #eff6ff;">
                    <tr>
                        <th class="px-4 py-3 text-muted">ID</th>
                        <th class="px-4 py-3 text-muted">Nama Kategori</th>
                        <th class="px-4 py-3 text-muted text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($categories as $category)

                    <tr>
                        <td class="px-4 py-3">
                            <span class="badge rounded-pill"
                                  style="background:#dbeafe; color:#2563eb;">
                                #{{ $category->id }}
                            </span>
                        </td>

                        <td class="px-4 py-3 fw-semibold">
                            {{ $category->nama }}
                        </td>

                        <td class="px-4 py-3">

                            <div class="d-flex justify-content-end gap-2">

                                <a href="/categories/{{ $category->id }}/edit"
                                   class="btn btn-warning btn-sm rounded-pill px-3">

                                    <i class="bi bi-pencil-square"></i>
                                    Edit

                                </a>

                                <form action="/categories/{{ $category->id }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm rounded-pill px-3"
                                            onclick="return confirm('Yakin hapus kategori ini?')">

                                        <i class="bi bi-trash"></i>
                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted">
                            Belum ada kategori
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection