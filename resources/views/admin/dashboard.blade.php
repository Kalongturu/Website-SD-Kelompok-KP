@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
  <div class="stat-grid">
    <div class="stat-box"><div class="num">{{ $statistik['galeri'] }}</div><div class="lbl">🖼️ Foto Galeri</div></div>
    <div class="stat-box"><div class="num">{{ $statistik['mahasiswa'] }}</div><div class="lbl">🎓 Mahasiswa</div></div>
    <div class="stat-box"><div class="num">{{ $statistik['pesan'] }}</div><div class="lbl">✉️ Total Pesan</div></div>
    <div class="stat-box"><div class="num">{{ $statistik['pesan_baru'] }}</div><div class="lbl">🔔 Pesan Belum Dibaca</div></div>
  </div>

  <div class="card-box">
    <div class="page-head" style="margin-bottom:14px">
      <h2 style="font-size:1.1rem;color:#0f2c4c">Pesan Terbaru</h2>
      <a href="{{ route('admin.pesan.index') }}" class="btn btn--ghost btn--sm">Lihat Semua</a>
    </div>
    <table>
      <thead><tr><th>Nama</th><th>Email</th><th>Subjek</th><th>Status</th><th></th></tr></thead>
      <tbody>
        @forelse ($pesanTerbaru as $p)
          <tr>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->email }}</td>
            <td>{{ $p->subjek ?: '—' }}</td>
            <td>@if($p->dibaca)<span class="pill pill--dibaca">Dibaca</span>@else<span class="pill pill--baru">Baru</span>@endif</td>
            <td><a href="{{ route('admin.pesan.show', $p) }}" class="btn btn--ghost btn--sm">Buka</a></td>
          </tr>
        @empty
          <tr><td colspan="5" class="empty">Belum ada pesan masuk.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
