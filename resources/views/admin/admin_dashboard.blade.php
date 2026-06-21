<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — SDN Nusantara</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1a5f7a;
            --primary-dark: #002b5b;
            --accent: #57c5b6;
            --accent-soft: #e6f7f4;
            --sidebar-w: 260px;
            --topbar-h: 64px;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f0f4f8;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-dark) 0%, var(--primary) 100%);
            display: flex;
            flex-direction: column;
            z-index: 1050;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .sidebar-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 1.2rem;
            color: #fff;
            font-weight: 700;
        }

        .sidebar-brand .brand-text {
            color: #fff;
            font-size: .9rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .sidebar-brand .brand-text small {
            display: block;
            font-size: .7rem;
            font-weight: 400;
            color: rgba(255, 255, 255, .55);
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex: 1;
            overflow-y: auto;
        }

        .nav-label {
            padding: .4rem 1.5rem .2rem;
            font-size: .65rem;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .4);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem 1.5rem;
            color: rgba(255, 255, 255, .75);
            text-decoration: none;
            font-size: .875rem;
            border-left: 3px solid transparent;
            transition: all .2s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255, 255, 255, .08);
            color: #fff;
            border-left-color: var(--accent);
        }

        .sidebar-link i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, .1);
        }

        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: rgba(255, 255, 255, .6);
            font-size: .8rem;
            text-decoration: none;
            transition: color .2s;
        }

        .sidebar-footer a:hover {
            color: #fff;
        }

        /* ── MAIN AREA ── */
        .main-wrapper {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 1040;
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 91, .05);
        }

        .topbar-left h5 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin: 0;
        }

        .topbar-left p {
            font-size: .72rem;
            color: #94a3b8;
            margin: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .topbar-avatar {
            width: 38px;
            height: 38px;
            background: var(--accent);
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #fff;
            font-weight: 700;
            font-size: .9rem;
        }

        /* ── PAGE CONTENT ── */
        .page-content {
            padding: 1.75rem;
            flex: 1;
        }

        /* ── STAT CARDS ── */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            box-shadow: 0 4px 16px rgba(0, 43, 91, .06);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 43, 91, .12);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-icon.blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .stat-icon.green {
            background: #dcfce7;
            color: #16a34a;
        }

        .stat-icon.yellow {
            background: #fef9c3;
            color: #ca8a04;
        }

        .stat-icon.teal {
            background: var(--accent-soft);
            color: var(--primary);
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--primary-dark);
            line-height: 1;
        }

        .stat-label {
            font-size: .78rem;
            color: #94a3b8;
            margin-top: .25rem;
        }

        .stat-delta {
            font-size: .72rem;
            font-weight: 500;
            margin-top: .4rem;
        }

        .stat-delta.up {
            color: #16a34a;
        }

        .stat-delta.flat {
            color: #94a3b8;
        }

        /* ── SECTION CARDS ── */
        .section-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 43, 91, .06);
            overflow: hidden;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .section-header h6 {
            font-size: .9rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin: 0;
        }

        /* ── ACTIVITY TABLE ── */
        .activity-table td,
        .activity-table th {
            padding: .85rem 1.5rem;
            vertical-align: middle;
            font-size: .82rem;
        }

        .activity-table th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .activity-table tr:last-child td {
            border-bottom: 0;
        }

        .ikon-activity {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-grid;
            place-items: center;
            font-size: .85rem;
        }

        /* ── QUICK ACTIONS ── */
        .quick-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .5rem;
            padding: 1.25rem .5rem;
            background: #f8fafc;
            border: 1.5px dashed #cbd5e1;
            border-radius: 12px;
            color: var(--primary);
            text-decoration: none;
            font-size: .8rem;
            font-weight: 500;
            transition: all .2s ease;
        }

        .quick-btn:hover {
            background: var(--accent-soft);
            border-color: var(--accent);
            color: var(--primary-dark);
        }

        .quick-btn i {
            font-size: 1.4rem;
        }

        /* ── MOBILE TOGGLE ── */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: var(--primary);
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: block;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .4);
                z-index: 1049;
            }

            .sidebar-overlay.open {
                display: block;
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ══ SIDEBAR ══ -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">SD</div>
            <div class="brand-text">
                SDN Nusantara
                <small>Panel Admin</small>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">Utama</div>

            <a href="{{ url('admin/admin_dashboard') }}" class="sidebar-link active">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="#" class="sidebar-link">
                <i class="bi bi-newspaper"></i> Berita &amp; Pengumuman
            </a>
            <a href="#" class="sidebar-link">
                <i class="bi bi-images"></i> Galeri Foto
            </a>

            <div class="nav-label mt-2">Data Sekolah</div>

            <a href="#" class="sidebar-link">
                <i class="bi bi-people-fill"></i> Data Siswa
            </a>
            <a href="#" class="sidebar-link">
                <i class="bi bi-person-badge-fill"></i> Data Guru &amp; Staf
            </a>
            <a href="#" class="sidebar-link">
                <i class="bi bi-calendar-event-fill"></i> Kalender Akademik
            </a>
            <a href="#" class="sidebar-link">
                <i class="bi bi-mortarboard-fill"></i> PPDB
            </a>

            <div class="nav-label mt-2">Pengaturan</div>

            <a href="#" class="sidebar-link">
                <i class="bi bi-gear-fill"></i> Pengaturan Situs
            </a>
            <a href="#" class="sidebar-link">
                <i class="bi bi-person-circle"></i> Profil Admin
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ url('/') }}">
                <i class="bi bi-box-arrow-left"></i> Kembali ke Situs
            </a>
        </div>
    </aside>

    <!-- ══ MAIN WRAPPER ══ -->
    <div class="main-wrapper">

        <!-- Topbar -->
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-left">
                    <h5>Dashboard Admin</h5>
                    <p>Rabu, {{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <div class="topbar-right">
                <div class="position-relative">
                    <button class="btn btn-light btn-sm rounded-circle position-relative" title="Notifikasi">
                        <i class="bi bi-bell-fill text-secondary"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size:.55rem;">
                            3
                        </span>
                    </button>
                </div>
                <div class="topbar-avatar" title="Admin">A</div>
                <div class="d-none d-md-block">
                    <p class="mb-0 fw-600 text-dark" style="font-size:.82rem;font-weight:600;">Administrator</p>
                    <p class="mb-0 text-muted" style="font-size:.7rem;">admin@sdnnusantara.sch.id</p>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">

            <!-- Welcome Banner -->
            <div class="p-4 mb-4 rounded-4 text-white"
                style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--accent) 100%);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h4 class="fw-700 mb-1" style="font-weight:700;">Selamat Datang, Admin!</h4>
                        <p class="mb-0 opacity-75" style="font-size:.88rem;">
                            Kelola konten dan data SDN Nusantara dari panel ini.
                        </p>
                    </div>
                    <i class="bi bi-shield-fill-check" style="font-size:3rem; opacity:.3;"></i>
                </div>
            </div>

            <!-- ── Stat Cards ── -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $stats['siswa'] }}</div>
                            <div class="stat-label">Total Siswa</div>
                            <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i>12 tahun ini</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $stats['guru'] }}</div>
                            <div class="stat-label">Guru &amp; Staf</div>
                            <div class="stat-delta flat"><i class="bi bi-dash"></i>Tidak ada perubahan</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon yellow">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $stats['berita'] }}</div>
                            <div class="stat-label">Berita Publik</div>
                            <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i>3 bulan ini</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="stat-card">
                        <div class="stat-icon teal">
                            <i class="bi bi-megaphone-fill"></i>
                        </div>
                        <div>
                            <div class="stat-value">{{ $stats['pengumuman'] }}</div>
                            <div class="stat-label">Pengumuman Aktif</div>
                            <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i>1 baru hari ini</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Bottom Row: Activity + Quick Actions ── -->
            <div class="row g-3">

                <!-- Aktivitas Terbaru -->
                <div class="col-lg-8">
                    <div class="section-card h-100">
                        <div class="section-header">
                            <h6><i class="bi bi-clock-history me-2 text-primary"></i>Aktivitas Terbaru</h6>
                            <a href="#" class="btn btn-sm btn-outline-secondary" style="font-size:.75rem;">
                                Lihat Semua
                            </a>
                        </div>
                        <table class="table table-hover activity-table mb-0">
                            <thead>
                                <tr>
                                    <th>Aksi</th>
                                    <th class="d-none d-md-table-cell">Oleh</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aktivitas as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="ikon-activity bg-{{ $item['warna'] }} bg-opacity-10 text-{{ $item['warna'] }}">
                                                    <i class="bi bi-{{ $item['ikon'] }}"></i>
                                                </span>
                                                {{ $item['aksi'] }}
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell text-muted">{{ $item['oleh'] }}</td>
                                        <td class="text-muted">{{ $item['waktu'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Aksi Cepat -->
                <div class="col-lg-4">
                    <div class="section-card h-100">
                        <div class="section-header">
                            <h6><i class="bi bi-lightning-fill me-2 text-warning"></i>Aksi Cepat</h6>
                        </div>
                        <div class="p-3">
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="quick-btn">
                                        <i class="bi bi-plus-circle-fill"></i>
                                        Tambah Berita
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="quick-btn">
                                        <i class="bi bi-megaphone-fill"></i>
                                        Pengumuman
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="quick-btn">
                                        <i class="bi bi-image-fill"></i>
                                        Upload Foto
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="quick-btn">
                                        <i class="bi bi-person-plus-fill"></i>
                                        Tambah Guru
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="quick-btn">
                                        <i class="bi bi-calendar-plus-fill"></i>
                                        Event Baru
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="quick-btn">
                                        <i class="bi bi-download"></i>
                                        Export Data
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('open');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        }

        toggle.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
        overlay.addEventListener('click', closeSidebar);
    </script>
</body>

</html>
