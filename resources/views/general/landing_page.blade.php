<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Resmi Sekolah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f0f4ff;
            overflow-x: hidden;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(15, 23, 60, 0.95) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            letter-spacing: -0.5px;
            color: #fff !important;
        }

        .navbar-brand span {
            color: #60a5fa;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.75) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.4rem 0.9rem !important;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.1);
        }

        /* HERO */
        .hero {
            min-height: 92vh;
            background: linear-gradient(135deg, #0f172c 0%, #1e3a8a 50%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.12) 0%, transparent 70%);
            bottom: -80px;
            left: -80px;
            border-radius: 50%;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(96, 165, 250, 0.15);
            border: 1px solid rgba(96, 165, 250, 0.35);
            color: #93c5fd;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.35rem 1rem;
            border-radius: 999px;
            margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
        }

        .hero h1 {
            font-size: clamp(2.4rem, 5vw, 4rem);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -1px;
        }

        .hero h1 span {
            background: linear-gradient(90deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            color: rgba(255, 255, 255, 0.65);
            font-size: 1.1rem;
            max-width: 520px;
            line-height: 1.7;
        }

        .btn-hero-primary {
            background: linear-gradient(135deg, #3b82f6, #6d28d9);
            border: none;
            color: #fff;
            font-weight: 700;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(59, 130, 246, 0.55);
            color: #fff;
        }

        .btn-hero-outline {
            background: transparent;
            border: 1.5px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .btn-hero-outline:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.6);
            color: #fff;
            transform: translateY(-2px);
        }

        /* STATS */
        .stat-card {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 1.2rem 1.5rem;
            backdrop-filter: blur(8px);
            text-align: center;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
        }

        .stat-label {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* FEATURES */
        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .section-title span {
            background: linear-gradient(90deg, #3b82f6, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.12);
            border-color: #bfdbfe;
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.2rem;
        }

        /* NEWS */
        .news-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.08);
        }

        .news-tag {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.25rem 0.7rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* FOOTER */
        footer {
            background: #0f172c;
            color: rgba(255, 255, 255, 0.55);
        }

        footer .footer-title {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        footer a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.88rem;
        }

        footer a:hover {
            color: #60a5fa;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="bi bi-building me-2"></i>WEB <span>SEKOLAH</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-1">
                    <li class="nav-item"><a class="nav-link active" href="#"><i
                                class="bi bi-house me-1"></i>Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i
                                class="bi bi-info-circle me-1"></i>Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-book me-1"></i>Akademik</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#"><i
                                class="bi bi-people me-1"></i>Kesiswaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-images me-1"></i>Galeri</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#"><i
                                class="bi bi-envelope me-1"></i>Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="container position-relative" style="z-index:2">
            <div class="row align-items-center gy-5">
                <div class="col-lg-7">
                    <div class="hero-badge">
                        <i class="bi bi-star-fill me-1"></i> Diskominfo Magang 2025
                    </div>
                    <h1>
                        Selamat Datang di<br>
                        <span>Website Resmi</span><br>
                        Sekolah Kami
                    </h1>
                    <p class="mt-3 mb-4">
                        Platform digital terpadu untuk informasi akademik, kesiswaan, dan berita terkini sekolah. Mudah
                        diakses, informatif, dan modern.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#" class="btn btn-hero-primary">
                            <i class="bi bi-compass me-2"></i>Jelajahi Sekarang
                        </a>
                        <a href="#" class="btn btn-hero-outline">
                            <i class="bi bi-play-circle me-2"></i>Lihat Profil
                        </a>
                    </div>

                    <div class="row g-3 mt-4">
                        <div class="col-4">
                            <div class="stat-card">
                                <div class="stat-number">1.2K+</div>
                                <div class="stat-label">Siswa Aktif</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card">
                                <div class="stat-number">80+</div>
                                <div class="stat-label">Tenaga Didik</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card">
                                <div class="stat-number">25+</div>
                                <div class="stat-label">Ekskul</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-flex justify-content-center">
                    <div
                        style="width:340px;height:340px;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:32px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-mortarboard-fill" style="font-size:8rem;color:rgba(96,165,250,0.6);"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="py-5 mt-2">
        <div class="container py-4">
            <div class="text-center mb-5">
                <div class="text-primary fw-semibold small mb-2 text-uppercase letter-spacing-1">Layanan Kami</div>
                <h2 class="section-title">Semua Yang Kamu <span>Butuhkan</span></h2>
                <p class="text-muted mt-2" style="max-width:480px;margin:auto;">Akses informasi sekolah lengkap dalam
                    satu platform yang mudah digunakan.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon" style="background:#dbeafe;">
                            <i class="bi bi-book-half" style="color:#2563eb;"></i>
                        </div>
                        <h5 class="fw-700 mb-2" style="font-weight:700;">Akademik</h5>
                        <p class="text-muted small mb-0">Jadwal pelajaran, kurikulum, dan informasi program studi
                            tersedia lengkap.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon" style="background:#f3e8ff;">
                            <i class="bi bi-trophy-fill" style="color:#7c3aed;"></i>
                        </div>
                        <h5 style="font-weight:700;" class="mb-2">Prestasi</h5>
                        <p class="text-muted small mb-0">Rekam jejak prestasi siswa di tingkat lokal, nasional, hingga
                            internasional.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon" style="background:#dcfce7;">
                            <i class="bi bi-people-fill" style="color:#16a34a;"></i>
                        </div>
                        <h5 style="font-weight:700;" class="mb-2">Kesiswaan</h5>
                        <p class="text-muted small mb-0">Informasi OSIS, ekstrakurikuler, dan kegiatan siswa secara
                            menyeluruh.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon" style="background:#fee2e2;">
                            <i class="bi bi-newspaper" style="color:#dc2626;"></i>
                        </div>
                        <h5 style="font-weight:700;" class="mb-2">Berita & Agenda</h5>
                        <p class="text-muted small mb-0">Update terkini seputar kegiatan dan pengumuman resmi sekolah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWS -->
    <section class="py-5" style="background:#fff;">
        <div class="container py-4">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <div class="text-primary fw-semibold small text-uppercase mb-1">Terbaru</div>
                    <h2 class="section-title mb-0">Berita <span>Terkini</span></h2>
                </div>
                <a href="#" class="btn btn-outline-primary btn-sm rounded-pill px-3">Lihat Semua <i
                        class="bi bi-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="news-card">
                        <div
                            style="height:160px;background:linear-gradient(135deg,#3b82f6,#6d28d9);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-award-fill" style="font-size:3.5rem;color:rgba(255,255,255,0.4);"></i>
                        </div>
                        <div class="p-4">
                            <span class="news-tag bg-blue-100 text-primary"
                                style="background:#dbeafe;color:#1d4ed8;">Prestasi</span>
                            <h6 class="mt-3 fw-700" style="font-weight:700;">Siswa Raih Juara 1 Olimpiade Sains
                                Nasional</h6>
                            <p class="text-muted small">Tim siswa berhasil meraih medali emas dalam ajang OSN tingkat
                                nasional tahun ini.</p>
                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>15 Juni 2025</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="news-card">
                        <div
                            style="height:160px;background:linear-gradient(135deg,#10b981,#0d9488);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-calendar-event-fill"
                                style="font-size:3.5rem;color:rgba(255,255,255,0.4);"></i>
                        </div>
                        <div class="p-4">
                            <span class="news-tag" style="background:#dcfce7;color:#15803d;">Agenda</span>
                            <h6 class="mt-3 fw-700" style="font-weight:700;">Penerimaan Peserta Didik Baru 2025/2026
                            </h6>
                            <p class="text-muted small">Pendaftaran PPDB resmi dibuka. Segera daftarkan diri Anda
                                sebelum batas waktu.</p>
                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>10 Juni 2025</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="news-card">
                        <div
                            style="height:160px;background:linear-gradient(135deg,#f59e0b,#ef4444);display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-camera-video-fill"
                                style="font-size:3.5rem;color:rgba(255,255,255,0.4);"></i>
                        </div>
                        <div class="p-4">
                            <span class="news-tag" style="background:#fef3c7;color:#d97706;">Kegiatan</span>
                            <h6 class="mt-3 fw-700" style="font-weight:700;">Pentas Seni dan Budaya Sekolah 2025</h6>
                            <p class="text-muted small">Perayaan akhir tahun ajaran diwarnai dengan berbagai penampilan
                                seni memukau.</p>
                            <small class="text-muted"><i class="bi bi-calendar3 me-1"></i>5 Juni 2025</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA BANNER -->
    <section style="background:linear-gradient(135deg,#1e3a8a,#4c1d95);padding:5rem 0;">
        <div class="container text-center">
            <h2 style="color:#fff;font-weight:800;font-size:2rem;">Bergabunglah Bersama Kami</h2>
            <p style="color:rgba(255,255,255,0.65);max-width:480px;margin:1rem auto 2rem;">Daftarkan diri Anda dan
                jadilah bagian dari keluarga besar sekolah kami yang berprestasi.</p>
            <a href="#" class="btn btn-hero-primary me-3"><i class="bi bi-person-plus me-2"></i>Daftar
                Sekarang</a>
            <a href="#" class="btn btn-hero-outline"><i class="bi bi-telephone me-2"></i>Hubungi Kami</a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="footer-title"><i class="bi bi-building me-2"></i>WEB SEKOLAH</div>
                    <p style="font-size:0.88rem;line-height:1.7;">Platform resmi informasi sekolah. Dikembangkan oleh
                        Tim Magang Diskominfo 2025.</p>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer-title">Menu</div>
                    <ul class="list-unstyled d-flex flex-column gap-1">
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#">Profil</a></li>
                        <li><a href="#">Akademik</a></li>
                        <li><a href="#">Kesiswaan</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6">
                    <div class="footer-title">Info</div>
                    <ul class="list-unstyled d-flex flex-column gap-1">
                        <li><a href="#">Berita</a></li>
                        <li><a href="#">Galeri</a></li>
                        <li><a href="#">Prestasi</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <div class="footer-title">Kontak</div>
                    <ul class="list-unstyled d-flex flex-column gap-2" style="font-size:0.88rem;">
                        <li><i class="bi bi-geo-alt me-2 text-primary"></i>Jl. Pendidikan No. 1, Kota</li>
                        <li><i class="bi bi-telephone me-2 text-primary"></i>(021) 000-0000</li>
                        <li><i class="bi bi-envelope me-2 text-primary"></i>info@sekolah.sch.id</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color:rgba(255,255,255,0.08);margin:2rem 0 1.5rem;">
            <div class="text-center" style="font-size:0.82rem;">
                &copy; 2025 Web Sekolah &mdash; Kelompok Magang Diskominfo. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
