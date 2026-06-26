@extends('layouts.admin')

@section('title', $item ? 'Edit Kalender Akademik' : 'Tambah Kalender Akademik')
@section('page-title', $item ? 'Edit Kalender Akademik' : 'Tambah Kalender Akademik')

@section('styles')
<style>
    .form-card { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(0,43,91,.06); overflow:hidden; }
    .form-card-header { display:flex; align-items:center; gap:.75rem; padding:1.1rem 1.5rem; border-bottom:1px solid #f1f5f9; }
    .form-card-header .header-icon { width:38px; height:38px; border-radius:10px; display:grid; place-items:center; background:#e0f2fe; color:#0369a1; }
    .form-card-header h6 { font-size:.9rem; font-weight:600; color:var(--primary-dark); margin:0; }
    .form-card-body { padding:1.5rem; }
    .form-label { font-size:.82rem; font-weight:600; color:#374151; margin-bottom:.4rem; }
    .form-control { font-size:.85rem; border-radius:10px; border-color:#e2e8f0; }
    .form-control:focus { border-color:var(--accent); box-shadow:none; }
    .upload-zone { display:block; border:2px dashed #cbd5e1; border-radius:14px; padding:2rem 1rem; text-align:center; cursor:pointer; background:#f8fafc; transition:.2s ease; }
    .upload-zone:hover { border-color:var(--accent); background:var(--accent-soft); }
    .upload-zone input { display:none; }
    .upload-zone i { display:block; font-size:2.25rem; color:var(--primary); margin-bottom:.5rem; }
    .upload-zone strong { display:block; color:var(--primary-dark); font-size:.85rem; }
    .upload-zone small { color:#94a3b8; font-size:.72rem; }
    .current-file { display:flex; align-items:center; gap:.75rem; padding:.85rem 1rem; border-radius:10px; background:#eff6ff; margin-bottom:1rem; }
</style>
@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.kalender-akademik.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form method="POST"
      action="{{ $item ? route('admin.kalender-akademik.update', $item) : route('admin.kalender-akademik.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="form-card">
                <div class="form-card-header">
                    <div class="header-icon"><i class="bi bi-calendar-event-fill"></i></div>
                    <div>
                        <h6>Data Kalender Akademik</h6>
                        <small class="text-muted" style="font-size:.72rem;">Tentukan tahun ajaran dan file kalender.</small>
                    </div>
                </div>
                <div class="form-card-body">
                    <div class="mb-4">
                        <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                        <input type="text" name="tahun_ajaran"
                               class="form-control @error('tahun_ajaran') is-invalid @enderror"
                               value="{{ old('tahun_ajaran', $item?->tahun_ajaran) }}"
                               placeholder="Contoh: 2026/2027" maxlength="999" required>
                        <div class="form-text" style="font-size:.72rem;">Gunakan format empat digit tahun, misalnya 2026/2027.</div>
                        @error('tahun_ajaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    @if ($item)
                        <div class="current-file">
                            <i class="bi bi-file-earmark-check-fill text-primary" style="font-size:1.4rem;"></i>
                            <div class="flex-grow-1" style="min-width:0;">
                                <div style="font-size:.78rem;color:#64748b;">File saat ini</div>
                                <a href="{{ $item->fileUrl() }}" target="_blank" rel="noopener"
                                   style="font-size:.84rem;font-weight:600;display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    {{ $item->file_name ?: basename($item->file_path) }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <label class="upload-zone" for="calendarFile">
                        <input type="file" name="file" id="calendarFile" accept=".pdf,.jpg,.jpeg,.png" {{ $item ? '' : 'required' }}>
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                        <strong id="fileLabel">{{ $item ? 'Klik untuk mengganti file kalender' : 'Klik untuk mengunggah kalender' }}</strong>
                        <small>PDF, JPG, JPEG, atau PNG — maksimal 10 MB</small>
                    </label>
                    @error('file') <div class="text-danger mt-2" style="font-size:.8rem;">{{ $message }}</div> @enderror
                    @if ($item)
                        <div class="form-text mt-2" style="font-size:.72rem;">Kosongkan jika tidak ingin mengganti file yang sudah ada.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="header-icon" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-gear-fill"></i></div>
                    <h6>Pengaturan Tampilan</h6>
                </div>
                <div class="form-card-body">
                    <div class="mb-4">
                        <label class="form-label">Nomor Urut</label>
                        <input type="number" name="urutan"
                               class="form-control @error('urutan') is-invalid @enderror"
                               value="{{ old('urutan', $item?->urutan ?? 0) }}" min="0">
                        <div class="form-text" style="font-size:.72rem;">Angka kecil akan tampil lebih dahulu.</div>
                        @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active" style="font-size:.85rem;">
                            Tampilkan pada halaman publik
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm py-2"
                        style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:600;">
                    <i class="bi bi-floppy-fill me-1"></i>
                    {{ $item ? 'Simpan Perubahan' : 'Tambah Kalender' }}
                </button>
                <a href="{{ route('admin.kalender-akademik.index') }}" class="btn btn-sm btn-light py-2"
                   style="border-radius:10px;font-size:.85rem;">Batal</a>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    document.getElementById('calendarFile')?.addEventListener('change', function () {
        const label = document.getElementById('fileLabel');
        if (this.files[0] && label) label.textContent = this.files[0].name;
    });
</script>
@endsection
