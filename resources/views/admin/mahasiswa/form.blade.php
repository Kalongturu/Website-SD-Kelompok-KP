@extends('layouts.admin')
@section('title', $mahasiswa->exists ? 'Edit Mahasiswa' : 'Tambah Mahasiswa')

@section('content')
  <div class="card-box" style="max-width:620px">
    <form method="POST" action="{{ $mahasiswa->exists ? route('admin.mahasiswa.update', $mahasiswa) : route('admin.mahasiswa.store') }}" enctype="multipart/form-data">
      @csrf
      @if ($mahasiswa->exists) @method('PUT') @endif

      <div class="field">
        <label for="nama">Nama Lengkap <span style="color:#dc2626">*</span></label>
        <input type="text" id="nama" name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required>
        @error('nama') <span class="err">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label for="nim">NIM</label>
        <input type="text" id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}">
        @error('nim') <span class="err">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label for="jurusan">Program Studi / Jurusan</label>
        <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan', $mahasiswa->jurusan) }}">
        @error('jurusan') <span class="err">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label for="deskripsi">Deskripsi / Keterangan</label>
        <textarea id="deskripsi" name="deskripsi">{{ old('deskripsi', $mahasiswa->deskripsi) }}</textarea>
        @error('deskripsi') <span class="err">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label for="foto">Foto {{ $mahasiswa->exists ? '(kosongkan jika tidak diganti)' : '' }}</label>
        @if ($mahasiswa->exists && $mahasiswa->foto)
          <img src="{{ asset('storage/' . $mahasiswa->foto) }}" alt="" style="display:block;width:90px;height:90px;object-fit:cover;border-radius:50%;margin-bottom:10px;border:1px solid #e2e8f0">
        @endif
        <input type="file" id="foto" name="foto" accept="image/*">
        @error('foto') <span class="err">{{ $message }}</span> @enderror
      </div>

      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn btn--gold">💾 Simpan</button>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn--ghost">Batal</a>
      </div>
    </form>
  </div>
@endsection
