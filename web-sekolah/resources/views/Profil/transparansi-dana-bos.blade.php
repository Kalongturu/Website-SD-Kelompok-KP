@extends('layouts.app')

@section('title', 'Transparansi Dana BOS')
@section('description', 'Informasi transparansi penggunaan Dana Bantuan Operasional Sekolah (BOS) SDN Dadapsari.')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, #2a8aa3 100%);
        color: var(--white); padding: 3.5rem 1.5rem 5rem; text-align: center;
    }
    .page-header .eyebrow { color: var(--accent); }
    .page-header h1 { font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 800; margin: .4rem 0 .6rem; }
    .page-header p  { max-width: 640px; margin: 0 auto; color: rgba(255,255,255,.8); }

    .bos-wrap { max-width: 980px; margin: -3rem auto 4rem; padding: 0 1.25rem; display: grid; gap: 1.5rem; }

    .bos-card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-lg); overflow: hidden; }
    .bos-card-head {
        display: flex; align-items: center; gap: 1rem;
        padding: 1.2rem 1.5rem; background: var(--accent-soft);
        border-bottom: 1px solid rgba(0,43,91,.06);
    }
    .bos-card-head h3 { font-size: .95rem; font-weight: 700; color: var(--primary-dark); margin: 0; }
    .bos-card-head .ico { font-size: 1.3rem; }
    .bos-card-body { padding: 1.5rem; }

    .bos-info-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1rem; }
    .bos-info-item { background: var(--bg); border-radius: 12px; padding: 1rem 1.25rem; }
    .bos-info-item .label { font-size: .72rem; text-transform: uppercase; letter-spacing: .5px; font-weight: 700; color: var(--muted); margin-bottom: .3rem; }
    .bos-info-item .value { font-size: 1.05rem; font-weight: 700; color: var(--primary-dark); }

    .table-scroll { overflow-x: auto; }
    table.bos-table { width: 100%; border-collapse: collapse; font-size: .9rem; }
    table.bos-table thead th {
        text-align: left; padding: .9rem 1.25rem; font-weight: 700; color: var(--text);
        border-bottom: 2px solid rgba(0,43,91,.08); white-space: nowrap;
    }
    table.bos-table th.num, table.bos-table td.num { text-align: right; }
    table.bos-table tbody td { padding: .8rem 1.25rem; color: var(--text); border-bottom: 1px solid rgba(0,43,91,.05); vertical-align: top; }
    table.bos-table tbody tr:nth-child(even) { background: #fafbfc; }
    table.bos-table tbody tr:hover { background: var(--accent-soft); }
    table.bos-table tfoot td { padding: .9rem 1.25rem; font-weight: 800; color: var(--primary-dark); border-top: 2px solid rgba(0,43,91,.12); background: #f4f6f9; }

    .bos-badge { display: inline-block; padding: .2rem .7rem; border-radius: 50px; font-size: .72rem; font-weight: 700; }
    .bos-badge-green { background: #dcfce7; color: #15803d; }
    .bos-badge-blue  { background: #dbeafe; color: #1d4ed8; }
    .bos-badge-amber { background: #fef9c3; color: #ca8a04; }

    .bos-notice {
        display: flex; gap: .85rem; align-items: flex-start;
        background: #eff6ff; border: 1px solid #bfdbfe;
        border-radius: 12px; padding: 1rem 1.25rem;
        font-size: .88rem; color: #1e40af; line-height: 1.6;
    }
    .bos-notice .ico { font-size: 1.2rem; flex-shrink: 0; margin-top: .05rem; }

    .back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .85rem; color: #fff; text-decoration: none;
        margin-bottom: 1.25rem; font-weight: 600;
        text-shadow: 0 1px 6px rgba(0,0,0,.35);
    }
    .back-link:hover { color: rgba(255,255,255,.75); }

    @media (max-width: 600px) { .bos-info-grid { grid-template-columns: 1fr 1fr; } }
</style>
@endpush

@section('content')

<section class="page-header">
    <span class="eyebrow">Profil Sekolah</span>
    <h1>Transparansi Dana BOS</h1>
    <p>Informasi penggunaan Dana Bantuan Operasional Sekolah (BOS) SDN Dadapsari sebagai bentuk akuntabilitas kepada masyarakat.</p>
</section>

<div class="bos-wrap">
    <a href="{{ route('home') }}#profil" class="back-link">← Kembali ke Profil</a>

    {{-- Info Umum --}}
    <div class="bos-card">
        <div class="bos-card-head">
            <span class="ico">💰</span>
            <h3>Informasi Umum Dana BOS</h3>
        </div>
        <div class="bos-card-body">
            <div class="bos-info-grid">
                <div class="bos-info-item">
                    <div class="label">Tahun Anggaran</div>
                    <div class="value">{{ $setting->bos_tahun_anggaran ?: '—' }}</div>
                </div>
                <div class="bos-info-item">
                    <div class="label">Jumlah Siswa</div>
                    <div class="value">{{ $setting->bos_jumlah_siswa ?: '—' }}</div>
                </div>
                <div class="bos-info-item">
                    <div class="label">Dana per Siswa (SD)</div>
                    <div class="value">{{ $setting->bos_dana_per_siswa ?: '—' }}</div>
                </div>
                <div class="bos-info-item">
                    <div class="label">Total Estimasi Dana</div>
                    <div class="value">{{ $setting->bos_total_estimasi ?: '—' }}</div>
                </div>
            </div>
        </div>
    </div>

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
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Laporan --}}
    <div class="bos-card">
        <div class="bos-card-head">
            <span class="ico">📄</span>
            <h3>Dokumen &amp; Laporan Resmi</h3>
        </div>
        <div class="bos-card-body">
            <div class="bos-info-grid">
                <div class="bos-info-item">
                    <div class="label">Laporan Triwulan I</div>
                    <div class="value" style="font-size:.9rem;color:var(--muted);">Tersedia di kantor sekolah</div>
                </div>
                <div class="bos-info-item">
                    <div class="label">Laporan Triwulan II</div>
                    <div class="value" style="font-size:.9rem;color:var(--muted);">Tersedia di kantor sekolah</div>
                </div>
                <div class="bos-info-item">
                    <div class="label">Laporan Triwulan III</div>
                    <div class="value" style="font-size:.9rem;color:var(--muted);">Tersedia di kantor sekolah</div>
                </div>
                <div class="bos-info-item">
                    <div class="label">Laporan Triwulan IV</div>
                    <div class="value" style="font-size:.9rem;color:var(--muted);">Tersedia di kantor sekolah</div>
                </div>
            </div>
            <p style="margin-top:1rem;font-size:.85rem;color:var(--muted);">
                Untuk mengakses laporan lengkap Dana BOS, silakan datang langsung ke kantor sekolah pada jam kerja
                (Senin–Sabtu, 07.00–14.00 WIB) atau dapat juga diakses melalui portal
                <a href="https://raporpendidikan.kemdikbud.go.id/" target="_blank" rel="noopener" style="color:var(--primary);">Rapor Pendidikan Kemdikbud</a>.
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
