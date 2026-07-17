@extends('layouts.admin')

@section('title', $item ? 'Edit Video' : 'Tambah Video Pembelajaran')
@section('page-title', $item ? 'Edit Video' : 'Tambah Video Pembelajaran')

@section('styles')
<style>
    .upload-zone { border:2px dashed #cbd5e1; border-radius:12px; padding:1.25rem; text-align:center; cursor:pointer; transition:.2s; background:#fafbfc; }
    .upload-zone:hover { border-color:var(--accent); background:var(--accent-soft); }
    #ytPreview { border-radius:10px; overflow:hidden; background:#000; position:relative; display:none; }
    #ytPreview img { width:100%; display:block; }
    #ytPreview .play-overlay { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; }
    #ytPreview .play-overlay i { font-size:3rem; color:#fff; opacity:.85; text-shadow:0 2px 8px rgba(0,0,0,.5); }
</style>
@endsection

@section('content')

<form method="POST"
      action="{{ $item ? route('admin.video.update', $item) : route('admin.video.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">
        {{-- Kolom Kiri --}}
        <div class="col-lg-7">

            <div class="form-card">
                <div class="form-card-header">
                    <div class="hico">🎬</div>
                    <h6>Informasi Video</h6>
                </div>
                <div class="form-card-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:.83rem;">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control form-control-sm @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $item?->judul) }}" placeholder="Misal: Cara Membagi Pecahan – Matematika Kelas 4" required>
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold" style="font-size:.83rem;">Mata Pelajaran</label>
                            <input type="text" name="mata_pelajaran" class="form-control form-control-sm"
                                   value="{{ old('mata_pelajaran', $item?->mata_pelajaran) }}" placeholder="Misal: Matematika, IPA">
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
                        <label class="form-label fw-semibold" style="font-size:.83rem;">URL Video <span class="text-danger">*</span></label>
                        <input type="url" name="url_video" id="urlVideoInput"
                               class="form-control form-control-sm @error('url_video') is-invalid @enderror"
                               value="{{ old('url_video', $item?->url_video) }}"
                               placeholder="https://youtube.com/watch?v=... atau link video lainnya"
                               oninput="previewYt(this.value)" required>
                        @error('url_video') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted" style="font-size:.75rem;">Mendukung YouTube, Google Drive, dan platform video lainnya.</small>
                    </div>

                    {{-- Pratinjau YouTube --}}
                    <div id="ytPreview" class="mb-3">
                        <img id="ytThumbImg" src="" alt="YouTube Thumbnail">
                        <div class="play-overlay"><i class="bi bi-play-circle-fill"></i></div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label fw-semibold" style="font-size:.83rem;">Deskripsi Singkat</label>
                        <textarea name="deskripsi" rows="3" class="form-control form-control-sm"
                                  placeholder="Deskripsi singkat tentang video ini...">{{ old('deskripsi', $item?->deskripsi) }}</textarea>
                    </div>

                </div>
            </div>

        </div>

        {{-- Kolom Kanan --}}
        <div class="col-lg-5">

            <div class="form-card">
                <div class="form-card-header">
                    <div class="hico">🖼️</div>
                    <h6>Thumbnail Kustom <small style="font-weight:400;color:#756d66;">(opsional)</small></h6>
                </div>
                <div class="form-card-body">
                    <div class="upload-zone" onclick="document.getElementById('thumbInput').click()">
                        <img id="thumbPreview"
                             src="{{ $item?->thumbnailKustomUrl() ?: '' }}"
                             alt="" style="{{ $item?->thumbnailKustomUrl() ? '' : 'display:none;' }} max-height:160px;border-radius:8px;width:100%;object-fit:cover;">
                        <div id="thumbPlaceholder" style="{{ $item?->thumbnailKustomUrl() ? 'display:none;' : '' }}">
                            <div style="font-size:2rem;">🖼️</div>
                            <p class="mb-0 mt-1" style="font-size:.8rem;color:#756d66;">Upload thumbnail kustom</p>
                            <small style="color:#cbd5e1;">Jika kosong, thumbnail YouTube digunakan otomatis</small>
                        </div>
                    </div>
                    <input type="file" id="thumbInput" name="thumbnail" accept="image/*" class="d-none"
                           onchange="previewImg(this,'thumbPreview','thumbPlaceholder')">
                    @error('thumbnail') <div class="text-danger mt-1" style="font-size:.78rem;">{{ $message }}</div> @enderror
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
            <i class="bi bi-check-lg me-1"></i> {{ $item ? 'Simpan Perubahan' : 'Tambah Video' }}
        </button>
        <a href="{{ route('admin.video.index') }}"
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

function extractYtId(url) {
    const m = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    return m ? m[1] : null;
}

function previewYt(url) {
    const id = extractYtId(url);
    const preview = document.getElementById('ytPreview');
    const img = document.getElementById('ytThumbImg');
    if (id) {
        img.src = 'https://img.youtube.com/vi/' + id + '/hqdefault.jpg';
        preview.style.display = '';
    } else {
        preview.style.display = 'none';
    }
}

// Jalankan saat halaman load (mode edit)
document.addEventListener('DOMContentLoaded', () => {
    const urlInput = document.getElementById('urlVideoInput');
    if (urlInput.value) previewYt(urlInput.value);
});
</script>
@endsection
