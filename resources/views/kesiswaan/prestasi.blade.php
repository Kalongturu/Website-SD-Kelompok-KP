@extends('layouts.app')

@section('title', 'Prestasi Siswa')
@section('description',
    'Daftar prestasi dan kejuaraan yang diraih siswa SDN Dadapsari di berbagai bidang dan tingkat.')

@push('styles')
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
    </style>
@endpush

@section('content')

    {{-- ===================== HEADER ===================== --}}
    <section class="page-header">
        <span class="eyebrow">Kesiswaan</span>
        <h1>Prestasi Siswa</h1>
        <p>Rekam jejak kejuaraan dan penghargaan yang diraih siswa SDN Dadapsari. Saring berdasarkan kategori lomba,
            kata kunci, atau tahun pelaksanaan.</p>
    </section>

    <div class="prestasi-wrap">
        @if ($prestasi->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🏆</div>
                <h3>Belum ada data prestasi</h3>
                <p>Data prestasi siswa akan tampil di sini setelah ditambahkan oleh admin.</p>
            </div>
        @else
            {{-- ===================== PANEL FILTER ===================== --}}
            <div class="prestasi-panel">
                <div class="prestasi-tabs" id="prestasiTabs">
                    <button type="button" class="prestasi-tab active" data-kategori="all">Semua Kategori</button>
                    @foreach ($kategori as $kat)
                        <button type="button" class="prestasi-tab" data-kategori="{{ $kat }}">{{ $kat }}</button>
                    @endforeach
                </div>

                <div class="prestasi-filters">
                    <div class="prestasi-search">
                        <span class="ico">🔍</span>
                        <input type="text" id="prestasiSearch" placeholder="Cari nama lomba atau nama siswa..."
                            autocomplete="off">
                    </div>
                    <select id="prestasiYear">
                        <option value="all">Semua Tahun</option>
                        @foreach ($tahun as $th)
                            <option value="{{ $th }}">{{ $th }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <p class="prestasi-count" id="prestasiCount"></p>

            {{-- ===================== GRID KARTU ===================== --}}
            <div class="prestasi-grid" id="prestasiGrid">
                @foreach ($prestasi as $item)
                    @php
                        $p = strtolower($item->peringkat ?? '');
                        $rankIcon = str_contains($p, '1') ? '🥇' : (str_contains($p, '2') ? '🥈' : (str_contains($p, '3') ? '🥉' : '🏅'));
                        $cari = strtolower(trim(($item->nama_kejuaraan ?? '') . ' ' . ($item->nama_siswa ?? '') . ' ' . ($item->penyelenggara ?? '')));
                    @endphp
                    <article class="prestasi-card" data-kategori="{{ $item->kategori }}"
                        data-tahun="{{ optional($item->tanggal)->format('Y') }}" data-cari="{{ $cari }}">
                        <div class="prestasi-top">
                            <span class="prestasi-rank">{{ $rankIcon }} {{ $item->peringkat ?: 'Peserta' }}</span>
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
                                            <em style="color:var(--muted);font-style:normal;"> — {{ $item->kelas }}</em>
                                        @endif</span></li>
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

            {{-- Pesan ketika filter tidak menemukan hasil --}}
            <div class="empty-state" id="prestasiNoResult" style="display:none;">
                <div class="empty-icon">🔎</div>
                <h3>Tidak ada prestasi yang cocok</h3>
                <p>Coba ubah kata kunci, kategori, atau tahun pencarian Anda.</p>
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            const grid = document.getElementById('prestasiGrid');
            if (!grid) return;

            const cards = Array.from(grid.querySelectorAll('.prestasi-card'));
            const tabs = document.getElementById('prestasiTabs');
            const searchInput = document.getElementById('prestasiSearch');
            const yearSelect = document.getElementById('prestasiYear');
            const countEl = document.getElementById('prestasiCount');
            const noResult = document.getElementById('prestasiNoResult');

            let activeKategori = 'all';

            function applyFilter() {
                const q = searchInput.value.trim().toLowerCase();
                const year = yearSelect.value;
                let visible = 0;

                cards.forEach(function (card) {
                    const matchKategori = activeKategori === 'all' || card.dataset.kategori === activeKategori;
                    const matchYear = year === 'all' || card.dataset.tahun === year;
                    const matchSearch = q === '' || (card.dataset.cari || '').indexOf(q) !== -1;
                    const show = matchKategori && matchYear && matchSearch;
                    card.style.display = show ? '' : 'none';
                    if (show) visible++;
                });

                countEl.textContent = 'Menampilkan ' + visible + ' dari ' + cards.length + ' prestasi';
                noResult.style.display = visible === 0 ? '' : 'none';
                grid.style.display = visible === 0 ? 'none' : '';
            }

            tabs.addEventListener('click', function (e) {
                const btn = e.target.closest('.prestasi-tab');
                if (!btn) return;
                tabs.querySelectorAll('.prestasi-tab').forEach(function (t) { t.classList.remove('active'); });
                btn.classList.add('active');
                activeKategori = btn.dataset.kategori;
                applyFilter();
            });

            searchInput.addEventListener('input', applyFilter);
            yearSelect.addEventListener('change', applyFilter);

            applyFilter();
        })();
    </script>
@endpush
