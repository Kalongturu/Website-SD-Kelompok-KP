@extends('layouts.admin')

@section('title', $item ? 'Edit Mahasiswa' : 'Tambah Mahasiswa')
@section('page-title', $item ? 'Edit Mahasiswa' : 'Tambah Mahasiswa')

@section('styles')
<style>
    .form-card { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(0,43,91,.06); overflow:hidden; }
    .form-card-header { display:flex; align-items:center; gap:.75rem; padding:1.1rem 1.5rem; border-bottom:1px solid #f1f5f9; }
    .form-card-header .hico { width:36px; height:36px; border-radius:10px; display:grid; place-items:center; font-size:1rem; flex-shrink:0; }
    .form-card-header h6 { font-size:.9rem; font-weight:600; color:var(--primary-dark); margin:0; }
    .form-card-body { padding:1.5rem; }
    .form-label { font-size:.82rem; font-weight:500; color:#374151; margin-bottom:.35rem; }
    .form-control { font-size:.85rem; border-radius:10px; border-color:#e2e8f0; }
    .form-control:focus { border-color:var(--accent); box-shadow:none; }

    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 2rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all .2s ease;
        background: #f8fafc;
    }
    .upload-zone:hover { border-color: var(--accent); background: var(--accent-soft); }
    .upload-zone input { display: none; }
    .upload-zone .upload-icon { font-size: 2rem; color: var(--primary); margin-bottom: .5rem; }
    .upload-zone p { font-size: .82rem; color: var(--primary); margin: 0; font-weight: 500; }
    .upload-zone small { font-size: .72rem; color: #94a3b8; }
    .img-preview { width:100%; border-radius:12px; object-fit:cover; border:1px solid #e2e8f0; max-height:240px; }
</style>
@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form method="POST"
      action="{{ $item ? route('admin.mahasiswa.update', $item) : route('admin.mahasiswa.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">

        {{-- KOLOM KIRI --}}
        <div class="col-lg-7">

            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-mortarboard-fill"></i></div>
                    <h6>Informasi Mahasiswa</h6>
                </div>
                <div class="form-card-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $item?->nama) }}" required maxlength="255"
                               placeholder="Nama lengkap mahasiswa">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-5">
                            <label class="form-label">NIM</label>
                            <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                   value="{{ old('nim', $item?->nim) }}" maxlength="50"
                                   placeholder="Nomor Induk Mahasiswa">
                            @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-7">
                            <label class="form-label">Program Studi / Jurusan</label>
                            <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
                                   value="{{ old('jurusan', $item?->jurusan) }}" maxlength="255"
                                   placeholder="Contoh: Teknik Informatika">
                            @error('jurusan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Deskripsi / Keterangan</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="5"
                                  placeholder="Keterangan tambahan tentang mahasiswa…">{{ old('deskripsi', $item?->deskripsi) }}</textarea>
                        @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-lg-5">

            {{-- Upload Foto --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-cloud-upload-fill"></i></div>
                    <h6>Foto {{ $item ? '(Opsional — kosongkan jika tidak ingin mengganti)' : '(Opsional)' }}</h6>
                </div>
                <div class="form-card-body">
                    @if ($item?->fotoUrl())
                        <img id="imgPreview" src="{{ $item->fotoUrl() }}" alt="" class="img-preview mb-3">
                    @else
                        <img id="imgPreview" src="" alt="" class="img-preview mb-3" style="display:none;">
                    @endif

                    <label class="upload-zone" for="fotoInput">
                        <input type="file" name="foto" id="fotoInput" accept="image/*">
                        <div class="upload-icon"><i class="bi bi-cloud-upload-fill"></i></div>
                        <p>Klik untuk memilih foto</p>
                        <small>JPG / PNG / WEBP — maks. 3 MB</small>
                    </label>
                    @error('foto') <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i>
                    {{ $item ? 'Simpan Perubahan' : 'Tambah Mahasiswa' }}
                </button>
                <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-sm btn-light py-2"
                    style="border-radius:10px;font-size:.85rem;">Batal</a>
            </div>

        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    document.getElementById('fotoInput')?.addEventListener('change', function () {
        const file = this.files[0];
        const prev = document.getElementById('imgPreview');
        if (file && prev) {
            prev.src = URL.createObjectURL(file);
            prev.style.display = 'block';
        }
    });
</script>
@endsection
