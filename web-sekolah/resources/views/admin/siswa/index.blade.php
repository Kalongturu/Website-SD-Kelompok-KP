@extends('layouts.admin')

@section('title', 'Kelola Siswa')
@section('page-title', 'Siswa')

@section('styles')
<style>
    .mhs-admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1.25rem;
    }

    .mhs-admin-item {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: box-shadow .2s ease;
    }

    .mhs-admin-item:hover { box-shadow: 0 6px 20px rgba(40,40,40,.12); }

    .mhs-admin-thumb {
        height: 150px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: grid;
        place-items: center;
        font-size: 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .mhs-admin-thumb img { width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0; }

    .mhs-admin-body { padding: .75rem; }

    .mhs-admin-title {
        font-size: .85rem; font-weight: 600; color: var(--primary-dark);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        margin-bottom: .2rem;
    }

    .mhs-admin-sub {
        font-size: .72rem; color: #64748b; margin-bottom: .5rem;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }

    .mhs-admin-actions { display: flex; gap: .35rem; margin-top: .5rem; }
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
        <h6><i class="bi bi-mortarboard-fill me-2 text-primary"></i>Daftar Siswa ({{ $items->total() }})</h6>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-sm"
           style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah
        </a>
    </div>

    @if ($items->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-mortarboard" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada data siswa. Klik "Tambah" untuk mulai.</p>
        </div>
    @else
        <div class="mhs-admin-grid">
            @foreach ($items as $item)
                <div class="mhs-admin-item">
                    <div class="mhs-admin-thumb">
                        @if ($item->fotoUrl())
                            <img src="{{ $item->fotoUrl() }}" alt="{{ $item->nama }}">
                        @else
                            <span>🎓</span>
                        @endif
                    </div>
                    <div class="mhs-admin-body">
                        <div class="mhs-admin-title" title="{{ $item->nama }}">{{ $item->nama }}</div>
                        <div class="mhs-admin-sub">
                            {{ $item->nis ?: '—' }}
                            @if ($item->kelas) · {{ $item->kelas }} @endif
                        </div>
                        <div class="mhs-admin-actions">
                            <a href="{{ route('admin.siswa.edit', $item) }}"
                               class="btn btn-sm btn-light flex-fill text-center"
                               style="font-size:.72rem;border-radius:6px;padding:.25rem;">
                                <i class="bi bi-pencil-fill"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.siswa.destroy', $item) }}"
                                  onsubmit="return confirm('Hapus data siswa ini?')">
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
