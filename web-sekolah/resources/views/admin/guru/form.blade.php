@extends('layouts.admin')

@section('title', $item ? 'Edit Guru / Staf' : 'Tambah Guru / Staf')
@section('page-title', $item ? 'Edit Guru / Staf' : 'Tambah Guru / Staf')

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
        border: 2px dashed #cbd5e1; border-radius: 12px; padding: 2rem 1rem;
        text-align: center; cursor: pointer; transition: all .2s ease; background: #f8fafc;
    }
    .upload-zone:hover { border-color: var(--accent); background: var(--accent-soft); }
    .upload-zone input { display: none; }
    .upload-zone .upload-icon { font-size: 2rem; color: var(--primary); margin-bottom: .4rem; }
    .upload-zone p { font-size: .82rem; color: var(--primary); margin: 0; font-weight: 500; }
    .upload-zone small { font-size: .72rem; color: #756d66; }
    .img-preview { width:160px; aspect-ratio:3/4; border-radius:12px; object-fit:cover; border:1px solid #e2e8f0; display:block; margin:0 auto 1rem; }
</style>
@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.guru.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form method="POST"
      action="{{ $item ? route('admin.guru.update', $item) : route('admin.guru.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-7">

            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-person-badge-fill"></i></div>
                    <h6>Identitas Guru / Staf</h6>
                </div>
                <div class="form-card-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $item?->nama) }}"
                               placeholder="cth: Siti Lestari, S.Pd.SD"
                               required maxlength="150">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="jabatan"
                               class="form-control @error('jabatan') is-invalid @enderror"
                               value="{{ old('jabatan', $item?->jabatan) }}"
                               placeholder="cth: Kepala Sekolah, Guru Kelas 1A, Penjaga Sekolah"
                               required maxlength="150">
                        @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">NIP <small class="text-muted">(opsional)</small></label>
                        <input type="text" name="nip"
                               class="form-control @error('nip') is-invalid @enderror"
                               value="{{ old('nip', $item?->nip) }}"
                               placeholder="Nomor Induk Pegawai" maxlength="50">
                        @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-5">

            {{-- Upload Foto --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-cloud-upload-fill"></i></div>
                    <h6>Foto <small class="text-muted fw-normal">(opsional)</small></h6>
                </div>
                <div class="form-card-body">
                    @if ($item?->fotoUrl())
                        <img id="imgPreview" src="{{ $item->fotoUrl() }}" alt="" class="img-preview">
                    @else
                        <img id="imgPreview" src="" alt="" class="img-preview" style="display:none;">
                    @endif
                    <label class="upload-zone" for="fotoInput">
                        <input type="file" name="foto" id="fotoInput" accept="image/*">
                        <div class="upload-icon"><i class="bi bi-cloud-upload-fill"></i></div>
                        <p>Klik untuk memilih foto</p>
                        <small>Disarankan foto potret — JPG / PNG / WEBP — maks. 3 MB</small>
                    </label>
                    @error('foto') <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Pengaturan --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-gear-fill"></i></div>
                    <h6>Pengaturan</h6>
                </div>
                <div class="form-card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="is_kepala" id="is_kepala" value="1"
                               {{ old('is_kepala', $item?->is_kepala) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_kepala" style="font-size:.85rem;">
                            Tandai sebagai <strong>Kepala Sekolah</strong>
                        </label>
                        <div class="text-muted" style="font-size:.72rem;">Tampil sebagai sorotan utama di atas. Hanya satu yang bisa aktif.</div>
                    </div>
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
                        <label class="form-check-label" for="is_active" style="font-size:.85rem;">Tampilkan di halaman Guru &amp; Staf</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i>
                    {{ $item ? 'Simpan Perubahan' : 'Tambah Guru / Staf' }}
                </button>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-sm btn-light py-2"
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
