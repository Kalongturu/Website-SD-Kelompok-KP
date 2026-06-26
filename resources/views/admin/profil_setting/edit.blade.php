@extends('layouts.admin')

@section('title', 'Konten Profil Sekolah')
@section('page-title', 'Konten Profil Sekolah')

@section('styles')
<style>
    .form-card { background:#fff; border-radius:16px; box-shadow:0 4px 16px rgba(0,43,91,.06); overflow:hidden; margin-bottom:1.25rem; }
    .form-card-header { display:flex; align-items:center; gap:.75rem; padding:1.1rem 1.5rem; border-bottom:1px solid #f1f5f9; }
    .form-card-header .hico { width:36px; height:36px; border-radius:10px; display:grid; place-items:center; font-size:1rem; flex-shrink:0; }
    .form-card-header h6 { font-size:.9rem; font-weight:600; color:var(--primary-dark); margin:0; }
    .form-card-header p  { font-size:.75rem; color:#94a3b8; margin:0; }
    .form-card-body { padding:1.5rem; }
    .form-label { font-size:.82rem; font-weight:500; color:#374151; margin-bottom:.35rem; }
    .form-control, .form-select { font-size:.85rem; border-radius:10px; border-color:#e2e8f0; }
    .form-control:focus, .form-select:focus { border-color:var(--accent); box-shadow:none; }

    /* ── TABS ── */
    .profil-tabs { display:flex; gap:.35rem; flex-wrap:wrap; margin-bottom:1.5rem; }
    .profil-tab-btn {
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: var(--text);
        font-size: .82rem;
        font-weight: 600;
        padding: .55rem 1.15rem;
        border-radius: 50px;
        cursor: pointer;
        transition: all .2s;
    }
    .profil-tab-btn:hover  { border-color:var(--accent); color:var(--primary); }
    .profil-tab-btn.active { background:linear-gradient(135deg,var(--primary),var(--accent)); border-color:transparent; color:#fff; }
    .profil-tab-pane { display:none; }
    .profil-tab-pane.active { display:block; }

    /* ── REPEATABLE ROWS ── */
    .rep-row {
        display: grid;
        gap: .6rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: .9rem 1rem;
        position: relative;
    }
    .rep-row + .rep-row { margin-top: .6rem; }
    .rep-remove {
        position: absolute;
        top: .6rem; right: .7rem;
        background: #fee2e2; border: none;
        border-radius: 6px;
        color: #dc2626;
        width: 26px; height: 26px;
        font-size: .85rem;
        cursor: pointer;
        display: grid; place-items: center;
    }
    .rep-remove:hover { background: #fecaca; }

    .add-row-btn {
        margin-top: .6rem;
        background: var(--accent-soft);
        border: 1.5px dashed var(--accent);
        color: var(--primary);
        font-size: .8rem;
        font-weight: 600;
        padding: .45rem 1rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background .2s;
    }
    .add-row-btn:hover { background: #d1fae5; }

    .misi-list { display:flex; flex-direction:column; gap:.45rem; }
    .misi-row  { display:flex; gap:.5rem; align-items:center; }
    .misi-row .drag-handle { color:#cbd5e1; cursor:grab; flex-shrink:0; }
    .misi-row input.form-control { flex:1; }
</style>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="font-size:.85rem;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif

<form method="POST" action="{{ route('admin.profil-setting.update') }}">
    @csrf @method('PUT')

    {{-- ── TAB NAVIGATION ── --}}
    <div class="profil-tabs" id="profilTabs">
        <button type="button" class="profil-tab-btn active" data-tab="sejarah">📖 Sejarah</button>
        <button type="button" class="profil-tab-btn" data-tab="visi-misi">🎯 Visi &amp; Misi</button>
        <button type="button" class="profil-tab-btn" data-tab="dana-bos">💰 Dana BOS</button>
    </div>

    {{-- ═══════════════ TAB: SEJARAH ═══════════════ --}}
    <div class="profil-tab-pane active" id="tab-sejarah">

        {{-- Sejarah Singkat --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#e0e7ff;color:#4f46e5;"><i class="bi bi-book-half"></i></div>
                <div><h6>Sejarah Singkat</h6><p>Blok utama di awal halaman Sejarah (judul + isi)</p></div>
            </div>
            <div class="form-card-body">
                <label class="form-label">Judul</label>
                <input type="text" name="sejarah_singkat_judul"
                       class="form-control @error('sejarah_singkat_judul') is-invalid @enderror"
                       value="{{ old('sejarah_singkat_judul', $setting->sejarah_singkat_judul) }}"
                       maxlength="150" placeholder="Sejarah Singkat SDN Dadapsari">
                @error('sejarah_singkat_judul') <div class="invalid-feedback">{{ $message }}</div> @enderror

                <label class="form-label mt-3">Isi</label>
                <textarea name="sejarah_singkat" class="form-control @error('sejarah_singkat') is-invalid @enderror"
                          rows="8" maxlength="5000"
                          placeholder="Tulis sejarah singkat sekolah…">{{ old('sejarah_singkat', $setting->sejarah_singkat) }}</textarea>
                <div class="form-text mt-1" style="font-size:.72rem;">Pisahkan paragraf dengan baris kosong.</div>
                @error('sejarah_singkat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Paragraf Intro --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-file-text-fill"></i></div>
                <div><h6>Paragraf Pengantar</h6><p>Ditampilkan di awal halaman Sejarah</p></div>
            </div>
            <div class="form-card-body">
                <textarea name="sejarah_intro" class="form-control @error('sejarah_intro') is-invalid @enderror"
                          rows="5" maxlength="5000"
                          placeholder="Tulis paragraf pengantar sejarah sekolah…">{{ old('sejarah_intro', $setting->sejarah_intro) }}</textarea>
                <div class="form-text mt-1" style="font-size:.72rem;">Pisahkan paragraf dengan baris kosong.</div>
                @error('sejarah_intro') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Timeline --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-clock-history"></i></div>
                <div><h6>Timeline Perjalanan Sekolah</h6><p>Ditampilkan sebagai garis waktu di halaman Sejarah</p></div>
            </div>
            <div class="form-card-body">
                <div id="timeline-list">
                    @php $tl = old('tl_tahun') ? null : ($setting->sejarah_timeline ?? []); @endphp
                    @if ($tl)
                        @foreach ($tl as $i => $item)
                        <div class="rep-row" id="tl-row-{{ $i }}">
                            <button type="button" class="rep-remove" onclick="removeRow(this)" title="Hapus">×</button>
                            <div class="row g-2">
                                <div class="col-sm-3">
                                    <label class="form-label">Tahun</label>
                                    <input type="text" name="tl_tahun[]" class="form-control"
                                           value="{{ $item['tahun'] }}" maxlength="10" placeholder="2024">
                                </div>
                                <div class="col-sm-9">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="tl_judul[]" class="form-control"
                                           value="{{ $item['judul'] }}" maxlength="150" placeholder="Pendirian Sekolah">
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Deskripsi</label>
                                <input type="text" name="tl_deskripsi[]" class="form-control"
                                       value="{{ $item['deskripsi'] }}" maxlength="300"
                                       placeholder="Keterangan singkat peristiwa">
                            </div>
                        </div>
                        @endforeach
                    @else
                        @foreach (old('tl_tahun', []) as $i => $t)
                        <div class="rep-row">
                            <button type="button" class="rep-remove" onclick="removeRow(this)" title="Hapus">×</button>
                            <div class="row g-2">
                                <div class="col-sm-3">
                                    <label class="form-label">Tahun</label>
                                    <input type="text" name="tl_tahun[]" class="form-control"
                                           value="{{ $t }}" maxlength="10" placeholder="2024">
                                </div>
                                <div class="col-sm-9">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="tl_judul[]" class="form-control"
                                           value="{{ old('tl_judul')[$i] ?? '' }}" maxlength="150">
                                </div>
                            </div>
                            <div>
                                <label class="form-label">Deskripsi</label>
                                <input type="text" name="tl_deskripsi[]" class="form-control"
                                       value="{{ old('tl_deskripsi')[$i] ?? '' }}" maxlength="300">
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="add-row-btn" onclick="addTimeline()">+ Tambah Item Timeline</button>
            </div>
        </div>

        {{-- Komitmen --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-heart-fill"></i></div>
                <div><h6>Paragraf Komitmen</h6><p>Ditampilkan di akhir halaman Sejarah</p></div>
            </div>
            <div class="form-card-body">
                <textarea name="sejarah_komitmen" class="form-control @error('sejarah_komitmen') is-invalid @enderror"
                          rows="4" maxlength="3000"
                          placeholder="Tulis paragraf komitmen sekolah…">{{ old('sejarah_komitmen', $setting->sejarah_komitmen) }}</textarea>
                <div class="form-text mt-1" style="font-size:.72rem;">Pisahkan paragraf dengan baris kosong.</div>
                @error('sejarah_komitmen') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

    </div>

    {{-- ═══════════════ TAB: VISI & MISI ═══════════════ --}}
    <div class="profil-tab-pane" id="tab-visi-misi">

        {{-- Visi --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-eye-fill"></i></div>
                <div><h6>Visi Sekolah</h6><p>Pernyataan visi yang ditampilkan dalam kotak kutipan</p></div>
            </div>
            <div class="form-card-body">
                <textarea name="visi" class="form-control @error('visi') is-invalid @enderror"
                          rows="3" maxlength="1000"
                          placeholder="Terwujudnya sekolah yang unggul dalam prestasi…">{{ old('visi', $setting->visi) }}</textarea>
                @error('visi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Misi --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-list-check"></i></div>
                <div><h6>Misi Sekolah</h6><p>Setiap baris = satu butir misi (tampil bernomor urut)</p></div>
            </div>
            <div class="form-card-body">
                <div class="misi-list" id="misi-list">
                    @php $misiItems = old('misi', $setting->misi ?? []); @endphp
                    @foreach ($misiItems as $m)
                    <div class="misi-row">
                        <span class="drag-handle bi bi-grip-vertical"></span>
                        <input type="text" name="misi[]" class="form-control" value="{{ $m }}" maxlength="500"
                               placeholder="Butir misi…">
                        <button type="button" class="rep-remove" style="position:static;flex-shrink:0;" onclick="removeRow(this)">×</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-row-btn mt-2" onclick="addMisiRow('misi-list', 'misi[]', 'Butir misi…')">+ Tambah Butir Misi</button>
            </div>
        </div>

        {{-- Tujuan --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#f3e8ff;color:#7c3aed;"><i class="bi bi-trophy-fill"></i></div>
                <div><h6>Tujuan Sekolah</h6><p>Setiap baris = satu butir tujuan (tampil bernomor urut)</p></div>
            </div>
            <div class="form-card-body">
                <div class="misi-list" id="tujuan-list">
                    @php $tujuanItems = old('tujuan', $setting->tujuan ?? []); @endphp
                    @foreach ($tujuanItems as $t)
                    <div class="misi-row">
                        <span class="drag-handle bi bi-grip-vertical"></span>
                        <input type="text" name="tujuan[]" class="form-control" value="{{ $t }}" maxlength="500"
                               placeholder="Butir tujuan…">
                        <button type="button" class="rep-remove" style="position:static;flex-shrink:0;" onclick="removeRow(this)">×</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="add-row-btn mt-2" onclick="addMisiRow('tujuan-list', 'tujuan[]', 'Butir tujuan…')">+ Tambah Butir Tujuan</button>
            </div>
        </div>

        {{-- Nilai --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#fef9c3;color:#ca8a04;"><i class="bi bi-stars"></i></div>
                <div><h6>Nilai-Nilai Sekolah</h6><p>Ditampilkan sebagai badge di bagian bawah halaman Visi &amp; Misi</p></div>
            </div>
            <div class="form-card-body">
                <div id="nilai-list">
                    @php $nilaiItems = old('nilai_nama') ? null : ($setting->nilai ?? []); @endphp
                    @if ($nilaiItems)
                        @foreach ($nilaiItems as $n)
                        <div class="rep-row" style="display:grid;grid-template-columns:60px 1fr;gap:.5rem;align-items:center;">
                            <button type="button" class="rep-remove" onclick="removeRow(this)" title="Hapus">×</button>
                            <input type="text" name="nilai_icon[]" class="form-control text-center" value="{{ $n['icon'] }}"
                                   maxlength="5" placeholder="🙏" style="font-size:1.2rem;">
                            <input type="text" name="nilai_nama[]" class="form-control" value="{{ $n['nama'] }}"
                                   maxlength="50" placeholder="Nama nilai">
                        </div>
                        @endforeach
                    @else
                        @foreach (old('nilai_icon', []) as $i => $ic)
                        <div class="rep-row" style="display:grid;grid-template-columns:60px 1fr;gap:.5rem;align-items:center;">
                            <button type="button" class="rep-remove" onclick="removeRow(this)" title="Hapus">×</button>
                            <input type="text" name="nilai_icon[]" class="form-control text-center" value="{{ $ic }}"
                                   maxlength="5" placeholder="🙏" style="font-size:1.2rem;">
                            <input type="text" name="nilai_nama[]" class="form-control" value="{{ old('nilai_nama')[$i] ?? '' }}"
                                   maxlength="50" placeholder="Nama nilai">
                        </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" class="add-row-btn" onclick="addNilai()">+ Tambah Nilai</button>
            </div>
        </div>

    </div>

    {{-- ═══════════════ TAB: DANA BOS ═══════════════ --}}
    <div class="profil-tab-pane" id="tab-dana-bos">

        {{-- Info Umum --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#dcfce7;color:#16a34a;"><i class="bi bi-info-circle-fill"></i></div>
                <div><h6>Informasi Umum Dana BOS</h6><p>Tampil dalam kotak ringkasan di halaman Transparansi</p></div>
            </div>
            <div class="form-card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label">Tahun Anggaran</label>
                        <input type="text" name="bos_tahun_anggaran" class="form-control @error('bos_tahun_anggaran') is-invalid @enderror"
                               value="{{ old('bos_tahun_anggaran', $setting->bos_tahun_anggaran) }}"
                               maxlength="20" placeholder="2023 / 2024">
                        @error('bos_tahun_anggaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Jumlah Siswa</label>
                        <input type="text" name="bos_jumlah_siswa" class="form-control @error('bos_jumlah_siswa') is-invalid @enderror"
                               value="{{ old('bos_jumlah_siswa', $setting->bos_jumlah_siswa) }}"
                               maxlength="50" placeholder="± 520 Siswa">
                        @error('bos_jumlah_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Dana per Siswa (SD)</label>
                        <input type="text" name="bos_dana_per_siswa" class="form-control @error('bos_dana_per_siswa') is-invalid @enderror"
                               value="{{ old('bos_dana_per_siswa', $setting->bos_dana_per_siswa) }}"
                               maxlength="80" placeholder="Rp 900.000 / tahun">
                        @error('bos_dana_per_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Total Estimasi Dana</label>
                        <input type="text" name="bos_total_estimasi" class="form-control @error('bos_total_estimasi') is-invalid @enderror"
                               value="{{ old('bos_total_estimasi', $setting->bos_total_estimasi) }}"
                               maxlength="80" placeholder="± Rp 468.000.000">
                        @error('bos_total_estimasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Komponen Penggunaan --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#dbeafe;color:#1d4ed8;"><i class="bi bi-table"></i></div>
                <div><h6>Rencana Penggunaan Dana (Tabel)</h6><p>Setiap baris = satu komponen anggaran</p></div>
            </div>
            <div class="form-card-body">
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;font-size:.82rem;" id="bos-table">
                        <thead>
                            <tr style="background:#f8fafc;">
                                <th style="padding:.6rem .75rem;text-align:left;border-bottom:2px solid #e2e8f0;min-width:220px;">Komponen</th>
                                <th style="padding:.6rem .75rem;text-align:left;border-bottom:2px solid #e2e8f0;width:70px;">%</th>
                                <th style="padding:.6rem .75rem;text-align:left;border-bottom:2px solid #e2e8f0;min-width:140px;">Estimasi (Rp)</th>
                                <th style="padding:.6rem .75rem;text-align:left;border-bottom:2px solid #e2e8f0;width:140px;">Status</th>
                                <th style="padding:.6rem .75rem;border-bottom:2px solid #e2e8f0;width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody id="bos-tbody">
                            @php $komps = old('bos_nama') ? null : ($setting->bos_komponen ?? []); @endphp
                            @if ($komps)
                                @foreach ($komps as $k)
                                <tr class="bos-row">
                                    <td style="padding:.4rem .5rem;">
                                        <input type="text" name="bos_nama[]" class="form-control form-control-sm" value="{{ $k['nama'] }}" maxlength="200">
                                    </td>
                                    <td style="padding:.4rem .5rem;">
                                        <input type="text" name="bos_persen[]" class="form-control form-control-sm" value="{{ $k['persen'] }}" maxlength="10" placeholder="5%">
                                    </td>
                                    <td style="padding:.4rem .5rem;">
                                        <input type="text" name="bos_estimasi[]" class="form-control form-control-sm" value="{{ $k['estimasi'] }}" maxlength="30" placeholder="23.400.000">
                                    </td>
                                    <td style="padding:.4rem .5rem;">
                                        <select name="bos_status[]" class="form-select form-select-sm">
                                            <option {{ $k['status'] === 'Terlaksana'   ? 'selected' : '' }}>Terlaksana</option>
                                            <option {{ $k['status'] === 'Berjalan'     ? 'selected' : '' }}>Berjalan</option>
                                            <option {{ $k['status'] === 'Direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                                        </select>
                                    </td>
                                    <td style="padding:.4rem .5rem;text-align:center;">
                                        <button type="button" onclick="removeBosRow(this)"
                                            style="background:#fee2e2;border:none;border-radius:6px;color:#dc2626;
                                                   width:26px;height:26px;cursor:pointer;font-size:.85rem;">×</button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                @foreach (old('bos_nama', []) as $i => $nm)
                                <tr class="bos-row">
                                    <td style="padding:.4rem .5rem;">
                                        <input type="text" name="bos_nama[]" class="form-control form-control-sm" value="{{ $nm }}" maxlength="200">
                                    </td>
                                    <td style="padding:.4rem .5rem;">
                                        <input type="text" name="bos_persen[]" class="form-control form-control-sm" value="{{ old('bos_persen')[$i] ?? '' }}" maxlength="10">
                                    </td>
                                    <td style="padding:.4rem .5rem;">
                                        <input type="text" name="bos_estimasi[]" class="form-control form-control-sm" value="{{ old('bos_estimasi')[$i] ?? '' }}" maxlength="30">
                                    </td>
                                    <td style="padding:.4rem .5rem;">
                                        <select name="bos_status[]" class="form-select form-select-sm">
                                            @php $st = old('bos_status')[$i] ?? 'Direncanakan'; @endphp
                                            <option {{ $st === 'Terlaksana'   ? 'selected' : '' }}>Terlaksana</option>
                                            <option {{ $st === 'Berjalan'     ? 'selected' : '' }}>Berjalan</option>
                                            <option {{ $st === 'Direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                                        </select>
                                    </td>
                                    <td style="padding:.4rem .5rem;text-align:center;">
                                        <button type="button" onclick="removeBosRow(this)"
                                            style="background:#fee2e2;border:none;border-radius:6px;color:#dc2626;
                                                   width:26px;height:26px;cursor:pointer;font-size:.85rem;">×</button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <button type="button" class="add-row-btn mt-2" onclick="addBosRow()">+ Tambah Komponen</button>
            </div>
        </div>

        {{-- Catatan --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="hico" style="background:#eff6ff;color:#3b82f6;"><i class="bi bi-info-square-fill"></i></div>
                <div><h6>Catatan / Disclaimer</h6><p>Tampil di kotak biru di bagian bawah halaman</p></div>
            </div>
            <div class="form-card-body">
                <textarea name="bos_catatan" class="form-control @error('bos_catatan') is-invalid @enderror"
                          rows="3" maxlength="2000"
                          placeholder="Data di atas merupakan rencana penggunaan Dana BOS…">{{ old('bos_catatan', $setting->bos_catatan) }}</textarea>
                @error('bos_catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

    </div>

    {{-- ── SAVE BUTTON (always visible) ── --}}
    <div style="position:sticky;bottom:1rem;z-index:10;display:flex;justify-content:flex-end;padding:.75rem 0;">
        <button type="submit" class="btn py-2 px-4"
            style="background:var(--primary);color:#fff;border-radius:12px;font-size:.9rem;font-weight:600;
                   box-shadow:0 4px 16px rgba(0,43,91,.25);">
            <i class="bi bi-floppy-fill me-2"></i>Simpan Semua Perubahan
        </button>
    </div>

</form>

@endsection

@section('scripts')
<script>
// ── TABS ──
document.getElementById('profilTabs').addEventListener('click', function (e) {
    var btn = e.target.closest('.profil-tab-btn');
    if (!btn) return;
    document.querySelectorAll('.profil-tab-btn').forEach(function (b) { b.classList.remove('active'); });
    document.querySelectorAll('.profil-tab-pane').forEach(function (p) { p.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
});

// ── REMOVE ROW ──
function removeRow(btn) {
    btn.closest('.rep-row, .misi-row').remove();
}

// ── TIMELINE ──
var tlCount = {{ count($setting->sejarah_timeline ?? []) }};
function addTimeline() {
    var html = '<div class="rep-row">' +
        '<button type="button" class="rep-remove" onclick="removeRow(this)" title="Hapus">×</button>' +
        '<div class="row g-2">' +
        '<div class="col-sm-3"><label class="form-label">Tahun</label>' +
        '<input type="text" name="tl_tahun[]" class="form-control" maxlength="10" placeholder="2024"></div>' +
        '<div class="col-sm-9"><label class="form-label">Judul</label>' +
        '<input type="text" name="tl_judul[]" class="form-control" maxlength="150" placeholder="Nama peristiwa"></div>' +
        '</div>' +
        '<div><label class="form-label">Deskripsi</label>' +
        '<input type="text" name="tl_deskripsi[]" class="form-control" maxlength="300" placeholder="Keterangan singkat"></div>' +
        '</div>';
    document.getElementById('timeline-list').insertAdjacentHTML('beforeend', html);
    tlCount++;
}

// ── MISI / TUJUAN ──
function addMisiRow(listId, fieldName, placeholder) {
    var html = '<div class="misi-row">' +
        '<span class="drag-handle bi bi-grip-vertical"></span>' +
        '<input type="text" name="' + fieldName + '" class="form-control" maxlength="500" placeholder="' + placeholder + '">' +
        '<button type="button" class="rep-remove" style="position:static;flex-shrink:0;" onclick="removeRow(this)">×</button>' +
        '</div>';
    document.getElementById(listId).insertAdjacentHTML('beforeend', html);
}

// ── NILAI ──
function addNilai() {
    var html = '<div class="rep-row" style="display:grid;grid-template-columns:60px 1fr;gap:.5rem;align-items:center;">' +
        '<button type="button" class="rep-remove" onclick="removeRow(this)" title="Hapus">×</button>' +
        '<input type="text" name="nilai_icon[]" class="form-control text-center" maxlength="5" placeholder="🙏" style="font-size:1.2rem;">' +
        '<input type="text" name="nilai_nama[]" class="form-control" maxlength="50" placeholder="Nama nilai">' +
        '</div>';
    document.getElementById('nilai-list').insertAdjacentHTML('beforeend', html);
}

// ── BOS KOMPONEN ──
function addBosRow() {
    var tr = '<tr class="bos-row">' +
        '<td style="padding:.4rem .5rem;"><input type="text" name="bos_nama[]" class="form-control form-control-sm" maxlength="200" placeholder="Komponen anggaran"></td>' +
        '<td style="padding:.4rem .5rem;"><input type="text" name="bos_persen[]" class="form-control form-control-sm" maxlength="10" placeholder="5%"></td>' +
        '<td style="padding:.4rem .5rem;"><input type="text" name="bos_estimasi[]" class="form-control form-control-sm" maxlength="30" placeholder="23.400.000"></td>' +
        '<td style="padding:.4rem .5rem;">' +
        '<select name="bos_status[]" class="form-select form-select-sm">' +
        '<option>Terlaksana</option><option selected>Berjalan</option><option>Direncanakan</option>' +
        '</select></td>' +
        '<td style="padding:.4rem .5rem;text-align:center;">' +
        '<button type="button" onclick="removeBosRow(this)" style="background:#fee2e2;border:none;border-radius:6px;color:#dc2626;width:26px;height:26px;cursor:pointer;font-size:.85rem;">×</button>' +
        '</td></tr>';
    document.getElementById('bos-tbody').insertAdjacentHTML('beforeend', tr);
}

function removeBosRow(btn) {
    btn.closest('tr').remove();
}
</script>
@endsection
