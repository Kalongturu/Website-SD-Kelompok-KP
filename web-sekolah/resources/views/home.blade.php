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
            <article id="ekstrakurikuler" class="card">
                <div class="card-icon">⚽</div>
                <h3>Ekstrakurikuler</h3>
                <p>Pramuka, futsal, seni tari, paduan suara, dan robotik untuk menyalurkan bakat siswa.</p>
            </article>
            <article id="prestasi" class="card">
                <div class="card-icon">🏆</div>
                <h3>Prestasi Siswa</h3>
                <p>Berbagai juara olimpiade, lomba seni, dan kompetisi olahraga tingkat kota hingga nasional.</p>
            </article>
            <article id="tata-tertib" class="card">
                <div class="card-icon">📋</div>
                <h3>Tata Tertib</h3>
                <p>Aturan sekolah yang menumbuhkan kedisiplinan, tanggung jawab, dan akhlak mulia.</p>
            </article>
        </div>
    </section>

    {{-- ===================== INFORMASI ===================== --}}
    <section id="informasi" class="section section-alt">
        <div class="section-head">
            <span class="eyebrow">Kabar Terbaru</span>
            <h2>Informasi</h2>
            <p>Berita, pendaftaran, dan dokumentasi kegiatan sekolah.</p>
        </div>

        {{-- Berita --}}
        <div id="berita" class="news-grid">
            <article class="news-card">
                <div class="news-thumb" style="--c1:#1a5f7a;--c2:#57c5b6;">📰</div>
                <div class="news-body">
                    <span class="news-date">10 Juni 2026</span>
                    <h3>Pembagian Rapor Semester Genap</h3>
                    <p>Pengambilan rapor dijadwalkan tanggal 20 Juni 2026 oleh orang tua/wali siswa.</p>
                </div>
            </article>
            <article class="news-card">
                <div class="news-thumb" style="--c1:#57c5b6;--c2:#1a5f7a;">🎓</div>
                <div class="news-body">
                    <span class="news-date">2 Juni 2026</span>
                    <h3>Wisuda &amp; Pelepasan Siswa Kelas 6</h3>
                    <p>Acara pelepasan siswa kelas 6 berlangsung khidmat di aula sekolah.</p>
                </div>
            </article>
            <article class="news-card">
                <div class="news-thumb" style="--c1:#f4a261;--c2:#1a5f7a;">🏅</div>
                <div class="news-body">
                    <span class="news-date">28 Mei 2026</span>
                    <h3>Juara 1 Lomba Cerdas Cermat</h3>
                    <p>Tim SDN Dadapsari meraih juara 1 tingkat kecamatan. Selamat!</p>
                </div>
            </article>
        </div>

        {{-- PPDB --}}
        <div id="ppdb" class="ppdb-banner">
            <div>
                <h3>PPDB Tahun Ajaran 2026/2027 Telah Dibuka!</h3>
                <p>Bergabunglah bersama keluarga besar SDN Dadapsari. Kuota terbatas, daftarkan putra-putri Anda sekarang.
                </p>
            </div>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Daftar Sekarang</a>
            @else
                <a href="#kontak" class="btn btn-primary">Daftar Sekarang</a>
            @endauth
        </div>

        {{-- Galeri --}}
        <div id="galeri" class="gallery">
            <div class="gallery-item" style="--c1:#1a5f7a;--c2:#57c5b6;">📸</div>
            <div class="gallery-item" style="--c1:#57c5b6;--c2:#f4a261;">🎨</div>
            <div class="gallery-item" style="--c1:#f4a261;--c2:#1a5f7a;">🎶</div>
            <div class="gallery-item" style="--c1:#1a5f7a;--c2:#e76f51;">⚽</div>
            <div class="gallery-item" style="--c1:#2a9d8f;--c2:#1a5f7a;">🔬</div>
            <div class="gallery-item" style="--c1:#e9c46a;--c2:#57c5b6;">📚</div>
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
