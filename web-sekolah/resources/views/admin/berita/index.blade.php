@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page-title', 'Berita &amp; Pengumuman — Berita')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="font-size:.85rem;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="section-card">
    <div class="section-header">
        <h6><i class="bi bi-newspaper me-2 text-primary"></i>Daftar Berita</h6>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-sm"
           style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Berita
        </a>
    </div>

    @if ($berita->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-newspaper" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada berita. Klik "Tambah Berita" untuk mulai.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover activity-table mb-0">
                <thead>
                    <tr>
                        <th style="width:44px;">#</th>
                        <th>Judul</th>
                        <th class="d-none d-md-table-cell">Kategori</th>
                        <th class="d-none d-lg-table-cell">Tanggal</th>
                        <th class="d-none d-md-table-cell">Penulis</th>
                        <th>Status</th>
                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($berita as $item)
                        <tr>
                            <td class="text-muted" style="font-size:.75rem;">{{ $item->id }}</td>
                            <td>
                                <span class="fw-500" style="font-size:.85rem;">{{ Str::limit($item->judul, 55) }}</span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                @if ($item->kategori)
                                    <span class="badge rounded-pill"
                                        style="background:var(--accent-soft);color:var(--primary);font-size:.72rem;">
                                        {{ $item->kategori }}
                                    </span>
                                @else <span class="text-muted">—</span> @endif
                            </td>
                            <td class="d-none d-lg-table-cell text-muted" style="font-size:.82rem;">
                                {{ optional($item->tanggal)->format('d M Y') ?? '—' }}
                            </td>
                            <td class="d-none d-md-table-cell text-muted" style="font-size:.82rem;">
                                {{ $item->penulis ?? '—' }}
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.berita.toggle', $item) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="badge border-0 rounded-pill"
                                        style="font-size:.72rem;cursor:pointer;
                                            background:{{ $item->is_active ? '#dcfce7' : '#fee2e2' }};
                                            color:{{ $item->is_active ? '#15803d' : '#b91c1c' }};"
                                        title="Klik untuk ubah status">
                                        {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.berita.edit', $item) }}"
                                       class="btn btn-sm btn-light" style="font-size:.75rem;border-radius:6px;"
                                       title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.berita.destroy', $item) }}"
                                          onsubmit="return confirm('Hapus berita ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light"
                                            style="font-size:.75rem;border-radius:6px;color:#dc2626;" title="Hapus">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($berita->hasPages())
            <div class="p-3">{{ $berita->links() }}</div>
        @endif
    @endif
</div>

@endsection
