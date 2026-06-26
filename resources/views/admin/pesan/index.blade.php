@extends('layouts.admin')
@section('title', 'Pesan Masuk')

@section('content')
  <div class="card-box" style="padding:0;overflow:hidden">
    <table>
      <thead><tr><th>Status</th><th>Nama</th><th>Email</th><th>Subjek</th><th>Tanggal</th><th style="width:170px">Aksi</th></tr></thead>
      <tbody>
        @forelse ($pesan as $p)
          <tr style="{{ $p->dibaca ? '' : 'background:#fffbeb' }}">
            <td>@if($p->dibaca)<span class="pill pill--dibaca">Dibaca</span>@else<span class="pill pill--baru">Baru</span>@endif</td>
            <td><strong>{{ $p->nama }}</strong></td>
            <td>{{ $p->email }}</td>
            <td>{{ $p->subjek ?: '—' }}</td>
            <td>{{ $p->created_at->format('d M Y H:i') }}</td>
            <td>
              <a href="{{ route('admin.pesan.show', $p) }}" class="btn btn--ghost btn--sm">Buka</a>
              <form method="POST" action="{{ route('admin.pesan.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Hapus pesan ini?')">
                @csrf @method('DELETE')
                <button class="btn btn--danger btn--sm">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="empty">Belum ada pesan masuk.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $pesan->links() }}
@endsection
