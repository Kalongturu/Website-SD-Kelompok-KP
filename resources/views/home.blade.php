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
            <p>Mengenal lebih dekat sejarah, visi misi, transparansi dana, dan fasilitas SDN Dadapsari.</p>
        </div>

        <div class="cards-grid">
            <a href="{{ route('profil.sejarah') }}" id="sejarah" class="card"
               style="text-decoration:none;color:inherit;display:block;">
                <div class="card-icon">📖</div>
                <h3>Sejarah</h3>
                <p>Berdiri sejak 1985, SDN Dadapsari telah menjadi rumah belajar bagi ribuan lulusan yang tersebar di
                    berbagai bidang.</p>
            </a>

            <a href="{{ route('profil.visi-misi') }}" id="visi-misi" class="card"
               style="text-decoration:none;color:inherit;display:block;">
                <div class="card-icon">🎯</div>
                <h3>Visi &amp; Misi</h3>
                <p>Mewujudkan sekolah unggul yang menghasilkan peserta didik beriman, berprestasi, dan peduli lingkungan.
                </p>
            </a>

            <a href="{{ route('profil.transparansi-dana-bos') }}" id="transparansi-dana-bos" class="card"
               style="text-decoration:none;color:inherit;display:block;">
                <div class="card-icon">💰</div>
                <h3>Transparansi Dana BOS</h3>
                <p>Informasi penggunaan dana Bantuan Operasional Sekolah secara terbuka dan akuntabel.</p>
            </a>

            <a href="{{ route('profil.fasilitas') }}" id="fasilitas" class="card"
               style="text-decoration:none;color:inherit;display:block;">
                <div class="card-icon">🏫</div>
                <h3>Fasilitas</h3>
                <p>Perpustakaan, laboratorium komputer, lapangan olahraga, UKS, dan ruang kelas yang nyaman serta modern.
                </p>
            </a>
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
            <p>Ruang berkembang bagi minat, bakat, dan prestasi siswa SDN Dadapsari.</p>
        </div>

        {{-- Ekstrakurikuler preview — 3 dari DB, klik → halaman Ekstrakurikuler --}}
        <div id="ekstrakurikuler" style="margin-bottom:2rem;background:var(--white);border:1px solid #e2e8f0;border-radius:var(--radius);padding:1.25rem 1.5rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <span style="font-weight:700;color:var(--primary-dark);font-size:1rem;">⚽ Ekstrakurikuler</span>
                <a href="{{ route('kesiswaan.ekstrakurikuler') }}"
                   style="font-size:.82rem;font-weight:600;color:var(--accent);text-decoration:none;">Lihat Semua →</a>
            </div>
            <div class="news-grid">
                @forelse ($ekskulPreview as $e)
                    <a href="{{ route('kesiswaan.ekstrakurikuler') }}" class="news-card"
                       style="text-decoration:none;color:inherit;display:block;">
                        <div class="news-thumb"
                             style="--c1:#0f766e;--c2:#14b8a6;position:relative;overflow:hidden;">
                            @if ($e->foto)
                                <img src="{{ $e->fotoUrl() }}" alt="{{ $e->nama }}"
                                     style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                            @else
                                <span>{{ $e->icon ?: '🎯' }}</span>
                            @endif
                        </div>
                        <div class="news-body">
                            @if ($e->kategori)
                                <span class="news-date">{{ $e->kategori }}</span>
                            @endif
                            <h3>{{ $e->nama }}</h3>
                            <p>{{ $e->deskripsi_singkat ?: \Illuminate\Support\Str::limit(strip_tags($e->deskripsi), 90) ?: 'Kegiatan ekstrakurikuler unggulan SDN Dadapsari.' }}</p>
                        </div>
                    </a>
                @empty
                    @foreach ([['⚽','Olahraga','Futsal & Pramuka','Pengembangan jiwa sportivitas dan kedisiplinan siswa.'],['🎨','Seni','Seni Tari & Musik','Menyalurkan kreativitas siswa di bidang seni budaya.'],['🔬','Akademik','KIR & Olimpiade','Kompetisi ilmu pengetahuan antar sekolah.']] as [$ico,$kat,$nm,$desk])
                        <article class="news-card">
                            <div class="news-thumb" style="--c1:#0f766e;--c2:#14b8a6;"><span>{{ $ico }}</span></div>
                            <div class="news-body">
                                <span class="news-date">{{ $kat }}</span>
                                <h3>{{ $nm }}</h3>
                                <p>{{ $desk }}</p>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>

        {{-- Prestasi preview — 3 terbaru dari DB, klik → halaman Prestasi --}}
        <div id="prestasi" style="margin-bottom:2rem;background:var(--white);border:1px solid #e2e8f0;border-radius:var(--radius);padding:1.25rem 1.5rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <span style="font-weight:700;color:var(--primary-dark);font-size:1rem;">🏆 Prestasi Terbaru</span>
                <a href="{{ route('kesiswaan.prestasi') }}"
                   style="font-size:.82rem;font-weight:600;color:var(--accent);text-decoration:none;">Lihat Semua →</a>
            </div>
            <div class="news-grid">
                @forelse ($prestasiPreview as $p)
                    <a href="{{ route('kesiswaan.prestasi') }}" class="news-card"
                       style="text-decoration:none;color:inherit;display:block;">
                        <div class="news-thumb"
                             style="--c1:#78350f;--c2:#f59e0b;position:relative;overflow:hidden;">
                            @if ($p->foto)
                                <img src="{{ $p->fotoUrl() }}" alt="{{ $p->nama_kejuaraan }}"
                                     style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;">
                            @else
                                <span>🏆</span>
                            @endif
                        </div>
                        <div class="news-body">
                            @if ($p->tanggal)
                                <span class="news-date">{{ $p->tanggal->translatedFormat('d F Y') }}</span>
                            @endif
                            <h3>{{ $p->nama_kejuaraan }}</h3>
                            <p>
                                @if ($p->peringkat) <strong>{{ $p->peringkat }}</strong> @endif
                                @if ($p->peringkat && $p->tingkat) — @endif
                                @if ($p->tingkat) Tingkat {{ $p->tingkat }} @endif
                                @if ($p->nama_siswa) · {{ $p->nama_siswa }} @endif
                            </p>
                        </div>
                    </a>
                @empty
                    @foreach ([['🥇','Juara 1 OSN Matematika','Tingkat Kota'],['🥈','Juara 2 MAPSI','Tingkat Provinsi'],['🏅','Juara 1 Futsal','Tingkat Kecamatan']] as [$ico,$nm,$tk])
                        <article class="news-card">
                            <div class="news-thumb" style="--c1:#78350f;--c2:#f59e0b;"><span>{{ $ico }}</span></div>
                            <div class="news-body">
                                <span class="news-date">Prestasi Siswa</span>
                                <h3>{{ $nm }}</h3>
                                <p>{{ $tk }} — SDN Dadapsari</p>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>

        {{-- Tata Tertib — card statis, klik → halaman Tata Tertib --}}
        <div id="tata-tertib">
            <a href="{{ route('kesiswaan.tata-tertib') }}" class="card"
               style="display:flex;flex-direction:row;align-items:center;gap:1.5rem;padding:1.5rem 2rem;
                      text-decoration:none;color:inherit;max-width:480px;margin:0 auto;">
                <div class="card-icon" style="font-size:2.5rem;flex-shrink:0;">📋</div>
                <div>
                    <h3 style="margin-bottom:.3rem;">Tata Tertib</h3>
                    <p style="margin:0;font-size:.88rem;">Aturan sekolah yang menumbuhkan kedisiplinan, tanggung jawab, dan akhlak mulia.</p>
                </div>
                <span style="margin-left:auto;font-size:1.25rem;color:var(--accent);flex-shrink:0;">→</span>
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
        <div id="berita" style="margin-bottom:2rem;background:var(--bg);border:1px solid #e2e8f0;border-radius:var(--radius);padding:1.25rem 1.5rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <span style="font-weight:700;color:var(--primary-dark);font-size:1rem;">📰 Berita Terbaru</span>
                <a href="{{ route('informasi.index') }}"
                   style="font-size:.82rem;font-weight:600;color:var(--accent);text-decoration:none;">Lihat Semua →</a>
            </div>
            <div class="news-grid">
                @forelse ($berita as $item)
                    <a href="{{ route('informasi.index') }}" class="news-card"
                       style="text-decoration:none;color:inherit;display:block;">
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
        </div>

        {{-- PPDB Banner — dari DB, klik → halaman PPDB --}}
        <div id="ppdb" style="margin-bottom:2rem;background:var(--bg);border:1px solid #e2e8f0;border-radius:var(--radius);padding:1.25rem 1.5rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <span style="font-weight:700;color:var(--primary-dark);font-size:1rem;">🎓 Pendaftaran Siswa Baru (PPDB)</span>
                <a href="{{ route('ppdb.index') }}"
                   style="font-size:.82rem;font-weight:600;color:var(--accent);text-decoration:none;">Lihat Info →</a>
            </div>
            <div class="ppdb-banner">
                <div>
                    <h3>PPDB Tahun Ajaran {{ $ppdb->tahun_ajaran }}
                        {{ $ppdb->is_open ? 'Telah Dibuka!' : '' }}</h3>
                    <p>{{ $ppdb->pengumuman }}</p>
                </div>
                <a href="{{ route('ppdb.index') }}" class="btn btn-primary">
                    {{ $ppdb->is_open ? 'Daftar Sekarang' : 'Lihat Info PPDB' }}
                </a>
            </div>
        </div>

        {{-- Galeri — preview dari DB, klik → halaman Galeri --}}
        <div id="galeri" style="background:var(--bg);border:1px solid #e2e8f0;border-radius:var(--radius);padding:1.25rem 1.5rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                <span style="font-weight:700;color:var(--primary-dark);font-size:1rem;">📷 Galeri Kegiatan</span>
                <a href="{{ route('informasi.galeri') }}"
                   style="font-size:.82rem;font-weight:600;color:var(--accent);text-decoration:none;">Lihat Semua →</a>
            </div>
            <div class="gallery">
                @forelse ($galeriPreview as $foto)
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
