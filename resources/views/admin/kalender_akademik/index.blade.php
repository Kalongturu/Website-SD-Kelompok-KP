@extends('layouts.admin')

@section('title', 'Kelola Kalender Akademik')
@section('page-title', 'Kalender Akademik')

@section('styles')
<style>
    .calendar-table-wrap { overflow-x: auto; }
    .calendar-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
    .calendar-table th { padding: .8rem 1rem; color: var(--primary-dark); background: #f8fafc; border-bottom: 2px solid #f1f5f9; font-weight: 600; white-space: nowrap; }
    .calendar-table td { padding: .8rem 1rem; color: #374151; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
    .calendar-table tbody tr:hover { background: #f8fafc; }
    .calendar-table .center { text-align: center; }
    .year-chip { display: inline-flex; align-items: center; gap: .45rem; padding: .35rem .7rem; border-radius: 8px; background: #e0f2fe; color: #0369a1; font-weight: 700; }
    .badge-active { background:#dcfce7; color:#15803d; font-size:.7rem; font-weight:700; padding:.2rem .6rem; border-radius:50px; }
    .badge-inactive { background:#fee2e2; color:#dc2626; font-size:.7rem; font-weight:700; padding:.2rem .6rem; border-radius:50px; }
</style>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="font-size:.85rem;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="section-card">
    <div class="section-header">
        <div>
            <h6><i class="bi bi-calendar-event-fill me-2 text-primary"></i>Daftar Kalender ({{ $items->total() }})</h6>
            <small class="text-muted">Kelola file kalender yang tampil pada halaman akademik.</small>
        </div>
        <a href="{{ route('admin.kalender-akademik.create') }}" class="btn btn-sm"
           style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kalender
        </a>
    </div>

    @if ($items->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-calendar-plus" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada kalender akademik. Klik "Tambah Kalender" untuk memulai.</p>
        </div>
    @else
        <div class="calendar-table-wrap">
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th class="center" style="width:60px;">No</th>
                        <th>Tahun Ajaran</th>
                        <th>Nama File</th>
                        <th class="center">Urutan</th>
                        <th class="center">Status</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i => $item)
                        <tr>
                            <td class="center">{{ $items->firstItem() + $i }}</td>
                            <td>
                                <span class="year-chip"><i class="bi bi-calendar3"></i>{{ $item->tahun_ajaran }}</span>
                            </td>
                            <td>
                                <div style="font-weight:500;max-width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    {{ $item->file_name ?: basename($item->file_path) }}
                                </div>
                            </td>
                            <td class="center">{{ $item->urutan }}</td>
                            <td class="center">
                                <span class="{{ $item->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ $item->fileUrl() }}" target="_blank" rel="noopener"
                                       class="btn btn-sm btn-light" title="Lihat file"><i class="bi bi-eye-fill text-primary"></i></a>
                                    <a href="{{ route('admin.kalender-akademik.edit', $item) }}"
                                       class="btn btn-sm btn-light" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    <form method="POST" action="{{ route('admin.kalender-akademik.toggle', $item) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-light" title="{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="bi bi-{{ $item->is_active ? 'eye-slash' : 'eye' }}-fill" style="color:{{ $item->is_active ? '#ca8a04' : '#15803d' }};"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.kalender-akademik.destroy', $item) }}"
                                          onsubmit="return confirm('Hapus kalender tahun {{ $item->tahun_ajaran }}? File yang diunggah juga akan dihapus.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light" title="Hapus"><i class="bi bi-trash-fill text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($items->hasPages())
            <div class="p-3">{{ $items->links() }}</div>
        @endif
    @endif
</div>

@endsection
