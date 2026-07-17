@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('page-title', 'Pesan Masuk')

@section('styles')
<style>
    .msg-list { display:flex; flex-direction:column; }
    .msg-row {
        display:flex; align-items:flex-start; gap:1rem;
        padding:1rem 1.5rem; border-bottom:1px solid #f1f5f9;
        transition:background .15s;
    }
    .msg-row:hover { background:#f8fafc; }
    .msg-row.unread { background:#f0f9ff; }
    .msg-row.unread:hover { background:#e0f2fe; }
    .msg-dot { width:9px; height:9px; border-radius:50%; margin-top:.5rem; flex-shrink:0; background:#cbd5e1; }
    .msg-row.unread .msg-dot { background:#0ea5e9; }
    .msg-main { flex:1; min-width:0; }
    .msg-top { display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
    .msg-nama { font-size:.88rem; font-weight:700; color:var(--primary-dark); }
    .msg-row.unread .msg-nama::after {
        content:'Baru'; margin-left:.5rem; font-size:.6rem; font-weight:700; text-transform:uppercase;
        color:#0369a1; background:#e0f2fe; padding:.1rem .45rem; border-radius:50px; vertical-align:middle;
    }
    .msg-email { font-size:.74rem; color:#756d66; }
    .msg-subjek { font-size:.82rem; color:#475569; font-weight:600; margin-top:.15rem; }
    .msg-snippet { font-size:.8rem; color:#64748b; margin-top:.1rem;
        overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:560px; }
    .msg-meta { display:flex; flex-direction:column; align-items:flex-end; gap:.4rem; flex-shrink:0; }
    .msg-time { font-size:.72rem; color:#756d66; white-space:nowrap; }
    .msg-actions { display:flex; gap:.3rem; }
    .msg-actions .btn { font-size:.72rem; border-radius:6px; padding:.25rem .5rem; }
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
        <h6><i class="bi bi-envelope-fill me-2 text-primary"></i>Pesan Masuk
            @if ($unread > 0)
                <span class="badge rounded-pill bg-primary ms-1" style="font-size:.65rem;">{{ $unread }} belum dibaca</span>
            @endif
        </h6>
        @if ($unread > 0)
            <form method="POST" action="{{ route('admin.pesan.read-all') }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.78rem;">
                    <i class="bi bi-check2-all me-1"></i> Tandai semua dibaca
                </button>
            </form>
        @endif
    </div>

    @if ($items->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-inbox" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada pesan masuk dari pengunjung.</p>
        </div>
    @else
        <div class="msg-list">
            @foreach ($items as $item)
                <div class="msg-row {{ $item->is_read ? '' : 'unread' }}">
                    <span class="msg-dot"></span>
                    <div class="msg-main">
                        <div class="msg-top">
                            <span class="msg-nama">{{ $item->nama }}</span>
                            <a href="mailto:{{ $item->email }}" class="msg-email">&lt;{{ $item->email }}&gt;</a>
                        </div>
                        @if ($item->subjek)
                            <div class="msg-subjek">{{ $item->subjek }}</div>
                        @endif
                        <div class="msg-snippet">{{ \Illuminate\Support\Str::limit($item->pesan, 110) }}</div>
                    </div>
                    <div class="msg-meta">
                        <span class="msg-time">{{ $item->created_at?->translatedFormat('d M Y, H:i') }}</span>
                        <div class="msg-actions">
                            <a href="{{ route('admin.pesan.show', $item) }}" class="btn btn-light" title="Lihat">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.pesan.toggle', $item) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-light"
                                    title="{{ $item->is_read ? 'Tandai belum dibaca' : 'Tandai dibaca' }}">
                                    <i class="bi bi-{{ $item->is_read ? 'envelope' : 'envelope-open' }}-fill"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.pesan.destroy', $item) }}"
                                  onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-light" style="color:#dc2626;" title="Hapus">
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
