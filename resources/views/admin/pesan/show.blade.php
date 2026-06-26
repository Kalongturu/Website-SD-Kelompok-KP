@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('page-title', 'Detail Pesan')

@section('content')

<div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
    <a href="{{ route('admin.pesan.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Pesan Masuk
    </a>
    <form method="POST" action="{{ route('admin.pesan.destroy', $pesan) }}" onsubmit="return confirm('Hapus pesan ini?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm" style="background:#fee2e2;color:#dc2626;border-radius:8px;font-size:.82rem;">
            <i class="bi bi-trash-fill me-1"></i> Hapus
        </button>
    </form>
</div>

<div class="section-card">
    <div style="padding:1.5rem;border-bottom:1px solid #f1f5f9;">
        <h5 style="font-size:1.05rem;font-weight:700;color:var(--primary-dark);margin:0 0 .35rem;">
            {{ $pesan->subjek ?: '(Tanpa subjek)' }}
        </h5>
        <div style="display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;">
            <div class="topbar-avatar" style="width:34px;height:34px;font-size:.8rem;">
                {{ strtoupper(substr($pesan->nama, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:.88rem;font-weight:600;color:var(--primary-dark);">{{ $pesan->nama }}</div>
                <a href="mailto:{{ $pesan->email }}" style="font-size:.78rem;color:var(--primary);text-decoration:none;">
                    {{ $pesan->email }}
                </a>
            </div>
            <span style="margin-left:auto;font-size:.74rem;color:#94a3b8;">
                {{ $pesan->created_at?->translatedFormat('l, d F Y • H:i') }}
            </span>
        </div>
    </div>

    <div style="padding:1.5rem;">
        <p style="font-size:.9rem;line-height:1.75;color:#334155;white-space:pre-line;margin:0;">{{ $pesan->pesan }}</p>
    </div>

    <div style="padding:1.25rem 1.5rem;border-top:1px solid #f1f5f9;">
        <a href="mailto:{{ $pesan->email }}?subject=Re: {{ rawurlencode($pesan->subjek ?: 'Pesan Anda') }}"
           class="btn btn-sm" style="background:var(--primary);color:#fff;border-radius:8px;font-size:.82rem;">
            <i class="bi bi-reply-fill me-1"></i> Balas via Email
        </a>
    </div>
</div>

@endsection
