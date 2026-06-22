@extends('layouts.admin')

@section('title', $item ? 'Edit Pengumuman' : 'Tambah Pengumuman')
@section('page-title', $item ? 'Edit Pengumuman' : 'Tambah Pengumuman')

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
</style>
@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form method="POST"
      action="{{ $item ? route('admin.pengumuman.update', $item) : route('admin.pengumuman.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-header">
                    <div class="hico" style="background:#fef3c7;color:#d97706;"><i class="bi bi-megaphone-fill"></i></div>
                    <h6>Konten Pengumuman</h6>
                </div>
                <div class="form-card-body">
                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $item?->judul) }}" required maxlength="255">
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ringkasan</label>
                        <textarea name="ringkasan" class="form-control @error('ringkasan') is-invalid @enderror"
                                  rows="2" maxlength="500" placeholder="Preview singkat…">{{ old('ringkasan', $item?->ringkasan) }}</textarea>
                        @error('ringkasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Pengumuman <span class="text-danger">*</span></label>
                        <textarea name="isi" class="form-control @error('isi') is-invalid @enderror"
                                  rows="10" required placeholder="Tulis isi pengumuman…">{{ old('isi', $item?->isi) }}</textarea>
                        @error('isi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="form-label">Lampiran (PDF/DOC)</label>
                        @if ($item?->lampiran)
                            <p class="mb-1" style="font-size:.8rem;">
                                File saat ini:
                                <a href="{{ asset('storage/' . $item->lampiran) }}" target="_blank" class="text-primary">
                                    <i class="bi bi-paperclip"></i> Lihat Lampiran
                                </a>
                            </p>
                        @endif
                        <input type="file" name="lampiran" class="form-control @error('lampiran') is-invalid @enderror"
                               accept=".pdf,.doc,.docx">
                        <div class="form-text mt-1">PDF/DOC/DOCX, maks. 5 MB. Kosongkan jika tidak ingin mengubah.</div>
                        @error('lampiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
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

                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" name="penting" id="penting" value="1"
                               {{ old('penting', $item?->penting) ? 'checked' : '' }}>
                        <label class="form-check-label" for="penting" style="font-size:.85rem;">⚠️ Tandai sebagai penting</label>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active" style="font-size:.85rem;">Tampilkan di situs</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i>
                    {{ $item ? 'Simpan Perubahan' : 'Tambah Pengumuman' }}
                </button>
                <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-sm btn-light py-2"
                    style="border-radius:10px;font-size:.85rem;">Batal</a>
            </div>
        </div>
    </div>
</form>

@endsection
