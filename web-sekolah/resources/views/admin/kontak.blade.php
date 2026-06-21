@extends('layouts.admin')

@section('title', 'Kontak & Footer')
@section('page-title', 'Kontak &amp; Footer')

@section('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 43, 91, .06);
        overflow: hidden;
    }

    .form-card-header {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-card-header .header-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .form-card-header h6 {
        font-size: .9rem;
        font-weight: 600;
        color: var(--primary-dark);
        margin: 0;
    }

    .form-card-header p {
        font-size: .75rem;
        color: #94a3b8;
        margin: 0;
    }

    .form-card-body { padding: 1.5rem; }

    .form-label {
        font-size: .82rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: .35rem;
    }

    .form-control, .form-control:focus {
        font-size: .85rem;
        border-radius: 10px;
        border-color: #e2e8f0;
        box-shadow: none;
    }

    .form-control:focus { border-color: var(--accent); }

    .form-text {
        font-size: .72rem;
        color: #94a3b8;
    }

    .preview-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
    }

    .preview-box h6 {
        font-size: .78rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: .75rem;
    }

    .preview-footer {
        background: #002b5b;
        border-radius: 10px;
        padding: 1.25rem;
        color: rgba(255,255,255,.75);
        font-size: .78rem;
    }

    .preview-footer strong { color: #fff; }
    .preview-footer .pf-title { font-size: .95rem; font-weight: 700; color: #fff; margin-bottom: .25rem; }
    .preview-footer .pf-section { margin-top: .85rem; }
    .preview-footer .pf-section-title { font-size: .7rem; font-weight: 600; color: var(--accent); text-transform: uppercase; letter-spacing: .05em; margin-bottom: .4rem; }
    .preview-footer .pf-bottom { border-top: 1px solid rgba(255,255,255,.12); margin-top: .85rem; padding-top: .65rem; font-size: .72rem; color: rgba(255,255,255,.5); }
</style>
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert"
            style="font-size:.85rem;">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.kontak.update') }}">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- ── Kolom Kiri: Form ── --}}
            <div class="col-lg-7">

                {{-- Identitas Sekolah --}}
                <div class="form-card mb-4">
                    <div class="form-card-header">
                        <div class="header-icon" style="background:#dbeafe;color:#1d4ed8;">
                            <i class="bi bi-building-fill"></i>
                        </div>
                        <div>
                            <h6>Identitas Sekolah</h6>
                            <p>Nama dan tagline yang tampil di footer</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror"
                                value="{{ old('nama_sekolah', $footer->nama_sekolah) }}" required maxlength="100">
                            @error('nama_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Deskripsi / Tagline</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="3" maxlength="500" placeholder="Misi singkat sekolah yang tampil di footer…">{{ old('deskripsi', $footer->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="form-card mb-4">
                    <div class="form-card-header">
                        <div class="header-icon" style="background:#dcfce7;color:#16a34a;">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <h6>Informasi Kontak</h6>
                            <p>Alamat, telepon, dan email yang tampil di footer</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                value="{{ old('alamat', $footer->alamat) }}" maxlength="200"
                                placeholder="Jl. Pendidikan No. 1, Dadapsari">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row g-3 mb-0">
                            <div class="col-sm-6">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                    value="{{ old('telepon', $footer->telepon) }}" maxlength="30"
                                    placeholder="(024) 123-4567">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $footer->email) }}" maxlength="100"
                                    placeholder="info@sdndadapsari.sch.id">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Jam Operasional --}}
                <div class="form-card mb-4">
                    <div class="form-card-header">
                        <div class="header-icon" style="background:#fef9c3;color:#ca8a04;">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div>
                            <h6>Jam Operasional</h6>
                            <p>Jadwal layanan yang ditampilkan di footer</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3 mb-0">
                            <div class="col-sm-6">
                                <label class="form-label">Senin – Jumat</label>
                                <input type="text" name="jam_weekday" class="form-control @error('jam_weekday') is-invalid @enderror"
                                    value="{{ old('jam_weekday', $footer->jam_weekday) }}" maxlength="50"
                                    placeholder="07.00 – 15.00">
                                @error('jam_weekday')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Sabtu</label>
                                <input type="text" name="jam_sabtu" class="form-control @error('jam_sabtu') is-invalid @enderror"
                                    value="{{ old('jam_sabtu', $footer->jam_sabtu) }}" maxlength="50"
                                    placeholder="07.00 – 11.00">
                                @error('jam_sabtu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Copyright --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="header-icon" style="background:var(--accent-soft);color:var(--primary);">
                            <i class="bi bi-c-circle-fill"></i>
                        </div>
                        <div>
                            <h6>Teks Copyright</h6>
                            <p>Tampil di bagian bawah footer (tahun otomatis ditambahkan)</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <label class="form-label">Teks Copyright</label>
                        <div class="input-group">
                            <span class="input-group-text" style="font-size:.8rem;background:#f8fafc;border-color:#e2e8f0;">
                                &copy; {{ date('Y') }}
                            </span>
                            <input type="text" name="copyright" class="form-control @error('copyright') is-invalid @enderror"
                                value="{{ old('copyright', $footer->copyright) }}" maxlength="200"
                                placeholder="SDN Dadapsari. Seluruh hak cipta dilindungi.">
                            @error('copyright')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text mt-1">Contoh: SDN Dadapsari. Seluruh hak cipta dilindungi.</div>
                    </div>
                </div>

            </div>

            {{-- ── Kolom Kanan: Preview + Simpan ── --}}
            <div class="col-lg-5">
                <div class="form-card mb-4" style="position:sticky;top:calc(var(--topbar-h) + 1.5rem);">
                    <div class="form-card-header">
                        <div class="header-icon" style="background:#f3e8ff;color:#7c3aed;">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <div>
                            <h6>Pratinjau Footer</h6>
                            <p>Tampilan nyata setelah disimpan</p>
                        </div>
                    </div>
                    <div class="form-card-body">
                        <div class="preview-footer" id="footerPreview">
                            <div class="pf-title" id="prev-nama">{{ $footer->nama_sekolah ?? 'SDN Dadapsari' }}</div>
                            <div id="prev-deskripsi" style="font-size:.75rem;color:rgba(255,255,255,.6);margin-top:.2rem;">
                                {{ $footer->deskripsi ?? '' }}
                            </div>

                            <div class="pf-section">
                                <div class="pf-section-title">Kontak</div>
                                <div id="prev-alamat">📍 {{ $footer->alamat ?? '' }}</div>
                                <div id="prev-telepon">📞 {{ $footer->telepon ?? '' }}</div>
                                <div id="prev-email">✉️ {{ $footer->email ?? '' }}</div>
                            </div>

                            <div class="pf-section">
                                <div class="pf-section-title">Jam Operasional</div>
                                <div>Senin – Jumat: <span id="prev-weekday">{{ $footer->jam_weekday ?? '' }}</span></div>
                                <div>Sabtu: <span id="prev-sabtu">{{ $footer->jam_sabtu ?? '' }}</span></div>
                                <div style="color:rgba(255,255,255,.45);">Minggu &amp; Libur: Tutup</div>
                            </div>

                            <div class="pf-bottom">
                                &copy; {{ date('Y') }} <span id="prev-copyright">{{ $footer->copyright ?? '' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-3 pb-3 d-grid gap-2">
                        <button type="submit" class="btn btn-sm py-2"
                            style="background:var(--primary);color:#fff;border-radius:10px;font-size:.85rem;font-weight:500;">
                            <i class="bi bi-floppy-fill me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light py-2"
                            style="border-radius:10px;font-size:.85rem;">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection

@section('scripts')
<script>
    // Live preview dari form ke preview box
    const fields = {
        'nama_sekolah': 'prev-nama',
        'deskripsi':    'prev-deskripsi',
        'telepon':      'prev-telepon',
        'email':        'prev-email',
        'jam_weekday':  'prev-weekday',
        'jam_sabtu':    'prev-sabtu',
        'copyright':    'prev-copyright',
    };

    Object.entries(fields).forEach(([name, id]) => {
        const input = document.querySelector(`[name="${name}"]`);
        const el    = document.getElementById(id);
        if (!input || !el) return;

        input.addEventListener('input', () => { el.textContent = input.value; });
    });

    // Alamat perlu prefix ikon
    const alamatInput = document.querySelector('[name="alamat"]');
    const alamatEl    = document.getElementById('prev-alamat');
    if (alamatInput && alamatEl) {
        alamatInput.addEventListener('input', () => {
            alamatEl.textContent = '📍 ' + alamatInput.value;
        });
    }
</script>
@endsection
