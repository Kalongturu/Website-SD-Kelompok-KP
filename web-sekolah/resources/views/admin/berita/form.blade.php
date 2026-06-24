@extends('layouts.admin')

@section('title', $item ? 'Edit Berita' : 'Tambah Berita')
@section('page-title', $item ? 'Edit Berita' : 'Tambah Berita')

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
    .img-preview { width:100%; max-height:200px; object-fit:cover; border-radius:10px; border:1px solid #e2e8f0; }
</style>
@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form method="POST"
      action="{{ $item ? route('admin.berita.update', $item) : route('admin.berita.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-8">

            {{-- Konten Utama --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-newspaper"></i></div>
                    <h6>Konten Berita</h6>
                </div>
                <div class="form-card-body">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $item?->judul) }}" required maxlength="255">
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror"
                                   value="{{ old('kategori', $item?->kategori) }}" maxlength="80"
                                   placeholder="Kegiatan / Prestasi / Pengumuman">
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Penulis</label>
                            <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror"
                                   value="{{ old('penulis', $item?->penulis) }}" maxlength="100">
                            @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="ringkasan" class="form-control @error('ringkasan') is-invalid @enderror"
                                  rows="2" maxlength="500" placeholder="Preview singkat yang tampil di kartu berita…">{{ old('ringkasan', $item?->ringkasan) }}</textarea>
                        @error('ringkasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Isi Berita <span class="text-danger">*</span></label>
                        <textarea name="isi" class="form-control @error('isi') is-invalid @enderror"
                                  rows="10" required placeholder="Tulis isi berita lengkap di sini…">{{ old('isi', $item?->isi) }}</textarea>
                        @error('isi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-4">

            {{-- Pengaturan --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-gear-fill"></i></div>
                    <h6>Pengaturan</h6>
                </div>
                <div class="form-card-body">
                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                               value="{{ old('tanggal', optional($item?->tanggal)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required>
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active" style="font-size:.85rem;">Tampilkan di situs</label>
                    </div>
                </div>
            </div>

            {{-- Gambar --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-image-fill"></i></div>
                    <h6>Gambar Berita</h6>
                </div>
                <div class="form-card-body">
                    @if ($item?->gambar_url)
                        <img src="{{ $item->gambar_url }}" alt="" class="img-preview mb-3">
                        <p class="text-muted" style="font-size:.75rem;">Upload baru untuk mengganti gambar saat ini.</p>
                    @endif
                    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror"
                           accept="image/*" id="gambarInput">
                    <div class="form-text mt-1">JPG/PNG/WEBP, maks. 2 MB</div>
                    @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <img id="gambarPreview" src="" alt="" class="img-preview mt-3" style="display:none;">
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i>
                    {{ $item ? 'Simpan Perubahan' : 'Tambah Berita' }}
                </button>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-light py-2"
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
        const prev = document.getElementById('gambarPreview');
        if (file && prev) {
            prev.src = URL.createObjectURL(file);
            prev.style.display = 'block';
        }
    });
</script>
@endsection
