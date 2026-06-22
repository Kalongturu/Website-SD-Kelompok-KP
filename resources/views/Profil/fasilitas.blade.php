@extends('layouts.app')

@section('title', 'Fasilitas')
@section('description', 'Fasilitas SDN Dadapsari — ruang kelas, jumlah siswa, sarana dan prasarana penunjang pembelajaran.')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, #2a8aa3 100%);
        color: var(--white);
        padding: 3.5rem 1.5rem 5rem;
        text-align: center;
    }
    .page-header .eyebrow { color: var(--accent); }
    .page-header h1 {
        font-size: clamp(1.8rem, 4vw, 2.6rem);
        font-weight: 800;
        margin: .4rem 0 .6rem;
    }
    .page-header p { max-width: 640px; margin: 0 auto; color: rgba(255,255,255,.8); }

    .fas-wrap {
        max-width: 1100px;
        margin: -3rem auto 4rem;
        padding: 0 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .fas-section-title {
        display: flex;
        align-items: center;
        gap: .75rem;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 1.1rem;
    }
    .fas-section-title .ico { font-size: 1.4rem; }

    /* ── TAB NAV ── */
    .fas-tabs {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: .75rem 1rem;
    }

    .fas-tab {
        border: 1.5px solid #e2e8f0;
        background: var(--white);
        color: var(--text);
        font-size: .85rem;
        font-weight: 600;
        padding: .55rem 1.2rem;
        border-radius: 50px;
        cursor: pointer;
        transition: all .2s ease;
        text-decoration: none;
    }
    .fas-tab:hover { border-color: var(--accent); color: var(--primary); }
    .fas-tab.active {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        border-color: transparent;
        color: #fff;
    }

    /* ── RUANG KELAS CARDS ── */
    .rk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.25rem;
    }

    .rk-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        border-top: 4px solid var(--accent);
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .rk-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }

    .rk-thumb {
        height: 140px;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        display: grid;
        place-items: center;
        font-size: 3rem;
        position: relative;
        overflow: hidden;
    }
    .rk-thumb img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .rk-body { padding: 1.1rem 1.25rem; }

    .rk-name {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: .4rem;
    }

    .rk-siswa {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: var(--accent-soft);
        color: var(--primary-dark);
        font-size: .8rem;
        font-weight: 700;
        padding: .25rem .75rem;
        border-radius: 50px;
        margin-bottom: .6rem;
    }

    .rk-ket {
        font-size: .85rem;
        color: var(--muted);
        line-height: 1.55;
    }

    /* ── SARPRAS TABLE ── */
    .sarpras-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    .sarpras-card-head {
        background: var(--accent-soft);
        color: var(--primary);
        font-weight: 700;
        letter-spacing: .5px;
        text-transform: uppercase;
        font-size: .82rem;
        padding: .9rem 1.5rem;
        border-bottom: 1px solid rgba(0,43,91,.06);
    }

    .table-scroll { overflow-x: auto; }

    table.sarpras {
        width: 100%;
        border-collapse: collapse;
        font-size: .93rem;
    }
    table.sarpras thead th {
        text-align: left;
        color: var(--text);
        font-weight: 700;
        padding: .95rem 1.4rem;
        border-bottom: 2px solid rgba(0,43,91,.08);
        white-space: nowrap;
    }
    table.sarpras th.num, table.sarpras td.num { text-align: center; }
    table.sarpras tbody td {
        padding: .8rem 1.4rem;
        color: var(--text);
        border-bottom: 1px solid rgba(0,43,91,.05);
        vertical-align: middle;
    }
    table.sarpras tbody tr:nth-child(even) { background: #fafbfc; }
    table.sarpras tbody tr:hover { background: var(--accent-soft); }
    table.sarpras .sarpras-img {
        width: 52px;
        height: 40px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }
    table.sarpras tfoot td {
        padding: .9rem 1.4rem;
        font-weight: 800;
        color: var(--primary-dark);
        border-top: 2px solid rgba(0,43,91,.12);
        background: #f4f6f9;
    }

    .sarpras-source {
        margin: .75rem .25rem 0;
        font-size: .78rem;
        color: var(--muted);
        font-style: italic;
    }
    .sarpras-source a { color: var(--primary); }

    /* ── MEDIA DIGITAL ── */
    .media-subsection { margin-bottom: 2rem; }
    .media-subtitle {
        display: flex; align-items: center; gap: .6rem;
        font-size: .95rem; font-weight: 700; color: var(--primary-dark);
        margin-bottom: 1rem; padding-bottom: .5rem;
        border-bottom: 2px solid var(--accent-soft);
    }
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.25rem;
    }
    .ebook-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        border-top: 4px solid #6366f1;
        transition: transform .25s ease, box-shadow .25s ease;
        display: flex; flex-direction: column;
    }
    .ebook-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }
    .ebook-cover {
        height: 160px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        display: grid; place-items: center;
        font-size: 3rem; position: relative; overflow: hidden;
    }
    .ebook-cover img { position:absolute;inset:0;width:100%;height:100%;object-fit:cover; }
    .ebook-body { padding: 1rem 1.1rem; flex: 1; display: flex; flex-direction: column; }
    .ebook-title { font-size: .9rem; font-weight: 700; color: var(--primary-dark); margin-bottom: .25rem; line-height: 1.35; }
    .ebook-meta { font-size: .78rem; color: var(--muted); margin-bottom: .5rem; }
    .ebook-tag { display: inline-block; background: #ede9fe; color: #5b21b6; font-size: .72rem; font-weight: 700; padding: .2rem .6rem; border-radius: 50px; margin-bottom: auto; }
    .ebook-btn {
        display: block; text-align: center; margin-top: .9rem;
        padding: .5rem; border-radius: 8px; font-size: .82rem; font-weight: 700;
        background: linear-gradient(135deg, #4f46e5, #7c3aed); color: #fff;
        text-decoration: none; transition: opacity .2s;
    }
    .ebook-btn:hover { opacity: .88; color: #fff; }

    .video-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        border-top: 4px solid #ef4444;
        transition: transform .25s ease, box-shadow .25s ease;
        display: flex; flex-direction: column;
    }
    .video-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }
    .video-thumb {
        height: 140px; position: relative; overflow: hidden;
        background: #111; display: grid; place-items: center;
    }
    .video-thumb img { position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.85; }
    .video-thumb .play-btn {
        position: relative; z-index: 1;
        width: 48px; height: 48px; border-radius: 50%;
        background: rgba(239,68,68,.9);
        display: grid; place-items: center;
        font-size: 1.3rem; color: #fff;
    }
    .video-thumb .no-thumb { font-size: 2.5rem; }
    .video-body { padding: 1rem 1.1rem; flex: 1; display: flex; flex-direction: column; }
    .video-title { font-size: .9rem; font-weight: 700; color: var(--primary-dark); margin-bottom: .25rem; line-height: 1.35; }
    .video-meta { font-size: .78rem; color: var(--muted); margin-bottom: auto; }
    .video-btn {
        display: block; text-align: center; margin-top: .9rem;
        padding: .5rem; border-radius: 8px; font-size: .82rem; font-weight: 700;
        background: linear-gradient(135deg, #dc2626, #ef4444); color: #fff;
        text-decoration: none; transition: opacity .2s;
    }
    .video-btn:hover { opacity: .88; color: #fff; }

    /* ── EMPTY ── */
    .empty-state {
        background: var(--white);
        border: 1.5px dashed #cbd5e1;
        border-radius: var(--radius);
        padding: 3rem 1.5rem;
        text-align: center;
        color: var(--muted);
    }
    .empty-state .empty-icon { font-size: 2.5rem; margin-bottom: .5rem; }
    .empty-state h3 { color: var(--primary-dark); margin-bottom: .3rem; }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        font-size: .85rem;
        color: #fff;
        text-decoration: none;
        margin-bottom: 1.25rem;
        font-weight: 600;
        text-shadow: 0 1px 6px rgba(0,0,0,.35);
    }
    .back-link:hover { color: rgba(255,255,255,.75); }

    @media (max-width: 600px) {
        .rk-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 420px) {
        .rk-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

<section class="page-header">
    <span class="eyebrow">Profil Sekolah</span>
    <h1>Fasilitas SDN Dadapsari</h1>
    <p>Informasi lengkap ruang kelas, jumlah siswa, serta sarana dan prasarana penunjang kegiatan belajar mengajar.</p>
</section>

<div class="fas-wrap">

    <div>
        <a href="{{ route('home') }}#profil" class="back-link">← Kembali ke Profil</a>

        {{-- Tab navigasi: tiap tab memuat hanya data bagian yang dipilih --}}
        <div class="fas-tabs">
            <a href="{{ route('profil.fasilitas', ['tab' => 'ruang-kelas']) }}"
               class="fas-tab {{ $tab === 'ruang-kelas' ? 'active' : '' }}">
                🏫 Ruang Kelas &amp; Siswa
            </a>
            <a href="{{ route('profil.fasilitas', ['tab' => 'sarpras']) }}"
               class="fas-tab {{ $tab === 'sarpras' ? 'active' : '' }}">
                🔧 Sarana &amp; Prasarana
            </a>
            <a href="{{ route('profil.fasilitas', ['tab' => 'media-digital']) }}"
               class="fas-tab {{ $tab === 'media-digital' ? 'active' : '' }}">
                💻 Media Pembelajaran Digital
            </a>
        </div>
    </div>

    {{-- ===================== RUANG KELAS ===================== --}}
    @if ($tab === 'ruang-kelas')
        <div>
            <div class="fas-section-title">
                <span class="ico">🏫</span> Ruang Kelas &amp; Jumlah Siswa
            </div>

            @if ($ruangKelas->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🏫</div>
                    <h3>Data belum tersedia</h3>
                    <p>Data ruang kelas akan ditampilkan setelah diisi oleh admin.</p>
                </div>
            @else
                <div class="rk-grid">
                    @foreach ($ruangKelas as $rk)
                        <div class="rk-card">
                            <div class="rk-thumb">
                                @if ($rk->gambarUrl())
                                    <img src="{{ $rk->gambarUrl() }}" alt="{{ $rk->nama_kelas }}">
                                @else
                                    🏫
                                @endif
                            </div>
                            <div class="rk-body">
                                <div class="rk-name">{{ $rk->nama_kelas }}</div>
                                <div class="rk-siswa">👤 {{ $rk->jumlah_siswa }} Siswa</div>
                                @if ($rk->keterangan)
                                    <p class="rk-ket">{{ $rk->keterangan }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $ruangKelas->links('partials.pagination') }}
            @endif
        </div>
    @endif

    {{-- ===================== MEDIA PEMBELAJARAN DIGITAL ===================== --}}
    @if ($tab === 'media-digital')
        <div>
            <div class="fas-section-title">
                <span class="ico">💻</span> Media Pembelajaran Digital
            </div>

            {{-- E-Book --}}
            <div class="media-subsection">
                <div class="media-subtitle">📚 E-Book</div>

                @if ($ebooks->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📚</div>
                        <h3>E-Book belum tersedia</h3>
                        <p>Koleksi e-book akan segera ditambahkan oleh admin.</p>
                    </div>
                @else
                    <div class="media-grid">
                        @foreach ($ebooks as $book)
                            <div class="ebook-card">
                                <div class="ebook-cover">
                                    @if ($book->coverUrl())
                                        <img src="{{ $book->coverUrl() }}" alt="{{ $book->judul }}">
                                    @else
                                        📖
                                    @endif
                                </div>
                                <div class="ebook-body">
                                    <div class="ebook-title">{{ $book->judul }}</div>
                                    <div class="ebook-meta">
                                        @if ($book->penulis) {{ $book->penulis }} @endif
                                        @if ($book->penulis && $book->penerbit) · @endif
                                        @if ($book->penerbit) {{ $book->penerbit }} @endif
                                    </div>
                                    @if ($book->mata_pelajaran)
                                        <span class="ebook-tag">{{ $book->mata_pelajaran }}</span>
                                    @endif
                                    @if ($book->kelas)
                                        <span class="ebook-tag" style="background:#dcfce7;color:#15803d;">{{ $book->kelas }}</span>
                                    @endif
                                    <a href="{{ $book->link_url }}" target="_blank" rel="noopener"
                                       class="ebook-btn">📖 Buka E-Book</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Video Pembelajaran --}}
            <div class="media-subsection">
                <div class="media-subtitle">🎬 Video Pembelajaran</div>

                @if ($videos->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">🎬</div>
                        <h3>Video belum tersedia</h3>
                        <p>Video pembelajaran akan segera ditambahkan oleh admin.</p>
                    </div>
                @else
                    <div class="media-grid">
                        @foreach ($videos as $vid)
                            <div class="video-card">
                                <div class="video-thumb">
                                    @if ($vid->thumbnailUrl())
                                        <img src="{{ $vid->thumbnailUrl() }}" alt="{{ $vid->judul }}">
                                        <div class="play-btn">▶</div>
                                    @else
                                        <div class="no-thumb">🎬</div>
                                    @endif
                                </div>
                                <div class="video-body">
                                    <div class="video-title">{{ $vid->judul }}</div>
                                    <div class="video-meta">
                                        @if ($vid->mata_pelajaran) {{ $vid->mata_pelajaran }} @endif
                                        @if ($vid->mata_pelajaran && $vid->kelas) · @endif
                                        @if ($vid->kelas) {{ $vid->kelas }} @endif
                                    </div>
                                    <a href="{{ $vid->url_video }}" target="_blank" rel="noopener"
                                       class="video-btn">▶ Tonton Video</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ===================== SARPRAS ===================== --}}
    @if ($tab === 'sarpras')
        <div>
            <div class="fas-section-title">
                <span class="ico">🔧</span> Sarana &amp; Prasarana
            </div>

            @if ($sarpras->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🔧</div>
                    <h3>Data belum tersedia</h3>
                    <p>Data sarana dan prasarana akan ditampilkan setelah diisi oleh admin.</p>
                </div>
            @else
                <div class="sarpras-card">
                    <div class="sarpras-card-head">Data Sarana &amp; Prasarana SDN Dadapsari</div>
                    <div class="table-scroll">
                        <table class="sarpras">
                            <thead>
                                <tr>
                                    <th class="num" style="width:48px;">No</th>
                                    <th>Jenis Sarana &amp; Prasarana</th>
                                    <th class="num">Jml Ganjil</th>
                                    <th class="num">Jml Genap</th>
                                    <th>Keterangan</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sarpras as $item)
                                    <tr>
                                        <td class="num">{{ $sarpras->firstItem() + $loop->index }}</td>
                                        <td>{{ $item->jenis }}</td>
                                        <td class="num">{{ $item->jumlah_ganjil }}</td>
                                        <td class="num">{{ $item->jumlah_genap }}</td>
                                        <td style="font-size:.85rem;color:var(--muted);">
                                            {{ $item->keterangan ?: '—' }}
                                        </td>
                                        <td>
                                            @if ($item->gambarUrl())
                                                <img src="{{ $item->gambarUrl() }}" alt="{{ $item->jenis }}"
                                                     class="sarpras-img">
                                            @else
                                                <span style="font-size:.8rem;color:#cbd5e1;">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td>Total Keseluruhan</td>
                                    <td class="num">{{ $totalGanjil }}</td>
                                    <td class="num">{{ $totalGenap }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <p class="sarpras-source">
                    Sumber: <a href="https://dapo.kemdikbud.go.id/" target="_blank" rel="noopener">https://dapo.kemdikbud.go.id/</a>
                </p>

                {{ $sarpras->links('partials.pagination') }}
            @endif
        </div>
    @endif

</div>

@endsection
