@extends('layouts.app')

@section('title', 'Transparansi Dana BOS')
@section('description', 'Informasi transparansi penggunaan Dana Bantuan Operasional Sekolah (BOS) SDN Dadapsari.')

@push('styles')
<style>
    /* ── HEADER — samakan dengan partials/page-header & halaman profil lain ── */
    .bos-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--primary-ink) 100%);
        color: var(--white);
        padding: 3.5rem 1.5rem 5.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .bos-header::before {
        content: '';
        position: absolute;
        width: 300px; height: 300px;
        background: rgba(255,145,11,.15);
        border-radius: 50%;
        bottom: -100px; right: -60px;
        filter: blur(8px);
    }
    /* Sisanya diwarisi dari .eyebrow di style.css, sama seperti halaman lain. */
    .bos-header .eyebrow { color: var(--accent); }
    .bos-header h1 { font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 800; margin: .4rem 0 .6rem; position: relative; }
    .bos-header p  { max-width: 640px; margin: 0 auto; color: rgba(255,255,255,.8); position: relative; }

    /* ── LAYOUT ── */
    .bos-wrap { max-width: 1000px; margin: -3rem auto 4rem; padding: 0 1.25rem; display: grid; gap: 1.5rem; }

    /* ── CARDS ── */
    .bos-card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-lg); overflow: hidden; }
    .bos-card-head {
        display: flex; align-items: center; gap: 1rem;
        padding: 1.2rem 1.5rem; background: #fff5ea;
        border-bottom: 1px solid #f5d9b8;
    }
    .bos-card-head h3 { font-size: .95rem; font-weight: 700; color: var(--primary-dark); margin: 0; }
    .bos-card-head .ico { font-size: 1.3rem; }
    .bos-card-body { padding: 1.5rem; }

    /* ── SUMMARY STATS ── */
    .bos-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin: -3rem auto 0;
        max-width: 1000px;
        padding: 0 1.25rem;
        position: relative;
        z-index: 2;
    }
    .bos-stat-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        padding: 1.25rem 1rem 1rem;
        text-align: center;
        border-top: 4px solid var(--accent);
    }
    .bos-stat-card .label { font-size: .72rem; text-transform: uppercase; letter-spacing: .5px; font-weight: 700; color: var(--muted); margin-bottom: .3rem; }
    .bos-stat-card .value { font-size: 1.1rem; font-weight: 800; color: var(--primary-dark); }

    /* ── INFO GRID (inside card) ── */
    .bos-info-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; }
    .bos-info-item { background: var(--accent-soft); border-radius: 12px; padding: 1rem 1.25rem; border-left: 3px solid var(--accent); }
    .bos-info-item .label { font-size: .72rem; text-transform: uppercase; letter-spacing: .5px; font-weight: 700; color: var(--primary); margin-bottom: .3rem; }
    .bos-info-item .value { font-size: 1.05rem; font-weight: 700; color: var(--primary-dark); }

    /* ── TABLE ── */
    .table-scroll { overflow-x: auto; }
    table.bos-table { width: 100%; border-collapse: collapse; font-size: .9rem; }
    table.bos-table thead th {
        text-align: left; padding: .9rem 1.25rem; font-weight: 700; color: var(--text);
        border-bottom: 2px solid #f5d9b8; white-space: nowrap;
        background: var(--accent-soft);
    }
    table.bos-table th.num, table.bos-table td.num { text-align: right; }
    table.bos-table tbody td { padding: .8rem 1.25rem; color: var(--text); border-bottom: 1px solid rgba(40,40,40,.05); vertical-align: top; }
    table.bos-table tbody tr:nth-child(even) { background: var(--bg); }
    table.bos-table tbody tr:hover { background: #fff5ea; }
    table.bos-table tfoot td {
        padding: .9rem 1.25rem; font-weight: 800; color: var(--primary-dark);
        border-top: 2px solid #f5d9b8; background: #ffe6cc;
    }

    /* Badge status SENGAJA di luar palet oranye: hijau/biru/amber di sini
       membawa makna (Terlaksana / Berjalan / Direncanakan), bukan hiasan tema.
       Menyeragamkannya jadi oranye justru menghapus pembeda antarstatus. */
    .bos-badge { display: inline-block; padding: .2rem .7rem; border-radius: 50px; font-size: .72rem; font-weight: 700; }
    .bos-badge-green  { background: #dcfce7; color: #15803d; }
    .bos-badge-blue   { background: #dbeafe; color: #1d4ed8; }
    .bos-badge-amber  { background: #fef9c3; color: #ca8a04; }

    /* ── DOCUMENTS ── */
    .doc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
    .doc-item {
        background: var(--accent-soft); border-radius: 12px; padding: 1rem 1.25rem;
        border: 1.5px solid #f5d9b8;
        display: flex; align-items: flex-start; gap: .75rem;
    }
    .doc-item .doc-ico { font-size: 1.5rem; flex-shrink: 0; }
    .doc-item .doc-label { font-size: .78rem; font-weight: 700; color: var(--primary-dark); margin-bottom: .2rem; }
    .doc-item .doc-status { font-size: .75rem; color: var(--muted); }

    /* ── NOTICE ── */
    .bos-notice {
        display: flex; gap: .85rem; align-items: flex-start;
        background: var(--accent-soft); border: 1px solid #f5d9b8;
        border-radius: 12px; padding: 1rem 1.25rem;
        font-size: .88rem; color: var(--primary-dark); line-height: 1.6;
    }
    .bos-notice .ico { font-size: 1.2rem; flex-shrink: 0; margin-top: .05rem; }

    /* Beda dari halaman profil lain: di sini link jatuh DI BAWAH header (di atas
       latar terang), bukan menumpang gradient — teks putih jadi tak terlihat. */
    .back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .85rem; color: var(--primary); text-decoration: none;
        margin-bottom: 1.25rem; font-weight: 600;
    }
    .back-link:hover { color: var(--primary-ink); }

    @media (max-width: 768px) {
        .bos-stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 500px) {
        .bos-info-grid { grid-template-columns: 1fr 1fr; }
        .bos-stats-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')

<section class="bos-header">
    <span class="eyebrow">Profil Sekolah</span>
    <h1>Transparansi Dana BOS</h1>
    <p>Informasi penggunaan Dana Bantuan Operasional Sekolah (BOS) SDN Dadapsari sebagai bentuk akuntabilitas kepada masyarakat.</p>
</section>

{{-- Summary stat cards (pulled up from header) --}}
<div class="bos-stats-grid">
    <div class="bos-stat-card">
        <div class="label">Tahun Anggaran</div>
        <div class="value">{{ $setting->bos_tahun_anggaran ?: '—' }}</div>
    </div>
    <div class="bos-stat-card">
        <div class="label">Jumlah Siswa</div>
        <div class="value">{{ $setting->bos_jumlah_siswa ?: '—' }}</div>
    </div>
    <div class="bos-stat-card">
        <div class="label">Dana per Siswa (SD)</div>
        <div class="value">{{ $setting->bos_dana_per_siswa ?: '—' }}</div>
    </div>
    <div class="bos-stat-card">
        <div class="label">Total Estimasi Dana</div>
        <div class="value">{{ $setting->bos_total_estimasi ?: '—' }}</div>
    </div>
</div>

<div class="bos-wrap" style="margin-top:1.5rem;">
    <a href="{{ route('home') }}#profil" class="back-link">← Kembali ke Profil</a>

    {{-- Tabel Komponen --}}
    @if (!empty($setting->bos_komponen))
    <div class="bos-card">
        <div class="bos-card-head">
            <span class="ico">📋</span>
            <h3>Rencana Penggunaan Dana BOS</h3>
        </div>
        <div class="bos-card-body">
            <div class="table-scroll">
                <table class="bos-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Komponen Penggunaan</th>
                            <th>Persentase</th>
                            <th class="num">Estimasi Dana (Rp)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($setting->bos_komponen as $i => $k)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $k['nama'] }}</td>
                            <td>{{ $k['persen'] }}</td>
                            <td class="num">{{ $k['estimasi'] }}</td>
                            <td>
                                @if (($k['status'] ?? '') === 'Terlaksana')
                                    <span class="bos-badge bos-badge-green">Terlaksana</span>
                                @elseif (($k['status'] ?? '') === 'Berjalan')
                                    <span class="bos-badge bos-badge-blue">Berjalan</span>
                                @else
                                    <span class="bos-badge bos-badge-amber">{{ $k['status'] ?? 'Direncanakan' }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Total</td>
                            <td>100%</td>
                            <td class="num">{{ $setting->bos_total_estimasi ?: '—' }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Laporan Resmi --}}
    <div class="bos-card">
        <div class="bos-card-head">
            <span class="ico">📄</span>
            <h3>Dokumen &amp; Laporan Resmi</h3>
        </div>
        <div class="bos-card-body">
            <div class="doc-grid">
                <div class="doc-item">
                    <span class="doc-ico">📑</span>
                    <div>
                        <div class="doc-label">Laporan Triwulan I</div>
                        <div class="doc-status">Tersedia di kantor sekolah</div>
                    </div>
                </div>
                <div class="doc-item">
                    <span class="doc-ico">📑</span>
                    <div>
                        <div class="doc-label">Laporan Triwulan II</div>
                        <div class="doc-status">Tersedia di kantor sekolah</div>
                    </div>
                </div>
                <div class="doc-item">
                    <span class="doc-ico">📑</span>
                    <div>
                        <div class="doc-label">Laporan Triwulan III</div>
                        <div class="doc-status">Tersedia di kantor sekolah</div>
                    </div>
                </div>
                <div class="doc-item">
                    <span class="doc-ico">📑</span>
                    <div>
                        <div class="doc-label">Laporan Triwulan IV</div>
                        <div class="doc-status">Tersedia di kantor sekolah</div>
                    </div>
                </div>
            </div>
            <p style="margin-top:1rem;font-size:.85rem;color:var(--muted);">
                Untuk mengakses laporan lengkap Dana BOS, silakan datang langsung ke kantor sekolah pada jam kerja
                (Senin–Jumat, 07.00–15.00 WIB) atau akses melalui portal
                <a href="https://raporpendidikan.kemdikbud.go.id/" target="_blank" rel="noopener" style="color:var(--primary);font-weight:600;">Rapor Pendidikan Kemdikbud</a>.
            </p>
        </div>
    </div>

    {{-- Catatan --}}
    @if ($setting->bos_catatan)
    <div class="bos-notice">
        <span class="ico">ℹ️</span>
        <span>{{ $setting->bos_catatan }}</span>
    </div>
    @endif

</div>

@endsection
