@extends('layouts.admin')

@section('title', $item ? 'Edit Prestasi' : 'Tambah Prestasi')
@section('page-title', $item ? 'Edit Prestasi Siswa' : 'Tambah Prestasi Siswa')

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
    <a href="{{ route('admin.prestasi.index') }}" class="btn btn-sm btn-light" style="border-radius:8px;font-size:.82rem;">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<form method="POST"
      action="{{ $item ? route('admin.prestasi.update', $item) : route('admin.prestasi.store') }}"
      enctype="multipart/form-data">
    @csrf
    @if ($item) @method('PUT') @endif

    <div class="row g-4">

        {{-- KOLOM KIRI --}}
        <div class="col-lg-7">

            {{-- Kejuaraan --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#fef3c7;color:#b45309;"><i class="bi bi-award-fill"></i></div>
                    <h6>Detail Kejuaraan</h6>
                </div>
                <div class="form-card-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Kejuaraan / Lomba <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kejuaraan"
                               class="form-control @error('nama_kejuaraan') is-invalid @enderror"
                               value="{{ old('nama_kejuaraan', $item?->nama_kejuaraan) }}"
                               required maxlength="255"
                               placeholder="Olimpiade Sains Nasional 2025">
                        @error('nama_kejuaraan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="kategori"
                                   class="form-control @error('kategori') is-invalid @enderror"
                                   value="{{ old('kategori', $item?->kategori) }}"
                                   required maxlength="80"
                                   placeholder="KSN / MAPSI / Olahraga / Seni">
                            @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">Tingkat</label>
                            <select name="tingkat" class="form-select @error('tingkat') is-invalid @enderror">
                                <option value="">— Pilih tingkat —</option>
                                @foreach (['Sekolah', 'Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional'] as $t)
                                    <option value="{{ $t }}" {{ old('tingkat', $item?->tingkat) == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                            @error('tingkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-4">
                            <label class="form-label">Peringkat / Hasil</label>
                            <input type="text" name="peringkat"
                                   class="form-control @error('peringkat') is-invalid @enderror"
                                   value="{{ old('peringkat', $item?->peringkat) }}" maxlength="80"
                                   placeholder="Juara 1 / Harapan 2">
                            @error('peringkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Tanggal Lomba</label>
                            <input type="date" name="tanggal"
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   value="{{ old('tanggal', optional($item?->tanggal)->format('Y-m-d')) }}">
                            @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Penyelenggara</label>
                            <input type="text" name="penyelenggara"
                                   class="form-control @error('penyelenggara') is-invalid @enderror"
                                   value="{{ old('penyelenggara', $item?->penyelenggara) }}" maxlength="200"
                                   placeholder="Dinas Pendidikan…">
                            @error('penyelenggara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat Lomba</label>
                        <input type="text" name="tempat"
                               class="form-control @error('tempat') is-invalid @enderror"
                               value="{{ old('tempat', $item?->tempat) }}" maxlength="200"
                               placeholder="Gedung Olahraga Kota Semarang / Online">
                        @error('tempat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>

            {{-- Peserta --}}
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-people-fill"></i></div>
                    <h6>Siswa yang Berpartisipasi</h6>
                </div>
                <div class="form-card-body">

                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" name="nama_siswa"
                               class="form-control @error('nama_siswa') is-invalid @enderror"
                               value="{{ old('nama_siswa', $item?->nama_siswa) }}" maxlength="255"
                               placeholder="Ahmad Rizki, Sari Dewi (pisahkan koma untuk lebih dari 1 siswa)">
                        <div class="form-text" style="font-size:.72rem;">Untuk lebih dari satu siswa, pisahkan dengan koma.</div>
                        @error('nama_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" name="kelas"
                                   class="form-control @error('kelas') is-invalid @enderror"
                                   value="{{ old('kelas', $item?->kelas) }}" maxlength="20"
                                   placeholder="6A">
                            @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Keterangan Tambahan</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="4"
                                  placeholder="Cerita singkat tentang pencapaian, proses latihan, atau info tambahan…">{{ old('deskripsi', $item?->deskripsi) }}</textarea>
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
                    <h6>Foto {{ $item ? '(Opsional)' : '(Opsional)' }}</h6>
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
                            Tampilkan di halaman Prestasi
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i>
                    {{ $item ? 'Simpan Perubahan' : 'Tambah Prestasi' }}
                </button>
                <a href="{{ route('admin.prestasi.index') }}" class="btn btn-sm btn-light py-2"
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
