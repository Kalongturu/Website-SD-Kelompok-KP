@extends('layouts.admin')
@section('title', 'Data Mahasiswa')

@section('content')
  <div class="page-head">
    <h2 style="font-size:1.05rem;color:#475569">Total {{ $mahasiswa->total() }} mahasiswa</h2>
    <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn--gold">＋ Tambah Mahasiswa</a>
  </div>

  <div class="card-box" style="padding:0;overflow:hidden">
    <table>
      <thead><tr><th>Foto</th><th>Nama</th><th>NIM</th><th>Jurusan</th><th style="width:170px">Aksi</th></tr></thead>
      <tbody>
        @forelse ($mahasiswa as $m)
          <tr>
            <td>
              @if($m->foto)<img src="{{ asset('storage/' . $m->foto) }}" class="thumb" style="width:44px;height:44px;border-radius:50%" alt="">
              @else <span style="font-size:1.5rem">🎓</span> @endif
            </td>
            <td><strong>{{ $m->nama }}</strong></td>
            <td>{{ $m->nim ?: '—' }}</td>
            <td>{{ $m->jurusan ?: '—' }}</td>
            <td>
              <a href="{{ route('admin.mahasiswa.edit', $m) }}" class="btn btn--ghost btn--sm">Edit</a>
              <form method="POST" action="{{ route('admin.mahasiswa.destroy', $m) }}" style="display:inline" onsubmit="return confirm('Hapus data mahasiswa ini?')">
                @csrf @method('DELETE')
                <button class="btn btn--danger btn--sm">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="empty">Belum ada data mahasiswa.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $mahasiswa->links() }}
@endsection
