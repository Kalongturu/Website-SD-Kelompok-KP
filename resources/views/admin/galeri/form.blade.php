@extends('layouts.admin')
@section('title', $galeri->exists ? 'Edit Foto' : 'Tambah Foto')

@section('content')
  <div class="card-box" style="max-width:620px">
    <form method="POST" action="{{ $galeri->exists ? route('admin.galeri.update', $galeri) : route('admin.galeri.store') }}" enctype="multipart/form-data">
      @csrf
      @if ($galeri->exists) @method('PUT') @endif

      <div class="field">
        <label for="judul">Judul <span style="color:#dc2626">*</span></label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $galeri->judul) }}" required>
        @error('judul') <span class="err">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
        @error('deskripsi') <span class="err">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label for="gambar">Gambar {{ $galeri->exists ? '(kosongkan jika tidak diganti)' : '' }} @if(!$galeri->exists)<span style="color:#dc2626">*</span>@endif</label>
        @if ($galeri->exists && $galeri->gambar)
          <img src="{{ asset('storage/' . $galeri->gambar) }}" alt="" style="display:block;width:180px;border-radius:9px;margin-bottom:10px;border:1px solid #e2e8f0">
        @endif
        <input type="file" id="gambar" name="gambar" accept="image/*" {{ $galeri->exists ? '' : 'required' }}>
        @error('gambar') <span class="err">{{ $message }}</span> @enderror
      </div>

      <div style="display:flex;gap:10px;margin-top:8px">
        <button type="submit" class="btn btn--gold">💾 Simpan</button>
        <a href="{{ route('admin.galeri.index') }}" class="btn btn--ghost">Batal</a>
      </div>
    </form>
  </div>
@endsection
