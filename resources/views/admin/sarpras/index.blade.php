@extends('layouts.admin')

@section('title', 'Kelola Sarana & Prasarana')
@section('page-title', 'Sarana & Prasarana')

@section('styles')
<style>
    .sp-table-wrap { overflow-x: auto; }
    table.sp-table { width: 100%; border-collapse: collapse; font-size: .85rem; }
    table.sp-table thead th {
        text-align: left;
        padding: .8rem 1rem;
        font-weight: 600;
        color: var(--primary-dark);
        border-bottom: 2px solid #f1f5f9;
        white-space: nowrap;
        background: #f8fafc;
    }
    table.sp-table th.num, table.sp-table td.num { text-align: center; }
    table.sp-table tbody td {
        padding: .75rem 1rem;
        color: #374151;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    table.sp-table tbody tr:hover { background: #f8fafc; }
    table.sp-table .thumb {
        width: 52px; height: 40px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }
    .badge-active   { background:#dcfce7;color:#15803d;font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:50px; }
    .badge-inactive { background:#fee2e2;color:#dc2626;font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:50px; }
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
        <h6><i class="bi bi-building me-2 text-primary"></i>Daftar Sarana &amp; Prasarana ({{ $items->total() }})</h6>
        <a href="{{ route('admin.sarpras.create') }}" class="btn btn-sm"
           style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah
        </a>
    </div>

    @if ($items->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-building" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada data. Klik "Tambah" untuk memulai.</p>
        </div>
    @else
        <div class="sp-table-wrap">
            <table class="sp-table">
                <thead>
                    <tr>
                        <th class="num" style="width:44px;">No</th>
                        <th>Jenis Sarpras</th>
                        <th class="num">Jml Ganjil</th>
                        <th class="num">Jml Genap</th>
                        <th>Keterangan</th>
                        <th class="num">Foto</th>
                        <th class="num">Urutan</th>
                        <th class="num">Status</th>
                        <th class="num">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $i => $item)
                    <tr>
                        <td class="num">{{ $items->firstItem() + $i }}</td>
                        <td style="font-weight:600;">{{ $item->jenis }}</td>
                        <td class="num">{{ $item->jumlah_ganjil }}</td>
                        <td class="num">{{ $item->jumlah_genap }}</td>
                        <td style="max-width:200px;font-size:.82rem;color:#6b7280;">
                            {{ \Illuminate\Support\Str::limit($item->keterangan, 60) ?: '—' }}
                        </td>
                        <td class="num">
                            @if ($item->gambarUrl())
                                <img src="{{ $item->gambarUrl() }}" alt="{{ $item->jenis }}" class="thumb">
                            @else
                                <span style="font-size:.8rem;color:#cbd5e1;">—</span>
                            @endif
                        </td>
                        <td class="num">{{ $item->urutan }}</td>
                        <td class="num">
                            <span class="{{ $item->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="num">
                            <div style="display:flex;gap:.3rem;justify-content:center;">
                                <a href="{{ route('admin.sarpras.edit', $item) }}"
                                   class="btn btn-sm btn-light" style="font-size:.72rem;border-radius:6px;padding:.25rem .5rem;">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.sarpras.toggle', $item) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-light"
                                        style="font-size:.72rem;border-radius:6px;padding:.25rem .5rem;
                                               color:{{ $item->is_active ? '#ca8a04' : '#15803d' }};">
                                        <i class="bi bi-{{ $item->is_active ? 'eye-slash' : 'eye' }}-fill"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.sarpras.destroy', $item) }}"
                                      onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light"
                                        style="font-size:.72rem;border-radius:6px;padding:.25rem .5rem;color:#dc2626;">
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
        @if ($items->hasPages())
            <div class="p-3">{{ $items->links() }}</div>
        @endif
    @endif
</div>

@endsection
