@extends('layouts.admin')

@section('title', 'Kelola Tata Tertib')
@section('page-title', 'Tata Tertib')

@section('styles')
<style>
    .tatib-admin-item {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1rem;
        transition: box-shadow .2s ease;
    }
    .tatib-admin-item:hover { box-shadow: 0 4px 16px rgba(0,43,91,.08); }

    .tatib-admin-head {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .85rem 1.25rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: #fff;
    }
    .tatib-admin-icon { font-size: 1.35rem; flex-shrink: 0; }
    .tatib-admin-title { font-weight: 700; font-size: .92rem; flex: 1; }
    .tatib-admin-order { font-size: .72rem; opacity: .75; }

    .tatib-admin-body { padding: .9rem 1.25rem; }
    .tatib-preview { font-size: .82rem; color: #475569; white-space: pre-line; max-height: 80px; overflow: hidden; position: relative; }
    .tatib-preview::after {
        content: ''; position: absolute; bottom: 0; left: 0; right: 0;
        height: 24px; background: linear-gradient(to bottom, transparent, #fff);
    }

    .tatib-admin-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .6rem 1.25rem;
        border-top: 1px solid #f1f5f9;
        background: #fafafa;
    }
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
        <h6><i class="bi bi-clipboard2-check-fill me-2 text-success"></i>Daftar Tata Tertib ({{ $items->total() }})</h6>
        <a href="{{ route('admin.tata-tertib.create') }}" class="btn btn-sm"
           style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
        </a>
    </div>

    @if ($items->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-clipboard2-check" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada tata tertib. Klik "Tambah Kategori" untuk mulai.</p>
        </div>
    @else
        <div style="padding:1.25rem;">
            @foreach ($items as $item)
                <div class="tatib-admin-item">
                    <div class="tatib-admin-head">
                        <span class="tatib-admin-icon">{{ $item->icon ?: '📋' }}</span>
                        <span class="tatib-admin-title">{{ $item->kategori }}</span>
                        <span class="tatib-admin-order">Urutan: {{ $item->urutan }}</span>
                        <span style="font-size:.72rem;background:{{ $item->is_active ? 'rgba(255,255,255,.2)' : 'rgba(239,68,68,.4)' }};
                               padding:.15rem .55rem;border-radius:50px;margin-left:.5rem;">
                            {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <div class="tatib-admin-body">
                        <div class="tatib-preview">{{ $item->isi }}</div>
                    </div>
                    <div class="tatib-admin-footer">
                        <div style="font-size:.75rem;color:#64748b;">
                            @if ($item->dokumen)
                                <a href="{{ $item->dokumenUrl() }}" target="_blank"
                                   style="color:var(--primary);text-decoration:none;">
                                    <i class="bi bi-file-earmark-pdf-fill me-1 text-danger"></i>Dokumen PDF tersedia
                                </a>
                            @else
                                <span class="text-muted"><i class="bi bi-file-earmark me-1"></i>Belum ada dokumen</span>
                            @endif
                        </div>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.tata-tertib.edit', $item) }}"
                               class="btn btn-sm btn-light" style="font-size:.75rem;border-radius:6px;">
                                <i class="bi bi-pencil-fill me-1"></i>Edit
                            </a>
                            <form method="POST" action="{{ route('admin.tata-tertib.toggle', $item) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-light"
                                    style="font-size:.75rem;border-radius:6px;
                                           color:{{ $item->is_active ? '#ca8a04' : '#15803d' }};">
                                    <i class="bi bi-{{ $item->is_active ? 'eye-slash' : 'eye' }}-fill me-1"></i>
                                    {{ $item->is_active ? 'Sembunyikan' : 'Tampilkan' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.tata-tertib.destroy', $item) }}"
                                  onsubmit="return confirm('Hapus kategori tata tertib ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light"
                                    style="font-size:.75rem;border-radius:6px;color:#dc2626;">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($items->hasPages())
            <div class="p-3 pt-0">{{ $items->links() }}</div>
        @endif
    @endif
</div>

@endsection
