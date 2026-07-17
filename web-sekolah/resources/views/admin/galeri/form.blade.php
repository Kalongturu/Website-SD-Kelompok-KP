@extends('layouts.admin')

@section('title', $item ? 'Edit Foto' : 'Upload Foto')
@section('page-title', $item ? 'Edit Foto Galeri' : 'Upload Foto Galeri')

@section('styles')
<style>
    .form-card { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(40,40,40,.06); overflow:hidden; }
    .form-card-header { display:flex; align-items:center; gap:.75rem; padding:1.1rem 1.5rem; border-bottom:1px solid #f1f5f9; }
    .form-card-header .hico { width:36px; height:36px; border-radius:10px; display:grid; place-items:center; font-size:1rem; flex-shrink:0; }
    .form-card-header h6 { font-size:.9rem; font-weight:600; color:var(--primary-dark); margin:0; }
    .form-card-body { padding:1.5rem; }
    .form-label { font-size:.82rem; font-weight:500; color:#374151; margin-bottom:.35rem; }
    .form-control,.form-select { font-size:.85rem; border-radius:10px; border-color:#e2e8f0; }
    .form-control:focus,.form-select:focus { border-color:var(--accent); box-shadow:none; }

    .upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 2.5rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all .2s ease;
        background: #f8fafc;
    }

    .upload-zone:hover { border-color: var(--accent); background: var(--accent-soft); }
    .upload-zone input { display: none; }
    .upload-zone .upload-icon { font-size: 2rem; color: var(--primary); margin-bottom: .5rem; }
    .upload-zone p { font-size: .82rem; color: var(--primary); margin: 0; font-weight: 500; }
    .upload-zone small { font-size: .72rem; color: #756d66; }

    .img-preview { width:100%; border-radius:12px; object-fit:cover; border:1px solid #e2e8f0; max-height:280px; }

    .album-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:.6rem; }
    .album-thumb { position:relative; aspect-ratio:1/1; border-radius:10px; overflow:hidden; border:1px solid #e2e8f0; }
    .album-thumb img { width:100%; height:100%; object-fit:cover; display:block; }
    .album-thumb-del {
        position:absolute; top:.3rem; right:.3rem; width:24px; height:24px; border-radius:50%;
        border:none; background:rgba(220,38,38,.92); color:#fff; font-size:.7rem; line-height:1;
        display:grid; place-items:center; cursor:pointer; transition:background .2s;
    }
    .album-thumb-del:hover { background:#b91c1c; }
</style>
@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.galeri.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form method="POST"
      action="{{ $item ? route('admin.galeri.update', $item) : route('admin.galeri.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-7">

            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-image-fill"></i></div>
                    <h6>Informasi Foto</h6>
                </div>
                <div class="form-card-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $item?->judul) }}" required maxlength="255">
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror"
                                   value="{{ old('kategori', $item?->kategori) }}" maxlength="80"
                                   placeholder="Kegiatan / Olahraga / Seni">
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', optional($item?->tanggal)->format('Y-m-d')) }}">
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $item?->urutan ?? 0) }}" min="0">
                            @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
                                  rows="4" maxlength="1000" placeholder="Deskripsi foto yang tampil saat foto diklik…">{{ old('keterangan', $item?->keterangan) }}</textarea>
                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-5">

            {{-- Foto Album (bisa banyak) --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-images"></i></div>
                    <h6>Foto Album {{ $item ? '(tambah foto baru — opsional)' : '*' }}</h6>
                </div>
                <div class="form-card-body">

                    {{-- Foto yang sudah ada di album (mode edit) --}}
                    @if ($item && $item->fotos->isNotEmpty())
                        <label class="form-label">Foto dalam album ({{ $item->fotos->count() }})</label>
                        <div class="album-grid mb-3">
                            @foreach ($item->fotos as $foto)
                                <div class="album-thumb">
                                    <img src="{{ $foto->gambarUrl() }}" alt="">
                                    <button type="button" class="album-thumb-del"
                                            title="Hapus foto ini"
                                            data-foto-url="{{ route('admin.galeri.foto.destroy', $foto) }}">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- Preview foto baru yang dipilih --}}
                    <div id="newPreview" class="album-grid mb-3" style="display:none;"></div>

                    <label class="upload-zone" for="gambarInput">
                        <input type="file" name="gambar[]" id="gambarInput" accept="image/*" multiple>
                        <div class="upload-icon"><i class="bi bi-cloud-upload-fill"></i></div>
                        <p>Klik untuk memilih foto (bisa pilih beberapa sekaligus)</p>
                        <small>JPG / PNG / WEBP — maks. 3 MB per foto</small>
                    </label>
                    @error('gambar') <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div> @enderror
                    @error('gambar.*') <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-gear-fill"></i></div>
                    <h6>Pengaturan</h6>
                </div>
                <div class="form-card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active" style="font-size:.85rem;">Tampilkan di galeri</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i>
                    {{ $item ? 'Simpan Perubahan' : 'Upload Foto' }}
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-sm btn-light py-2"
                    style="border-radius:10px;font-size:.85rem;">Batal</a>
            </div>

        </div>
    </div>
</form>

{{-- Form tersembunyi untuk menghapus satu foto album — DILUAR form utama agar
     tidak terjadi form bersarang (yang membuat submit create ikut mengirim DELETE). --}}
<form id="delFotoForm" method="POST" class="d-none">
    @csrf @method('DELETE')
</form>

@endsection

@section('scripts')
<script>
    // Preview banyak foto yang dipilih untuk album.
    document.getElementById('gambarInput')?.addEventListener('change', function () {
        const prev = document.getElementById('newPreview');
        if (!prev) return;
        prev.innerHTML = '';
        const files = Array.from(this.files || []);
        prev.style.display = files.length ? 'grid' : 'none';
        files.forEach(function (file) {
            if (!file.type.startsWith('image/')) return;
            const wrap = document.createElement('div');
            wrap.className = 'album-thumb';
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            wrap.appendChild(img);
            prev.appendChild(wrap);
        });
    });

    // Hapus satu foto dari album (submit form tersembunyi ke route destroyFoto).
    const delForm = document.getElementById('delFotoForm');
    document.querySelectorAll('.album-thumb-del').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (!confirm('Hapus foto ini dari album?')) return;
            delForm.action = btn.dataset.fotoUrl;
            delForm.submit();
        });
    });
</script>
@endsection
