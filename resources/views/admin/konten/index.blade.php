@extends('layouts.admin')
@section('title', 'Konten Halaman')

@section('content')
  <div class="card-box" style="max-width:760px">
    <p style="color:#64748b;font-size:.9rem;margin-bottom:20px">Ubah teks yang tampil di halaman publik (Beranda &amp; Profil). Klik simpan setelah selesai.</p>

    <form method="POST" action="{{ route('admin.konten.update') }}">
      @csrf
      @method('PUT')

      @forelse ($konten as $k)
        <div class="field">
          <label for="k{{ $k->id }}">{{ $k->label }}</label>
          <textarea id="k{{ $k->id }}" name="konten[{{ $k->id }}]" style="min-height:90px">{{ old('konten.' . $k->id, $k->nilai) }}</textarea>
        </div>
      @empty
        <p class="empty">Belum ada konten yang dapat diedit. Jalankan seeder konten.</p>
      @endforelse

      @if ($konten->count())
        <button type="submit" class="btn btn--gold">💾 Simpan Semua</button>
      @endif
    </form>
  </div>
@endsection
