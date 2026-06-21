@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')
@section('page-title', 'Berita &amp; Pengumuman — Pengumuman')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="font-size:.85rem;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="section-card">
    <div class="section-header">
        <h6><i class="bi bi-megaphone-fill me-2 text-warning"></i>Daftar Pengumuman</h6>
        <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-sm"
           style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Pengumuman
        </a>
    </div>

    @if ($pengumuman->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-megaphone" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada pengumuman.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover activity-table mb-0">
                <thead>
                    <tr>
                        <th style="width:44px;">#</th>
                        <th>Judul</th>
                        <th class="d-none d-lg-table-cell">Tanggal</th>
                        <th class="d-none d-md-table-cell">Penting</th>
                        <th>Status</th>
                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengumuman as $item)
                        <tr>
                            <td class="text-muted" style="font-size:.75rem;">{{ $item->id }}</td>
                            <td>
                                <span class="fw-500" style="font-size:.85rem;">{{ Str::limit($item->judul, 65) }}</span>
                                @if ($item->lampiran)
                                    <i class="bi bi-paperclip text-muted ms-1" title="Ada lampiran"></i>
                                @endif
                            </td>
                            <td class="d-none d-lg-table-cell text-muted" style="font-size:.82rem;">
                                {{ optional($item->tanggal)->format('d M Y') ?? '—' }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                @if ($item->penting)
                                    <span class="badge rounded-pill" style="background:#fef3c7;color:#92400e;font-size:.72rem;">⚠️ Penting</span>
                                @else
                                    <span class="text-muted" style="font-size:.8rem;">—</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.pengumuman.toggle', $item) }}">
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
                                    <a href="{{ route('admin.pengumuman.edit', $item) }}"
                                       class="btn btn-sm btn-light" style="font-size:.75rem;border-radius:6px;" title="Edit">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.pengumuman.destroy', $item) }}"
                                          onsubmit="return confirm('Hapus pengumuman ini?')">
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
        @if ($pengumuman->hasPages())
            <div class="p-3">{{ $pengumuman->links() }}</div>
        @endif
    @endif
</div>

@endsection
