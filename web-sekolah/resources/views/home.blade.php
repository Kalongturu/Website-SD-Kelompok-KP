@extends('layouts.app')

@section('title', 'Beranda')
@section('description',
    'Selamat datang di SDN Dadapsari — sekolah dasar unggulan yang membentuk generasi cerdas dan
    berkarakter.')

@section('content')

    {{-- ===================== HERO / BERANDA ===================== --}}
    <section id="beranda" class="hero">
        <div class="hero-inner">
            <span class="hero-badge">Selamat Datang di Website Resmi</span>
            <h1>SDN <span>Dadapsari</span></h1>
            <p>Membentuk generasi cerdas, berkarakter, dan berakhlak mulia melalui pendidikan dasar yang berkualitas dan
                menyenangkan.</p>
            <div class="hero-actions">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Daftar PPDB Sekarang</a>
                @else
                    <a href="#ppdb" class="btn btn-primary">Daftar PPDB Sekarang</a>
                @endauth
                <a href="#profil" class="btn btn-ghost">Kenali Kami</a>
            </div>
        </div>

        <div class="hero-stats">
            <div class="stat"><span class="stat-num" data-target="520">0</span><span class="stat-label">Siswa Aktif</span>
            </div>
            <div class="stat"><span class="stat-num" data-target="32">0</span><span class="stat-label">Guru &amp;
                    Staf</span></div>
            <div class="stat"><span class="stat-num" data-target="18">0</span><span class="stat-label">Ruang Kelas</span>
            </div>
            <div class="stat"><span class="stat-num" data-target="45">0</span><span class="stat-label">Prestasi</span>
            </div>
        </div>
    </section>

    {{-- ===================== PROFIL ===================== --}}
    <section id="profil" class="section">
        <div class="section-head">
            <span class="eyebrow">Tentang Kami</span>
            <h2>Profil Sekolah</h2>
            <p>Mengenal lebih dekat sejarah, visi misi, struktur, dan fasilitas SDN Dadapsari.</p>
        </div>

        <div class="cards-grid">
            <article id="sejarah" class="card">
                <div class="card-icon">📖</div>
                <h3>Sejarah</h3>
                <p>Berdiri sejak 1985, SDN Dadapsari telah menjadi rumah belajar bagi ribuan lulusan yang tersebar di
                    berbagai bidang.</p>
            </article>

            <article id="visi-misi" class="card">
                <div class="card-icon">🎯</div>
                <h3>Visi &amp; Misi</h3>
                <p>Mewujudkan sekolah unggul yang menghasilkan peserta didik beriman, berprestasi, dan peduli lingkungan.
                </p>
            </article>

            <article id="struktur" class="card">
                <div class="card-icon">🏛️</div>
                <h3>Struktur Organisasi</h3>
                <p>Dipimpin kepala sekolah profesional, didukung tenaga pendidik dan staf yang kompeten dan berdedikasi.</p>
            </article>

            <article id="fasilitas" class="card">
                <div class="card-icon">🏫</div>
                <h3>Fasilitas</h3>
                <p>Perpustakaan, laboratorium komputer, lapangan olahraga, UKS, dan ruang kelas yang nyaman serta modern.
                </p>
            </article>
        </div>
    </section>

    {{-- ===================== AKADEMIK ===================== --}}
    <section id="akademik" class="section section-alt">
        <div class="section-head">
            <span class="eyebrow">Pembelajaran</span>
            <h2>Akademik</h2>
            <p>Program pembelajaran yang terstruktur dan menyeluruh.</p>
        </div>

        <div class="cards-grid cards-3">
            <article id="kurikulum" class="card">
                <div class="card-icon">📚</div>
                <h3>Kurikulum</h3>
                <p>Menerapkan Kurikulum Merdeka yang berfokus pada pengembangan karakter dan kompetensi siswa.</p>
            </article>
            <article id="kalender" class="card">
                <div class="card-icon">📅</div>
                <h3>Kalender Akademik</h3>
                <p>Jadwal kegiatan belajar, ujian, dan libur sekolah yang tersusun rapi sepanjang tahun ajaran.</p>
            </article>
            <article id="guru" class="card">
                <div class="card-icon">👩‍🏫</div>
                <h3>Guru &amp; Staf</h3>
                <p>Tenaga pendidik bersertifikat yang berpengalaman dan penuh dedikasi dalam mendampingi siswa.</p>
            </article>
        </div>
    </section>

    {{-- ===================== KESISWAAN ===================== --}}
    <section id="kesiswaan" class="section">
        <div class="section-head">
            <span class="eyebrow">Aktivitas Siswa</span>
            <h2>Kesiswaan</h2>
            <p>Ruang berkembang bagi minat, bakat, dan prestasi siswa.</p>
        </div>

        <div class="cards-grid cards-3">
            <a href="{{ route('kesiswaan.ekstrakurikuler') }}" id="ekstrakurikuler" class="card">
                <div class="card-icon">⚽</div>
                <h3>Ekstrakurikuler</h3>
                <p>Pramuka, futsal, seni tari, paduan suara, dan robotik untuk menyalurkan bakat siswa.</p>
            </a>
            <a href="{{ route('kesiswaan.prestasi') }}" id="prestasi" class="card">
                <div class="card-icon">🏆</div>
                <h3>Prestasi Siswa</h3>
                <p>Berbagai juara olimpiade, lomba seni, dan kompetisi olahraga tingkat kota hingga nasional.</p>
            </a>
            <a href="{{ route('kesiswaan.tata-tertib') }}" id="tata-tertib" class="card">
                <div class="card-icon">📋</div>
                <h3>Tata Tertib</h3>
                <p>Aturan sekolah yang menumbuhkan kedisiplinan, tanggung jawab, dan akhlak mulia.</p>
            </a>
        </div>
    </section>

    {{-- ===================== INFORMASI ===================== --}}
    <section id="informasi" class="section section-alt">
        <div class="section-head">
            <span class="eyebrow">Kabar Terbaru</span>
            <h2>Informasi</h2>
            <p>Berita, pendaftaran, dan dokumentasi kegiatan sekolah.</p>
        </div>

        {{-- Berita — 3 terbaru, klik → halaman Berita & Pengumuman --}}
        <div id="berita" class="news-grid">
            @forelse ($berita as $item)
                <a href="{{ route('informasi.index') }}" class="news-card"
                   style="text-decoration:none;color:inherit;display:block;">
                    {{-- position:relative + overflow:hidden agar gambar terkurung di dalam thumb --}}
                    <div class="news-thumb"
                         style="--c1:#1a5f7a;--c2:#57c5b6;position:relative;overflow:hidden;">
                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}"
                                 alt="{{ $item->judul }}"
                                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                        @else
                            <span>📰</span>
                        @endif
                    </div>
                    <div class="news-body">
                        @if ($item->tanggal)
                            <span class="news-date">{{ $item->tanggal->translatedFormat('d F Y') }}</span>
                        @endif
                        <h3>{{ $item->judul }}</h3>
                        <p>{{ $item->preview(100) }}</p>
                    </div>
                </a>
            @empty
                <article class="news-card">
                    <div class="news-thumb" style="--c1:#1a5f7a;--c2:#57c5b6;"><span>📰</span></div>
                    <div class="news-body">
                        <span class="news-date">—</span>
                        <h3>Belum ada berita</h3>
                        <p>Berita terbaru sekolah akan tampil di sini.</p>
                    </div>
                </article>
            @endforelse
        </div>

        {{-- PPDB Banner — dari DB, klik → halaman PPDB --}}
        <div id="ppdb" class="ppdb-banner">
            <div>
                <h3>PPDB Tahun Ajaran {{ $ppdb->tahun_ajaran }}
                    {{ $ppdb->is_open ? 'Telah Dibuka!' : '' }}</h3>
                <p>{{ $ppdb->pengumuman }}</p>
            </div>
            <a href="{{ route('ppdb.index') }}" class="btn btn-primary">
                {{ $ppdb->is_open ? 'Daftar Sekarang' : 'Lihat Info PPDB' }}
            </a>
        </div>

        {{-- Galeri — preview dari DB, klik → halaman Galeri --}}
        <div id="galeri" class="gallery">
            @forelse ($galeriPreview as $foto)
                {{-- position:relative + overflow:hidden agar gambar terkurung di dalam sel --}}
                <a href="{{ route('informasi.galeri') }}" class="gallery-item"
                   style="--c1:#1a5f7a;--c2:#57c5b6;text-decoration:none;
                          position:relative;overflow:hidden;display:grid;place-items:center;">
                    @if ($foto->gambarUrl())
                        <img src="{{ $foto->gambarUrl() }}"
                             alt="{{ $foto->judul }}"
                             style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                    @else
                        <span style="position:relative;z-index:1;">📸</span>
                    @endif
                </a>
            @empty
                @foreach (['📸','🎨','🎶','⚽','🔬','📚'] as $ikon)
                    <a href="{{ route('informasi.galeri') }}" class="gallery-item"
                       style="--c1:#1a5f7a;--c2:#57c5b6;text-decoration:none;">{{ $ikon }}</a>
                @endforeach
            @endforelse
        </div>
    </section>

    {{-- ===================== KONTAK ===================== --}}
    <section id="kontak" class="section">
        <div class="section-head">
            <span class="eyebrow">Hubungi Kami</span>
            <h2>Kontak</h2>
            <p>Punya pertanyaan? Kirimkan pesan Anda kepada kami.</p>
        </div>

        <div class="contact-wrap">
            <div class="contact-info">
                <div class="contact-item"><span>📍</span>
                    <div><strong>Alamat</strong>
                        <p>Jl. Pendidikan No. 1, Dadapsari</p>
                    </div>
                </div>
                <div class="contact-item"><span>📞</span>
                    <div><strong>Telepon</strong>
                        <p>(021) 123-4567</p>
                    </div>
                </div>
                <div class="contact-item"><span>✉️</span>
                    <div><strong>Email</strong>
                        <p>dadapsarisd@gmail.com</p>
                    </div>
                </div>
            </div>

            <form class="contact-form" onsubmit="return false;">
                <div class="form-row">
                    <input type="text" placeholder="Nama Lengkap" required>
                    <input type="email" placeholder="Alamat Email" required>
                </div>
                <input type="text" placeholder="Subjek">
                <textarea rows="5" placeholder="Tulis pesan Anda..." required></textarea>
                <button type="submit" class="btn btn-primary">Kirim Pesan</button>
            </form>
        </div>
    </section>

@endsection
