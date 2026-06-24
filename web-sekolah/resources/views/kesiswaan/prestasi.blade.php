@extends('layouts.app')

@section('title', 'Prestasi Siswa')
@section('description', 'Daftar prestasi dan kejuaraan yang diraih siswa SDN Dadapsari di berbagai bidang dan tingkat.')

@push('styles')
<!-- ini bagian css -->
    <style>
        .page-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, #2a8aa3 100%);
            color: var(--white);
            padding: 3.5rem 1.5rem 5rem;
            text-align: center;
        }

        .page-header .eyebrow {
            color: var(--accent);
        }

        .page-header h1 {
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 800;
            margin: .4rem 0 .6rem;
        }

        .page-header p {
            max-width: 640px;
            margin: 0 auto;
            color: rgba(255, 255, 255, .8);
        }

        .prestasi-wrap {
            max-width: 1200px;
            margin: -3rem auto 4rem;
            padding: 0 1.25rem;
        }

        /* ── PANEL FILTER ── */
        .prestasi-panel {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.25rem 1.4rem;
            margin-bottom: 1.75rem;
        }

        .prestasi-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
            margin-bottom: 1rem;
        }

        .prestasi-tab {
            border: 1.5px solid #e2e8f0;
            background: var(--white);
            color: var(--text);
            font-size: .85rem;
            font-weight: 600;
            padding: .45rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .prestasi-tab:hover {
            border-color: var(--accent);
            color: var(--primary);
        }

        .prestasi-tab.active {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-color: transparent;
            color: var(--white);
        }

        .prestasi-filters {
            display: grid;
            grid-template-columns: 1fr 220px;
            gap: .75rem;
        }

        .prestasi-search {
            position: relative;
        }

        .prestasi-search input,
        .prestasi-filters select {
            width: 100%;
            padding: .7rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: .92rem;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .prestasi-search input {
            padding-left: 2.4rem;
        }

        .prestasi-search .ico {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
        }

        .prestasi-search input:focus,
        .prestasi-filters select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-soft);
        }

        .prestasi-count {
            font-size: .82rem;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        /* ── GRID KARTU ── */
        .prestasi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .prestasi-card {
            background: var(--white);
            border: 1px solid #eef1f5;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.4rem;
            display: flex;
            flex-direction: column;
            gap: .65rem;
            border-top: 4px solid var(--accent);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .prestasi-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .prestasi-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
        }

        .prestasi-rank {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: var(--accent-soft);
            color: var(--primary-dark);
            font-weight: 700;
            font-size: .85rem;
            padding: .3rem .8rem;
            border-radius: 50px;
        }

        .prestasi-kategori {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--primary);
        }

        .prestasi-card h3 {
            color: var(--primary-dark);
            font-size: 1.08rem;
            line-height: 1.35;
        }

        .prestasi-tags {
            display: flex;
            flex-wrap: wrap;
            gap: .4rem;
        }

        .prestasi-tags span {
            font-size: .76rem;
            color: var(--muted);
            background: var(--bg);
            padding: .25rem .6rem;
            border-radius: 8px;
        }

        .prestasi-meta {
            list-style: none;
            display: grid;
            gap: .35rem;
            margin-top: .2rem;
        }

        .prestasi-meta li {
            display: flex;
            gap: .5rem;
            align-items: flex-start;
            font-size: .88rem;
            color: var(--text);
        }

        .prestasi-meta .ico {
            flex-shrink: 0;
        }

        .prestasi-desc {
            color: var(--muted);
            font-size: .86rem;
            margin-top: .2rem;
        }

        /* ── EMPTY / NO RESULT ── */
        .empty-state {
            background: var(--white);
            border: 1.5px dashed #cbd5e1;
            border-radius: var(--radius);
            padding: 3.5rem 1.5rem;
            text-align: center;
            color: var(--muted);
        }

        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: .6rem;
        }

        .empty-state h3 {
            color: var(--primary-dark);
            margin-bottom: .3rem;
        }

        .prestasi-card {
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .prestasi-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .prestasi-grid {
                grid-template-columns: 1fr;
            }

            .prestasi-filters {
                grid-template-columns: 1fr;
            }
        }

        /* ── MODAL ── */
        .pm-overlay {
            position: fixed;
            inset: 0;
            z-index: 9000;
            background: rgba(0, 0, 0, .55);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .25s ease;
        }

        .pm-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .pm-dialog {
            background: #fff;
            border-radius: 20px;
            width: 100%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 24px 60px rgba(0, 43, 91, .25);
            transform: translateY(24px) scale(.97);
            transition: transform .25s ease;
            scrollbar-width: none;
        }

        .pm-dialog::-webkit-scrollbar {
            display: none;
        }

        .pm-overlay.open .pm-dialog {
            transform: translateY(0) scale(1);
        }

        .pm-foto {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
            border-radius: 20px 20px 0 0;
            display: block;
        }

        .pm-foto-placeholder {
            width: 100%;
            aspect-ratio: 16/9;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            border-radius: 20px 20px 0 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
        }

        .pm-foto {
            cursor: zoom-in;
            position: relative;
        }

        .pm-foto-zoom-hint {
            position: absolute;
            bottom: .6rem;
            right: .6rem;
            background: rgba(0, 0, 0, .5);
            color: #fff;
            font-size: .72rem;
            font-weight: 600;
            padding: .25rem .6rem;
            border-radius: 50px;
            pointer-events: none;
            display: flex;
            align-items: center;
            gap: .3rem;
        }

        /* ── LIGHTBOX ── */
        .pm-lightbox {
            position: fixed;
            inset: 0;
            z-index: 9500;
            background: rgba(0, 0, 0, .92);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s ease;
        }

        .pm-lightbox.open {
            opacity: 1;
            pointer-events: all;
        }

        .pm-lightbox img {
            max-width: 100%;
            max-height: 90vh;
            border-radius: 12px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, .6);
            transform: scale(.92);
            transition: transform .25s ease;
            display: block;
        }

        .pm-lightbox.open img {
            transform: scale(1);
        }

        .pm-lightbox-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 42px;
            height: 42px;
            background: rgba(255, 255, 255, .12);
            border: 1.5px solid rgba(255, 255, 255, .25);
            border-radius: 50%;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }

        .pm-lightbox-close:hover {
            background: rgba(255, 255, 255, .25);
        }

        .pm-body {
            padding: 1.5rem;
            border-top: 2px solid #e2e8f0;
        }

        .pm-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: .5rem;
            margin-bottom: .75rem;
        }

        .pm-rank {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            background: var(--accent-soft);
            color: var(--primary-dark);
            font-weight: 700;
            font-size: .9rem;
            padding: .35rem .9rem;
            border-radius: 50px;
        }

        .pm-kategori {
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--primary);
        }

        .pm-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary-dark);
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        .pm-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .6rem 1rem;
            margin-bottom: 1rem;
        }

        .pm-field label {
            display: block;
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--muted);
            margin-bottom: .15rem;
        }

        .pm-field span {
            font-size: .88rem;
            color: var(--text);
            font-weight: 500;
        }

        .pm-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 1rem 0;
        }

        .pm-desc-label {
            font-size: .7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--muted);
            margin-bottom: .4rem;
        }

        .pm-desc {
            font-size: .9rem;
            color: var(--text);
            line-height: 1.7;
        }

        .pm-close-btn {
            display: block;
            width: 100%;
            margin-top: 1.25rem;
            padding: .75rem;
            border-radius: 12px;
            background: var(--primary);
            color: #fff;
            font-size: .9rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: opacity .2s;
        }

        .pm-close-btn:hover {
            opacity: .88;
        }

        .pm-close-x {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 36px;
            height: 36px;
            background: rgba(0, 0, 0, .35);
            border: none;
            border-radius: 50%;
            color: #fff;
            font-size: 1.1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s;
        }

        .pm-close-x:hover {
            background: rgba(0, 0, 0, .55);
        }

        .pm-foto-wrap {
            position: relative;
        }
    </style>
@endpush

@section('content')

  
    <!-- Ini bagian header -->
    <section class="page-header">
        <span class="eyebrow">Kesiswaan</span>
        <h1>Prestasi Siswa</h1>
        <p>Rekam jejak kejuaraan dan penghargaan yang diraih siswa SDN Dadapsari. Saring berdasarkan kategori lomba,
            kata kunci, atau tahun pelaksanaan.</p>
    </section>

    <div class="prestasi-wrap">

        @if ($prestasi->isEmpty() && !request()->anyFilled(['kategori', 'search', 'tahun']))
            {{-- Belum ada data sama sekali --}}
            <div class="empty-state">
                <div class="empty-icon">🏆</div>
                <h3>Belum ada data prestasi</h3>
                <p>Data prestasi siswa akan tampil di sini setelah ditambahkan oleh admin.</p>
            </div>
        @else
           <!-- Ini filter -->
            <div class="prestasi-panel">
                <form id="prestasiForm" method="GET" action="{{ route('kesiswaan.prestasi') }}">
                    <input type="hidden" name="kategori" id="inputKategori"
                        value="{{ request('kategori', 'all') }}">

                    <div class="prestasi-tabs">
                        <button type="button"
                            class="prestasi-tab {{ !request('kategori') || request('kategori') === 'all' ? 'active' : '' }}"
                            onclick="setKategori('all')">Semua Kategori</button>
                        @foreach ($kategori as $kat)
                            <button type="button"
                                class="prestasi-tab {{ request('kategori') === $kat ? 'active' : '' }}"
                                onclick="setKategori(this.dataset.val)" data-val="{{ $kat }}">{{ $kat }}</button>
                        @endforeach
                    </div>

                    <div class="prestasi-filters">
                        <div class="prestasi-search">
                            <span class="ico">🔍</span>
                            <input type="text" name="search" id="prestasiSearch"
                                placeholder="Cari nama lomba atau nama siswa..."
                                value="{{ request('search', '') }}" autocomplete="off">
                        </div>
                        <select name="tahun" id="prestasiYear"
                            onchange="document.getElementById('prestasiForm').submit()">
                            <option value="all"
                                {{ !request('tahun') || request('tahun') === 'all' ? 'selected' : '' }}>Semua Tahun
                            </option>
                            @foreach ($tahun as $th)
                                <option value="{{ $th }}"
                                    {{ request('tahun') == $th ? 'selected' : '' }}>{{ $th }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <p class="prestasi-count">
                @if ($prestasi->total() > 0)
                    Menampilkan {{ $prestasi->total() }} prestasi
                    @if (request('kategori') && request('kategori') !== 'all')
                        pada kategori <strong>{{ request('kategori') }}</strong>
                    @endif
                @endif
            </p>

            {{-- ===================== GRID KARTU ===================== --}}
            @if ($prestasi->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🔎</div>
                    <h3>Tidak ada prestasi yang cocok</h3>
                    <p>Coba ubah kata kunci, kategori, atau tahun pencarian Anda.</p>
                </div>
            @else
                <div class="prestasi-grid">
                    @foreach ($prestasi as $item)
                        @php
                            $p = strtolower($item->peringkat ?? '');
                            $rankIcon = str_contains($p, '1')
                                ? '🥇'
                                : (str_contains($p, '2')
                                    ? '🥈'
                                    : (str_contains($p, '3')
                                        ? '🥉'
                                        : '🏅'));
                        @endphp
                        <article class="prestasi-card"
                            data-judul="{{ $item->nama_kejuaraan }}"
                            data-peringkat="{{ $item->peringkat ?: 'Peserta' }}"
                            data-rank-icon="{{ str_contains(strtolower($item->peringkat ?? ''), '1') ? '🥇' : (str_contains(strtolower($item->peringkat ?? ''), '2') ? '🥈' : (str_contains(strtolower($item->peringkat ?? ''), '3') ? '🥉' : '🏅')) }}"
                            data-kategori="{{ $item->kategori }}"
                            data-tingkat="{{ $item->tingkat }}"
                            data-tanggal="{{ $item->tanggal ? $item->tanggal->translatedFormat('d F Y') : '' }}"
                            data-siswa="{{ $item->nama_siswa }}" data-kelas="{{ $item->kelas }}"
                            data-penyelenggara="{{ $item->penyelenggara }}" data-tempat="{{ $item->tempat }}"
                            data-deskripsi="{{ $item->deskripsi }}" data-foto="{{ $item->fotoUrl() }}"
                            tabindex="0" role="button" aria-label="Detail {{ $item->nama_kejuaraan }}"
                            onclick="bukaModalPrestasi(this)">
                            <div class="prestasi-top">
                                <span class="prestasi-rank">{{ $rankIcon }}
                                    {{ $item->peringkat ?: 'Peserta' }}</span>
                                <span class="prestasi-kategori">{{ $item->kategori }}</span>
                            </div>

                            <h3>{{ $item->nama_kejuaraan }}</h3>

                            <div class="prestasi-tags">
                                @if ($item->tanggal)
                                    <span>📅 {{ $item->tanggal->translatedFormat('d M Y') }}</span>
                                @endif
                                @if ($item->tingkat)
                                    <span>🏷️ Tingkat {{ $item->tingkat }}</span>
                                @endif
                            </div>

                            <ul class="prestasi-meta">
                                @if ($item->nama_siswa)
                                    <li><span class="ico">👤</span><span>{{ $item->nama_siswa }}@if ($item->kelas)
                                                <em
                                                    style="color:var(--muted);font-style:normal;"> — {{ $item->kelas }}</em>
                                            @endif
                                        </span></li>
                                @endif
                                @if ($item->penyelenggara)
                                    <li><span class="ico">🏫</span><span>{{ $item->penyelenggara }}</span></li>
                                @endif
                            </ul>

                            @if ($item->deskripsi)
                                <p class="prestasi-desc">{{ $item->deskripsi }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>

                {{ $prestasi->links('partials.pagination') }}
            @endif
        @endif
    </div>

@endsection

{{-- ===================== LIGHTBOX ===================== --}}
<div class="pm-lightbox" id="pmLightbox" onclick="tutupLightbox()">
    <button class="pm-lightbox-close" onclick="tutupLightbox()" aria-label="Tutup">✕</button>
    <img id="pmLightboxImg" src="" alt="">
</div>

{{-- ===================== MODAL DETAIL PRESTASI ===================== --}}
<div class="pm-overlay" id="prestasiModal" role="dialog" aria-modal="true" aria-labelledby="pmTitle">
    <div class="pm-dialog">
        <div class="pm-foto-wrap" id="pmFotoWrap">
            {{-- foto atau placeholder diisi via JS --}}
        </div>
        <div class="pm-body">
            <div class="pm-top">
                <span class="pm-rank" id="pmRank"></span>
                <span class="pm-kategori" id="pmKategori"></span>
            </div>
            <h2 class="pm-title" id="pmTitle"></h2>

            <div class="pm-grid" id="pmGrid">
                {{-- field diisi via JS --}}
            </div>

            <div id="pmDescWrap" style="display:none;">
                <div class="pm-divider"></div>
                <p class="pm-desc-label">Deskripsi</p>
                <p class="pm-desc" id="pmDesc"></p>
            </div>

            <button class="pm-close-btn" onclick="tutupModalPrestasi()">Tutup</button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function setKategori(val) {
            document.getElementById('inputKategori').value = val;
            document.getElementById('prestasiForm').submit();
        }

        (function() {
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (document.getElementById('pmLightbox').classList.contains('open')) {
                        tutupLightbox();
                    } else {
                        tutupModalPrestasi();
                    }
                }
            });
        })();

        function bukaModalPrestasi(card) {
            const d = card.dataset;
            const modal = document.getElementById('prestasiModal');

            // Foto / placeholder
            const fotoWrap = document.getElementById('pmFotoWrap');
            if (d.foto && d.foto !== 'null' && d.foto !== '') {
                fotoWrap.innerHTML =
                    '<button class="pm-close-x" onclick="tutupModalPrestasi()" aria-label="Tutup">✕</button>' +
                    '<img class="pm-foto" src="' + d.foto + '" alt="' + d.judul + '" onclick="bukaLightbox(\'' + d.foto
                    .replace(/'/g, "\\'") + '\', \'' + (d.judul || '').replace(/'/g, "\\'") + '\')">'
            } else {
                fotoWrap.innerHTML =
                    '<button class="pm-close-x" onclick="tutupModalPrestasi()" aria-label="Tutup">✕</button>' +
                    '<div class="pm-foto-placeholder">🏆</div>';
            }

            // Rank & kategori
            document.getElementById('pmRank').textContent = (d.rankIcon || '🏅') + ' ' + d.peringkat;
            document.getElementById('pmKategori').textContent = d.kategori;

            // Judul
            document.getElementById('pmTitle').textContent = d.judul;

            // Grid field — hanya tampilkan field yang berisi data
            const fields = [{
                    label: 'Tanggal',
                    value: d.tanggal
                },
                {
                    label: 'Tingkat',
                    value: d.tingkat ? 'Tingkat ' + d.tingkat : ''
                },
                {
                    label: 'Nama Siswa',
                    value: d.siswa
                },
                {
                    label: 'Kelas',
                    value: d.kelas
                },
                {
                    label: 'Penyelenggara',
                    value: d.penyelenggara
                },
                {
                    label: 'Tempat',
                    value: d.tempat
                },
            ];
            const pmGrid = document.getElementById('pmGrid');
            pmGrid.innerHTML = fields
                .filter(function(f) {
                    return f.value && f.value.trim() !== '';
                })
                .map(function(f) {
                    return '<div class="pm-field"><label>' + f.label + '</label><span>' + f.value + '</span></div>';
                }).join('');

            // Deskripsi
            const descWrap = document.getElementById('pmDescWrap');
            const descEl = document.getElementById('pmDesc');
            if (d.deskripsi && d.deskripsi.trim() !== '') {
                descEl.textContent = d.deskripsi;
                descWrap.style.display = '';
            } else {
                descWrap.style.display = 'none';
            }

            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function tutupModalPrestasi() {
            document.getElementById('prestasiModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        // Klik di luar dialog menutup modal
        document.getElementById('prestasiModal').addEventListener('click', function(e) {
            if (e.target === this) tutupModalPrestasi();
        });

        function bukaLightbox(src, alt) {
            const lb = document.getElementById('pmLightbox');
            const img = document.getElementById('pmLightboxImg');
            img.src = src;
            img.alt = alt || '';
            lb.classList.add('open');
        }

        function tutupLightbox() {
            document.getElementById('pmLightbox').classList.remove('open');
        }
    </script>
@endpush
