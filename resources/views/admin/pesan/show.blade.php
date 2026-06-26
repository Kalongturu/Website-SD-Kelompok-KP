@extends('layouts.admin')
@section('title', 'Detail Pesan')

@section('content')
  <a href="{{ route('admin.pesan.index') }}" class="btn btn--ghost btn--sm" style="margin-bottom:18px">← Kembali</a>

  <div class="card-box" style="max-width:680px">
    <h2 style="font-family:'Plus Jakarta Sans',sans-serif;color:#0f2c4c;font-size:1.3rem;margin-bottom:4px">{{ $pesan->subjek ?: 'Tanpa Subjek' }}</h2>
    <p style="color:#94a3b8;font-size:.85rem;margin-bottom:22px">{{ $pesan->created_at->format('d F Y, H:i') }}</p>

    <div style="display:grid;grid-template-columns:120px 1fr;gap:10px 16px;font-size:.92rem;margin-bottom:22px">
      <strong style="color:#475569">Nama</strong><span>{{ $pesan->nama }}</span>
      <strong style="color:#475569">Email</strong><span><a href="mailto:{{ $pesan->email }}" style="color:#0f2c4c">{{ $pesan->email }}</a></span>
    </div>

    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:18px;white-space:pre-line;line-height:1.6">{{ $pesan->pesan }}</div>

    <div style="display:flex;gap:10px;margin-top:22px">
      <a href="mailto:{{ $pesan->email }}?subject=Re: {{ $pesan->subjek }}" class="btn btn--gold">✉️ Balas via Email</a>
      <form method="POST" action="{{ route('admin.pesan.destroy', $pesan) }}" onsubmit="return confirm('Hapus pesan ini?')">
        @csrf @method('DELETE')
        <button class="btn btn--danger">Hapus</button>
      </form>
    </div>
  </div>
@endsection
