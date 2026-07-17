@extends('layouts.admin')

@section('title', 'Kelola Ruang Kelas')
@section('page-title', 'Ruang Kelas & Jumlah Siswa')

@section('styles')
<style>
    .rk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1.25rem;
    }
    .rk-item {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        transition: box-shadow .2s;
        border-top: 3px solid var(--accent);
    }
    .rk-item:hover { box-shadow: 0 6px 20px rgba(40,40,40,.12); }
    .rk-thumb {
        height: 120px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: grid;
        place-items: center;
        font-size: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .rk-thumb img { position:absolute;inset:0;width:100%;height:100%;object-fit:cover; }
    .rk-status {
        position: absolute;
        top: .5rem; right: .5rem;
        width: 10px; height: 10px;
        border-radius: 50%;
        border: 2px solid #fff;
    }
    .rk-body { padding: .85rem; }
    .rk-name { font-size: .88rem; font-weight: 700; color: var(--primary-dark); margin-bottom: .3rem; }
    .rk-siswa {
        display: inline-flex; align-items: center; gap: .3rem;
        background: var(--accent-soft); color: var(--primary-dark);
        font-size: .72rem; font-weight: 700;
        padding: .15rem .6rem; border-radius: 50px;
        margin-bottom: .5rem;
    }
    .rk-actions { display: flex; gap: .3rem; margin-top: .5rem; }
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
        <h6><i class="bi bi-door-closed-fill me-2 text-success"></i>Daftar Ruang Kelas ({{ $items->total() }})</h6>
        <a href="{{ route('admin.ruang-kelas.create') }}" class="btn btn-sm"
           style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah
        </a>
    </div>

    @if ($items->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-door-closed" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada data. Klik "Tambah" untuk memulai.</p>
        </div>
    @else
        <div class="rk-grid">
            @foreach ($items as $item)
            <div class="rk-item">
                <div class="rk-thumb">
                    @if ($item->gambarUrl())
                        <img src="{{ $item->gambarUrl() }}" alt="{{ $item->nama_kelas }}">
                    @else
                        🏫
                    @endif
                    <div class="rk-status"
                         style="background:{{ $item->is_active ? '#22c55e' : '#ef4444' }};"></div>
                </div>
                <div class="rk-body">
                    <div class="rk-name" title="{{ $item->nama_kelas }}">{{ $item->nama_kelas }}</div>
                    <div class="rk-siswa">👤 {{ $item->jumlah_siswa }} Siswa</div>
                    @if ($item->keterangan)
                        <p style="font-size:.75rem;color:#6b7280;margin:0 0 .3rem;">
                            {{ \Illuminate\Support\Str::limit($item->keterangan, 50) }}
                        </p>
                    @endif
                    <div class="rk-actions">
                        <a href="{{ route('admin.ruang-kelas.edit', $item) }}"
                           class="btn btn-sm btn-light flex-fill text-center"
                           style="font-size:.72rem;border-radius:6px;padding:.25rem;">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.ruang-kelas.toggle', $item) }}" class="flex-fill">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-light w-100"
                                style="font-size:.72rem;border-radius:6px;padding:.25rem;
                                       color:{{ $item->is_active ? '#ca8a04' : '#15803d' }};">
                                <i class="bi bi-{{ $item->is_active ? 'eye-slash' : 'eye' }}-fill"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.ruang-kelas.destroy', $item) }}"
                              onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light"
                                style="font-size:.72rem;border-radius:6px;padding:.25rem;color:#dc2626;">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @if ($items->hasPages())
            <div class="p-3">{{ $items->links() }}</div>
        @endif
    @endif
</div>

@endsection
