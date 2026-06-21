@extends('layouts.admin')

@section('title', $item ? 'Edit Tata Tertib' : 'Tambah Tata Tertib')
@section('page-title', $item ? 'Edit Tata Tertib' : 'Tambah Kategori Tata Tertib')

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

    .upload-zone-pdf {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 1.75rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all .2s ease;
        background: #f8fafc;
    }
    .upload-zone-pdf:hover { border-color: var(--accent); background: var(--accent-soft); }
    .upload-zone-pdf input { display: none; }
    .upload-zone-pdf .upload-icon { font-size: 2rem; color: #dc2626; margin-bottom: .5rem; }
    .upload-zone-pdf p { font-size: .82rem; color: var(--primary); margin: 0; font-weight: 500; }
    .upload-zone-pdf small { font-size: .72rem; color: #94a3b8; }

    .preview-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .preview-head {
        display: flex; align-items: center; gap: .7rem; padding: .9rem 1.1rem;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: #fff;
    }
    .preview-body { padding: .9rem 1.1rem; }
    .preview-body li { font-size: .82rem; color: #475569; padding: .2rem 0; }
</style>
@endsection

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.tata-tertib.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form method="POST"
      action="{{ $item ? route('admin.tata-tertib.update', $item) : route('admin.tata-tertib.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">

        {{-- KOLOM KIRI --}}
        <div class="col-lg-7">

            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dcfce7;color:#15803d;"><i class="bi bi-clipboard2-check-fill"></i></div>
                    <h6>Kategori Tata Tertib</h6>
                </div>
                <div class="form-card-body">

                    <div class="row g-3 mb-3">
                        <div class="col-sm-7">
                            <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="kategori"
                                   class="form-control @error('kategori') is-invalid @enderror"
                                   value="{{ old('kategori', $item?->kategori) }}"
                                   required maxlength="100" id="inputKategori"
                                   placeholder="Kewajiban Siswa / Larangan / Sanksi">
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label">Ikon (emoji)</label>
                            <input type="text" name="icon"
                                   class="form-control @error('icon') is-invalid @enderror"
                                   value="{{ old('icon', $item?->icon) }}" maxlength="10"
                                   id="inputIcon" placeholder="📋">
                            @error('icon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan"
                                   class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $item?->urutan ?? 0) }}" min="0">
                            @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Isi / Butir Aturan <span class="text-danger">*</span></label>
                        <textarea name="isi" id="inputIsi"
                                  class="form-control @error('isi') is-invalid @enderror"
                                  rows="10" required
                                  placeholder="Ketik satu butir aturan per baris, contoh:&#10;Hadir di sekolah paling lambat pukul 07.00 WIB&#10;Mengenakan seragam sesuai hari dan ketentuan&#10;Menjaga kebersihan lingkungan sekolah">{{ old('isi', $item?->isi) }}</textarea>
                        <div class="form-text mt-1" style="font-size:.72rem;">Satu baris = satu butir aturan. Setiap baris akan tampil sebagai poin terpisah di halaman tata tertib.</div>
                        @error('isi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-lg-5">

            {{-- Upload Dokumen PDF --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#fee2e2;color:#dc2626;"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div>
                        <h6>Dokumen PDF</h6>
                        <p style="font-size:.72rem;color:#94a3b8;margin:0;">Opsional — buku saku / aturan lengkap</p>
                    </div>
                </div>
                <div class="form-card-body">
                    @if ($item?->dokumen)
                        <div class="mb-3 p-3" style="background:#fef2f2;border-radius:10px;font-size:.82rem;">
                            <i class="bi bi-file-earmark-pdf-fill text-danger me-1"></i>
                            <a href="{{ $item->dokumenUrl() }}" target="_blank" style="color:var(--primary);">
                                Lihat dokumen saat ini
                            </a>
                            <div style="font-size:.7rem;color:#94a3b8;margin-top:.2rem;">
                                Upload baru di bawah untuk mengganti dokumen.
                            </div>
                        </div>
                    @endif

                    <label class="upload-zone-pdf" for="dokumenInput">
                        <input type="file" name="dokumen" id="dokumenInput" accept=".pdf">
                        <div class="upload-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                        <p id="pdfLabel">{{ $item?->dokumen ? 'Klik untuk mengganti PDF' : 'Klik untuk upload PDF' }}</p>
                        <small>Format PDF — maks. 5 MB</small>
                    </label>
                    @error('dokumen') <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div> @enderror
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
                        <label class="form-check-label" for="is_active" style="font-size:.85rem;">
                            Tampilkan di halaman Tata Tertib
                        </label>
                    </div>
                </div>
            </div>

            {{-- Pratinjau --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#f3e8ff;color:#7c3aed;"><i class="bi bi-eye-fill"></i></div>
                    <h6>Pratinjau</h6>
                </div>
                <div class="form-card-body p-0">
                    <div class="preview-card" id="previewCard">
                        <div class="preview-head">
                            <span id="prevIcon" style="font-size:1.3rem;">📋</span>
                            <span id="prevKategori" style="font-weight:700;font-size:.9rem;">Nama Kategori</span>
                        </div>
                        <div class="preview-body">
                            <ul id="prevList" style="list-style:none;padding:0;margin:0;"></ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i>
                    {{ $item ? 'Simpan Perubahan' : 'Tambah Tata Tertib' }}
                </button>
                <a href="{{ route('admin.tata-tertib.index') }}" class="btn btn-sm btn-light py-2"
                    style="border-radius:10px;font-size:.85rem;">Batal</a>
            </div>

        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
(function () {
    const ikoEl  = document.getElementById('inputIcon');
    const katEl  = document.getElementById('inputKategori');
    const isiEl  = document.getElementById('inputIsi');
    const prevIco = document.getElementById('prevIcon');
    const prevKat = document.getElementById('prevKategori');
    const prevList = document.getElementById('prevList');
    const pdfInput = document.getElementById('dokumenInput');
    const pdfLabel = document.getElementById('pdfLabel');

    function updatePreview() {
        prevIco.textContent  = ikoEl.value.trim() || '📋';
        prevKat.textContent  = katEl.value.trim() || 'Nama Kategori';

        const lines = isiEl.value.split('\n').map(l => l.trim()).filter(Boolean).slice(0, 5);
        prevList.innerHTML = lines.map(l =>
            `<li style="font-size:.8rem;color:#475569;padding:.2rem 0;border-bottom:1px solid #f1f5f9;">
                <span style="color:var(--primary);margin-right:.4rem;">•</span>${l}
            </li>`
        ).join('') || '<li style="font-size:.8rem;color:#94a3b8;padding:.2rem 0;">Ketik isi aturan di sebelah kiri…</li>';
    }

    ikoEl?.addEventListener('input', updatePreview);
    katEl?.addEventListener('input', updatePreview);
    isiEl?.addEventListener('input', updatePreview);
    updatePreview();

    pdfInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (file && pdfLabel) pdfLabel.textContent = file.name;
    });
})();
</script>
@endsection
