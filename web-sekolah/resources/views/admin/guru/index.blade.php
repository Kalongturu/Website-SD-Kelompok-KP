@extends('layouts.admin')

@section('title', 'Kelola Guru & Staf')
@section('page-title', 'Guru & Staf')

@section('styles')
<style>
    .gr-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 1rem;
        padding: 1.25rem;
    }
    .gr-item {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        transition: box-shadow .2s;
        border-top: 3px solid var(--accent);
        display: flex;
        flex-direction: column;
    }
    .gr-item:hover { box-shadow: 0 6px 20px rgba(40,40,40,.12); }
    .gr-item.is-kepala { border-top-color: #ca8a04; }
    .gr-thumb {
        aspect-ratio: 3 / 4;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: grid;
        place-items: center;
        font-size: 2.5rem;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .gr-thumb img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
    .gr-status {
        position: absolute;
        top: .5rem; right: .5rem;
        width: 11px; height: 11px;
        border-radius: 50%;
        border: 2px solid #fff;
    }
    .gr-kepala-badge {
        position: absolute;
        top: .5rem; left: .5rem;
        background: #fef3c7; color: #92400e;
        font-size: .62rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .4px;
        padding: .15rem .5rem; border-radius: 50px;
        display: inline-flex; align-items: center; gap: .25rem;
    }
    .gr-body { padding: .8rem; text-align: center; display:flex; flex-direction:column; flex:1; }
    .gr-name { font-size: .85rem; font-weight: 700; color: var(--primary-dark); line-height: 1.25; }
    .gr-jabatan { font-size: .72rem; color: #6b7280; margin-top: .15rem; }
    .gr-nip { font-size: .68rem; color: #756d66; margin-top: .15rem; }
    .gr-actions { display: flex; gap: .3rem; margin-top: .65rem; }
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
        <h6><i class="bi bi-person-badge-fill me-2 text-success"></i>Daftar Guru &amp; Staf ({{ $items->total() }})</h6>
        <a href="{{ route('admin.guru.create') }}" class="btn btn-sm"
           style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah
        </a>
    </div>

    @if ($items->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-person-badge" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada data. Klik "Tambah" untuk memulai.</p>
        </div>
    @else
        <div class="gr-grid">
            @foreach ($items as $item)
            <div class="gr-item {{ $item->is_kepala ? 'is-kepala' : '' }}">
                <div class="gr-thumb">
                    @if ($item->fotoUrl())
                        <img src="{{ $item->fotoUrl() }}" alt="{{ $item->nama }}">
                    @else
                        <i class="bi bi-person-fill"></i>
                    @endif
                    @if ($item->is_kepala)
                        <span class="gr-kepala-badge"><i class="bi bi-star-fill"></i> Kepala</span>
                    @endif
                    <div class="gr-status"
                         style="background:{{ $item->is_active ? '#22c55e' : '#ef4444' }};"
                         title="{{ $item->is_active ? 'Tampil' : 'Disembunyikan' }}"></div>
                </div>
                <div class="gr-body">
                    <div class="gr-name" title="{{ $item->nama }}">{{ $item->nama }}</div>
                    <div class="gr-jabatan">{{ $item->jabatan }}</div>
                    @if ($item->nip)
                        <div class="gr-nip">NIP. {{ $item->nip }}</div>
                    @endif
                    <div class="gr-actions mt-auto">
                        <a href="{{ route('admin.guru.edit', $item) }}"
                           class="btn btn-sm btn-light flex-fill text-center"
                           style="font-size:.72rem;border-radius:6px;padding:.25rem;">
                            <i class="bi bi-pencil-fill"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.guru.toggle', $item) }}" class="flex-fill">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-light w-100"
                                style="font-size:.72rem;border-radius:6px;padding:.25rem;
                                       color:{{ $item->is_active ? '#ca8a04' : '#15803d' }};"
                                title="{{ $item->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
                                <i class="bi bi-{{ $item->is_active ? 'eye-slash' : 'eye' }}-fill"></i>
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.guru.destroy', $item) }}"
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
