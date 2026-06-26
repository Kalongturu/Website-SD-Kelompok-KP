@extends('layouts.admin')

@section('title', $item ? 'Edit Sarpras' : 'Tambah Sarpras')
@section('page-title', $item ? 'Edit Sarana & Prasarana' : 'Tambah Sarana & Prasarana')

@section('styles')
<style>
    .form-card { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(0,43,91,.06); overflow:hidden; }
    .form-card-header { display:flex; align-items:center; gap:.75rem; padding:1.1rem 1.5rem; border-bottom:1px solid #f1f5f9; }
    .form-card-header .hico { width:36px; height:36px; border-radius:10px; display:grid; place-items:center; font-size:1rem; flex-shrink:0; }
    .form-card-header h6 { font-size:.9rem; font-weight:600; color:var(--primary-dark); margin:0; }
    .form-card-body { padding:1.5rem; }
    .form-label { font-size:.82rem; font-weight:500; color:#374151; margin-bottom:.35rem; }
    .form-control,.form-select { font-size:.85rem; border-radius:10px; border-color:#e2e8f0; }
    .form-control:focus,.form-select:focus { border-color:var(--accent); box-shadow:none; }
    .upload-zone {
        border: 2px dashed #cbd5e1; border-radius: 12px; padding: 2rem 1rem;
        text-align: center; cursor: pointer; transition: all .2s ease; background: #f8fafc;
    }
    .upload-zone:hover { border-color: var(--accent); background: var(--accent-soft); }
    .upload-zone input { display: none; }
    .upload-zone .upload-icon { font-size: 2rem; color: var(--primary); margin-bottom: .4rem; }
    .upload-zone p { font-size: .82rem; color: var(--primary); margin: 0; font-weight: 500; }
    .upload-zone small { font-size: .72rem; color: #94a3b8; }
    .img-preview { width:100%; border-radius:12px; object-fit:cover; border:1px solid #e2e8f0; max-height:200px; }
</style>
@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.sarpras.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form method="POST"
      action="{{ $item ? route('admin.sarpras.update', $item) : route('admin.sarpras.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-7">

            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-building"></i></div>
                    <h6>Data Sarana &amp; Prasarana</h6>
                </div>
                <div class="form-card-body">

                    <div class="mb-3">
                        <label class="form-label">Jenis Sarpras <span class="text-danger">*</span></label>
                        <input type="text" name="jenis"
                               class="form-control @error('jenis') is-invalid @enderror"
                               value="{{ old('jenis', $item?->jenis) }}"
                               placeholder="cth: Ruang Kelas, Perpustakaan, Laboratorium"
                               required maxlength="255">
                        @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Jumlah Semester Ganjil <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_ganjil"
                                   class="form-control @error('jumlah_ganjil') is-invalid @enderror"
                                   value="{{ old('jumlah_ganjil', $item?->jumlah_ganjil ?? 0) }}"
                                   min="0" required>
                            @error('jumlah_ganjil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Jumlah Semester Genap <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah_genap"
                                   class="form-control @error('jumlah_genap') is-invalid @enderror"
                                   value="{{ old('jumlah_genap', $item?->jumlah_genap ?? 0) }}"
                                   min="0" required>
                            @error('jumlah_genap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan <small class="text-muted">(opsional)</small></label>
                        <textarea name="keterangan"
                                  class="form-control @error('keterangan') is-invalid @enderror"
                                  rows="3" maxlength="2000"
                                  placeholder="Informasi tambahan tentang sarana/prasarana ini…">{{ old('keterangan', $item?->keterangan) }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-5">

            {{-- Upload Foto --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-cloud-upload-fill"></i></div>
                    <h6>Foto <small class="text-muted fw-normal">(opsional)</small></h6>
                </div>
                <div class="form-card-body">
                    @if ($item?->gambarUrl())
                        <img id="imgPreview" src="{{ $item->gambarUrl() }}" alt="" class="img-preview mb-3">
                    @else
                        <img id="imgPreview" src="" alt="" class="img-preview mb-3" style="display:none;">
                    @endif
                    <label class="upload-zone" for="gambarInput">
                        <input type="file" name="gambar" id="gambarInput" accept="image/*">
                        <div class="upload-icon"><i class="bi bi-cloud-upload-fill"></i></div>
                        <p>Klik untuk memilih foto</p>
                        <small>JPG / PNG / WEBP — maks. 3 MB</small>
                    </label>
                    @error('gambar') <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Pengaturan --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-gear-fill"></i></div>
                    <h6>Pengaturan</h6>
                </div>
                <div class="form-card-body">
                    <div class="mb-3">
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number" name="urutan"
                               class="form-control @error('urutan') is-invalid @enderror"
                               value="{{ old('urutan', $item?->urutan ?? 0) }}" min="0">
                        @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active" style="font-size:.85rem;">Tampilkan di halaman fasilitas</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i>
                    {{ $item ? 'Simpan Perubahan' : 'Tambah Sarpras' }}
                </button>
                <a href="{{ route('admin.sarpras.index') }}" class="btn btn-sm btn-light py-2"
                   style="border-radius:10px;font-size:.85rem;">Batal</a>
            </div>

        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
document.getElementById('gambarInput')?.addEventListener('change', function () {
    const file = this.files[0];
    const prev = document.getElementById('imgPreview');
    if (file && prev) {
        prev.src = URL.createObjectURL(file);
        prev.style.display = 'block';
    }
});
</script>
@endsection
