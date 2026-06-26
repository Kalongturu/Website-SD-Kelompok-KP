@extends('layouts.admin')

@section('title', 'Pengaturan PPDB')
@section('page-title', 'PPDB — Pengaturan')

@section('styles')
<style>
    .form-card { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(0,43,91,.06); overflow:hidden; }
    .form-card-header { display:flex; align-items:center; gap:.75rem; padding:1.1rem 1.5rem; border-bottom:1px solid #f1f5f9; }
    .form-card-header .hico { width:36px; height:36px; border-radius:10px; display:grid; place-items:center; font-size:1rem; flex-shrink:0; }
    .form-card-header h6 { font-size:.9rem; font-weight:600; color:var(--primary-dark); margin:0; }
    .form-card-header p { font-size:.75rem; color:#94a3b8; margin:0; }
    .form-card-body { padding:1.5rem; }
    .form-label { font-size:.82rem; font-weight:500; color:#374151; margin-bottom:.35rem; }
    .form-control,.form-select { font-size:.85rem; border-radius:10px; border-color:#e2e8f0; }
    .form-control:focus,.form-select:focus { border-color:var(--accent); box-shadow:none; }

    .status-banner {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }

    .status-banner.open  { background: #dcfce7; border: 1px solid #bbf7d0; }
    .status-banner.close { background: #fee2e2; border: 1px solid #fecaca; }
    .status-banner i { font-size: 1.75rem; }
    .status-banner.open i  { color: #16a34a; }
    .status-banner.close i { color: #dc2626; }
</style>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="font-size:.85rem;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Status Banner --}}
<div class="status-banner {{ $ppdb->is_open ? 'open' : 'close' }}">
    <i class="bi bi-{{ $ppdb->is_open ? 'door-open-fill' : 'door-closed-fill' }}"></i>
    <div>
        <div class="fw-600" style="font-size:.95rem;color:{{ $ppdb->is_open ? '#15803d' : '#991b1b' }};">
            PPDB {{ $ppdb->tahun_ajaran }} sedang {{ $ppdb->is_open ? 'DIBUKA' : 'DITUTUP' }}
        </div>
        <div style="font-size:.78rem;color:#64748b;">
            @if ($ppdb->is_open && $ppdb->tanggal_tutup)
                Ditutup: {{ $ppdb->tanggal_tutup->translatedFormat('d F Y') }}
            @elseif (!$ppdb->is_open && $ppdb->tanggal_buka)
                Dibuka: {{ $ppdb->tanggal_buka->translatedFormat('d F Y') }}
            @else
                Atur tanggal di bawah untuk menampilkan jadwal pendaftaran.
            @endif
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.ppdb.update') }}">
    @csrf @method('PUT')

    <div class="row g-4">
        <div class="col-lg-7">

            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-mortarboard-fill"></i></div>
                    <div>
                        <h6>Informasi PPDB</h6>
                        <p>Ditampilkan pada banner PPDB di halaman beranda dan halaman PPDB</p>
                    </div>
                </div>
                <div class="form-card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-sm-5">
                            <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran') is-invalid @enderror"
                                   value="{{ old('tahun_ajaran', $ppdb->tahun_ajaran) }}"
                                   required maxlength="20" placeholder="2026/2027">
                            @error('tahun_ajaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Tanggal Dibuka</label>
                            <input type="date" name="tanggal_buka" class="form-control @error('tanggal_buka') is-invalid @enderror"
                                   value="{{ old('tanggal_buka', optional($ppdb->tanggal_buka)->format('Y-m-d')) }}">
                            @error('tanggal_buka') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-3">
                            <label class="form-label">Tanggal Ditutup</label>
                            <input type="date" name="tanggal_tutup" class="form-control @error('tanggal_tutup') is-invalid @enderror"
                                   value="{{ old('tanggal_tutup', optional($ppdb->tanggal_tutup)->format('Y-m-d')) }}">
                            @error('tanggal_tutup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Link Formulir Pendaftaran</label>
                        <input type="url" name="link_daftar" class="form-control @error('link_daftar') is-invalid @enderror"
                               value="{{ old('link_daftar', $ppdb->link_daftar) }}"
                               maxlength="500" placeholder="https://forms.gle/...">
                        <div class="form-text mt-1" style="font-size:.72rem;">URL Google Form atau sistem pendaftaran eksternal.</div>
                        @error('link_daftar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Teks Pengumuman Banner</label>
                        <textarea name="pengumuman" class="form-control @error('pengumuman') is-invalid @enderror"
                                  rows="3" maxlength="1000"
                                  placeholder="Bergabunglah bersama keluarga besar SDN Dadapsari. Kuota terbatas…">{{ old('pengumuman', $ppdb->pengumuman) }}</textarea>
                        <div class="form-text mt-1" style="font-size:.72rem;">Tampil di bawah judul banner PPDB.</div>
                        @error('pengumuman') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-5">
            <div class="form-card mb-4">
                <div class="form-card-header">
                    <div class="hico" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-toggle-on"></i></div>
                    <div>
                        <h6>Status Pendaftaran</h6>
                        <p>Mengontrol apakah PPDB terbuka untuk pendaftar</p>
                    </div>
                </div>
                <div class="form-card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_open" id="is_open" value="1"
                               {{ old('is_open', $ppdb->is_open) ? 'checked' : '' }}>
                        <label class="form-check-label fw-500" for="is_open" style="font-size:.88rem;">
                            PPDB Sedang Dibuka
                        </label>
                    </div>
                    <p class="mt-2 mb-0 text-muted" style="font-size:.78rem;">
                        Jika diaktifkan, tombol "Daftar Sekarang" di halaman beranda dan PPDB akan mengarah ke link formulir di atas.
                    </p>
                </div>
            </div>

            {{-- Preview Banner --}}
            <div class="form-card">
                <div class="form-card-header">
                    <div class="hico" style="background:#f3e8ff;color:#7c3aed;"><i class="bi bi-eye-fill"></i></div>
                    <h6>Pratinjau Banner</h6>
                </div>
                <div class="form-card-body">
                    <div style="background:linear-gradient(135deg,var(--primary-dark),var(--primary));
                         border-radius:12px;padding:1.25rem;color:#fff;">
                        <div style="font-size:.75rem;color:rgba(255,255,255,.6);margin-bottom:.3rem;">🎓 Penerimaan Peserta Didik Baru</div>
                        <div style="font-size:1rem;font-weight:700;" id="prev-tahun">
                            PPDB Tahun Ajaran {{ $ppdb->tahun_ajaran }}
                            {{ $ppdb->is_open ? 'Telah Dibuka!' : '(Belum Dibuka)' }}
                        </div>
                        <div style="font-size:.78rem;color:rgba(255,255,255,.75);margin-top:.35rem;" id="prev-peng">
                            {{ $ppdb->pengumuman }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-sm py-2"
                    style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                    <i class="bi bi-floppy-fill me-1"></i> Simpan Pengaturan PPDB
                </button>
            </div>
        </div>
    </div>
</form>

@endsection
