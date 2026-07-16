@extends('layouts.admin')

@section('title', $item ? 'Edit E-Book' : 'Tambah E-Book')
@section('page-title', $item ? 'Edit E-Book' : 'Tambah E-Book')

@section('styles')
<style>
    .upload-zone { border:2px dashed #cbd5e1; border-radius:12px; padding:1.5rem; text-align:center; cursor:pointer; transition:.2s; background:#fafbfc; }
    .upload-zone:hover { border-color:var(--accent); background:var(--accent-soft); }
    .upload-zone img { max-height:180px; border-radius:8px; object-fit:contain; }
</style>
@endsection

@section('content')

<form method="POST"
      action="{{ $item ? route('admin.ebook.update', $item) : route('admin.ebook.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">
        {{-- Kolom Kiri: informasi utama --}}
        <div class="col-lg-7">

            <div class="form-card">
                <div class="form-card-header">
                    <div class="hico">📖</div>
                    <h6>Informasi E-Book</h6>
                </div>
                <div class="form-card-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.83rem;">Judul E-Book <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control form-control-sm @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $item?->judul) }}" placeholder="Misal: Matematika Kelas 3 Semester 1" required>
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold" style="font-size:.83rem;">Penulis</label>
                            <input type="text" name="penulis" class="form-control form-control-sm"
                                   value="{{ old('penulis', $item?->penulis) }}" placeholder="Nama penulis / pengarang">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold" style="font-size:.83rem;">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control form-control-sm"
                                   value="{{ old('penerbit', $item?->penerbit) }}" placeholder="Nama penerbit">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold" style="font-size:.83rem;">Mata Pelajaran</label>
                            <input type="text" name="mata_pelajaran" class="form-control form-control-sm"
                                   value="{{ old('mata_pelajaran', $item?->mata_pelajaran) }}" placeholder="Misal: Matematika, IPA, Bahasa Indonesia">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold" style="font-size:.83rem;">Kelas</label>
                            <select name="kelas" class="form-select form-select-sm">
                                <option value="">Semua Kelas</option>
                                @foreach (['Kelas 1','Kelas 2','Kelas 3','Kelas 4','Kelas 5','Kelas 6'] as $k)
                                    <option value="{{ $k }}" {{ old('kelas', $item?->kelas) === $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.83rem;">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="3" class="form-control form-control-sm"
                                  placeholder="Deskripsi singkat isi e-book...">{{ old('deskripsi', $item?->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-1">
                        <label class="form-label fw-semibold" style="font-size:.83rem;">Link E-Book <span class="text-danger">*</span></label>
                        <input type="url" name="link_url" class="form-control form-control-sm @error('link_url') is-invalid @enderror"
                               value="{{ old('link_url', $item?->link_url) }}"
                               placeholder="https://drive.google.com/... atau link e-book lainnya" required>
                        @error('link_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted" style="font-size:.75rem;">Bisa berupa Google Drive, archive.org, atau platform e-book lainnya.</small>
                    </div>

                </div>
            </div>

        </div>

        {{-- Kolom Kanan: cover + pengaturan --}}
        <div class="col-lg-5">

            <div class="form-card">
                <div class="form-card-header">
                    <div class="hico">🖼️</div>
                    <h6>Gambar Cover</h6>
                </div>
                <div class="form-card-body">
                    <div class="upload-zone" onclick="document.getElementById('coverInput').click()">
                        <img id="coverPreview"
                             src="{{ $item?->coverUrl() ?: '' }}"
                             alt="" style="{{ $item?->coverUrl() ? '' : 'display:none;' }} max-height:200px;">
                        <div id="coverPlaceholder" style="{{ $item?->coverUrl() ? 'display:none;' : '' }}">
                            <div style="font-size:2rem;">📷</div>
                            <p class="mb-0 mt-1" style="font-size:.8rem;color:#94a3b8;">Klik untuk pilih gambar cover</p>
                            <small style="color:#cbd5e1;">JPG, PNG · Maks. 2 MB</small>
                        </div>
                    </div>
                    <input type="file" id="coverInput" name="cover" accept="image/*" class="d-none"
                           onchange="previewImg(this,'coverPreview','coverPlaceholder')">
                    @error('cover') <div class="text-danger mt-1" style="font-size:.78rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-header">
                    <div class="hico">⚙️</div>
                    <h6>Pengaturan</h6>
                </div>
                <div class="form-card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.83rem;">Urutan Tampil</label>
                        <input type="number" name="urutan" min="0" class="form-control form-control-sm"
                               value="{{ old('urutan', $item?->urutan ?? 0) }}">
                        <small class="text-muted" style="font-size:.75rem;">Angka lebih kecil tampil lebih awal.</small>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                               {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="isActive" style="font-size:.83rem;">Tampilkan di Website</label>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="d-flex gap-2 pb-4">
        <button type="submit" class="btn btn-sm px-4"
                style="background:var(--primary);color:#fff;border-radius:8px;font-size:.85rem;">
            <i class="bi bi-check-lg me-1"></i> {{ $item ? 'Simpan Perubahan' : 'Tambah E-Book' }}
        </button>
        <a href="{{ route('admin.ebook.index') }}"
           class="btn btn-sm btn-light px-3" style="border-radius:8px;font-size:.85rem;">Batal</a>
    </div>

</form>

@endsection

@section('scripts')
<script>
function previewImg(input, imgId, placeholderId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById(imgId).src = e.target.result;
            document.getElementById(imgId).style.display = '';
            document.getElementById(placeholderId).style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
