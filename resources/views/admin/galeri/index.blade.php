@extends('layouts.admin')
@section('title', 'Galeri')

@section('content')
  <div class="page-head">
    <h2 style="font-size:1.05rem;color:#475569">Total {{ $galeri->total() }} foto</h2>
    <a href="{{ route('admin.galeri.create') }}" class="btn btn--gold">＋ Tambah Foto</a>
  </div>

  <div class="card-box" style="padding:0;overflow:hidden">
    <table>
      <thead><tr><th>Gambar</th><th>Judul</th><th>Deskripsi</th><th style="width:170px">Aksi</th></tr></thead>
      <tbody>
        @forelse ($galeri as $g)
          <tr>
            <td><img src="{{ asset('storage/' . $g->gambar) }}" alt="{{ $g->judul }}" class="thumb"></td>
            <td><strong>{{ $g->judul }}</strong></td>
            <td>{{ Str::limit($g->deskripsi, 60) ?: '—' }}</td>
            <td>
              <a href="{{ route('admin.galeri.edit', $g) }}" class="btn btn--ghost btn--sm">Edit</a>
              <form method="POST" action="{{ route('admin.galeri.destroy', $g) }}" style="display:inline" onsubmit="return confirm('Hapus foto ini?')">
                @csrf @method('DELETE')
                <button class="btn btn--danger btn--sm">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="empty">Belum ada foto. Klik "Tambah Foto" untuk mulai.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $galeri->links() }}
@endsection
