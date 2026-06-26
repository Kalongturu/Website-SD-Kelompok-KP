<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin') — SDN Dadapsari</title>

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
            flex-shrink: 0;
        }

        .sidebar-brand .brand-icon {
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 10px;
            display: grid;
            place-items: center;
            padding: 4px;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
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
            padding: .75rem 0;
            flex: 1;
            overflow-y: auto;
            scrollbar-width: none;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .nav-divider {
            height: 1px;
            background: rgba(255, 255, 255, .08);
            margin: .4rem 1.25rem;
        }

        /* ── SIDEBAR LINKS ── */
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .6rem 1.5rem;
            color: rgba(255, 255, 255, .72);
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
            flex-shrink: 0;
        }

        /* ── SIDEBAR DROPDOWN ── */
        .sidebar-collapse-btn {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
            border-radius: 0;
        }

        .sidebar-arrow {
            font-size: .65rem;
            transition: transform .25s ease;
            margin-left: auto;
            flex-shrink: 0;
        }

        .sidebar-collapse-btn[aria-expanded="true"] .sidebar-arrow {
            transform: rotate(-180deg);
        }

        .sidebar-child {
            padding-left: 3.25rem;
            font-size: .82rem;
            border-left: 3px solid transparent;
        }

        .sidebar-child:hover {
            background: rgba(255, 255, 255, .06);
            border-left-color: rgba(87, 197, 182, .5);
            color: #fff;
        }

        .sidebar-child.active {
            background: rgba(255, 255, 255, .1);
            border-left-color: var(--accent);
            color: #fff;
        }

        /* ── SIDEBAR FOOTER ── */
        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, .1);
            flex-shrink: 0;
        }

        .sidebar-footer a,
        .sidebar-footer-btn {
            display: flex;
            align-items: center;
            gap: .6rem;
            color: rgba(255, 255, 255, .6);
            font-size: .8rem;
            text-decoration: none;
            transition: color .2s;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            width: 100%;
        }

        .sidebar-footer a:hover,
        .sidebar-footer-btn:hover {
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
            flex-shrink: 0;
        }

        .topbar-avatar-img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            border: 2px solid var(--accent-soft);
        }

        .profile-trigger {
            display: flex;
            align-items: center;
            gap: .6rem;
            background: none;
            border: none;
            padding: .25rem .4rem;
            border-radius: 10px;
            transition: background .2s ease;
        }

        .profile-trigger:hover {
            background: #f1f5f9;
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

        /* ── FORM CARDS (digunakan di semua halaman form CRUD) ── */
        .form-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .form-card-header {
            padding: .9rem 1.4rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .form-card-header h6 {
            margin: 0;
            font-size: .88rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .form-card-body {
            padding: 1.25rem 1.5rem;
        }

        .hico {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--accent-soft);
            display: grid;
            place-items: center;
            font-size: .85rem;
            flex-shrink: 0;
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

        @media (max-width: 767.98px) {
            .topbar {
                padding: 0 1rem;
                height: 56px;
            }

            .topbar-left h5 {
                font-size: .9rem;
            }

            .topbar-left p {
                display: none;
            }

            .page-content {
                padding: 1rem;
            }

            .stat-card {
                padding: 1rem;
                gap: .75rem;
            }

            .stat-icon {
                width: 44px;
                height: 44px;
                font-size: 1.1rem;
                border-radius: 11px;
                flex-shrink: 0;
            }

            .stat-value {
                font-size: 1.4rem;
            }

            .stat-label {
                font-size: .72rem;
            }

            .stat-delta {
                font-size: .68rem;
            }

            .section-header {
                padding: .85rem 1rem;
            }

            .activity-table td,
            .activity-table th {
                padding: .65rem 1rem;
            }
        }

        @media (max-width: 575.98px) {
            :root {
                --topbar-h: 56px;
            }

            .page-content {
                padding: .75rem;
            }

            .stat-card {
                padding: .85rem;
                gap: .6rem;
                border-radius: 12px;
            }

            .stat-icon {
                width: 38px;
                height: 38px;
                font-size: 1rem;
                border-radius: 9px;
            }

            .stat-value {
                font-size: 1.25rem;
            }

            .section-card {
                border-radius: 12px;
            }

            .quick-btn {
                padding: 1rem .25rem;
                font-size: .75rem;
                border-radius: 10px;
            }

            .quick-btn i {
                font-size: 1.2rem;
            }
        }
    </style>
    @yield('styles')
</head>

<body>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    @include('admin.partials.sidebar')

    <!-- ══ MAIN WRAPPER ══ -->
    <div class="main-wrapper">

        <!-- Topbar -->
        <header class="topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-left">
                    <h5>@yield('page-title', 'Panel Admin')</h5>
                    <p>{{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('admin.pesan.index') }}"
                   class="btn btn-light btn-sm rounded-circle position-relative" title="Pesan Masuk">
                    <i class="bi bi-bell-fill text-secondary"></i>
                    @if (($unreadPesan ?? 0) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size:.55rem;">{{ $unreadPesan > 99 ? '99+' : $unreadPesan }}</span>
                    @endif
                </a>
                @php($admin = auth()->user())
                <div class="dropdown">
                    <button class="profile-trigger" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if ($admin?->avatarUrl())
                            <img src="{{ $admin->avatarUrl() }}" alt="Avatar" class="topbar-avatar-img">
                        @else
                            <div class="topbar-avatar">{{ $admin?->initials() ?? 'A' }}</div>
                        @endif
                        <div class="d-none d-md-block text-start">
                            <p class="mb-0 fw-600 text-dark" style="font-size:.82rem;font-weight:600;">{{ $admin?->name ?? 'Administrator' }}</p>
                            <p class="mb-0 text-muted" style="font-size:.7rem;">{{ $admin?->email }}</p>
                        </div>
                        <i class="bi bi-chevron-down text-muted d-none d-md-block" style="font-size:.7rem;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="border-radius:12px;min-width:200px;">
                        <li class="px-3 py-2 d-md-none">
                            <p class="mb-0 fw-600 text-dark" style="font-size:.85rem;font-weight:600;">{{ $admin?->name ?? 'Administrator' }}</p>
                            <p class="mb-0 text-muted" style="font-size:.72rem;">{{ $admin?->email }}</p>
                        </li>
                        <li class="d-md-none"><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.profile.edit') }}" style="font-size:.85rem;">
                                <i class="bi bi-person-gear text-primary"></i> Edit Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button type="button" class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                data-bs-toggle="modal" data-bs-target="#modalKembali" style="font-size:.85rem;">
                                <i class="bi bi-box-arrow-left"></i> Keluar
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">
            @yield('content')
        </main>
    </div>

    <!-- Modal Konfirmasi Kembali ke Situs -->
    <div class="modal fade" id="modalKembali" tabindex="-1" aria-labelledby="modalKembaliLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 16px 48px rgba(0,0,0,.18);">
                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div
                            style="width:40px;height:40px;background:#fff3cd;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <i class="bi bi-box-arrow-left" style="color:#856404;font-size:1.2rem;"></i>
                        </div>
                        <h5 class="modal-title mb-0" id="modalKembaliLabel"
                            style="font-size:1rem;font-weight:600;color:#1e293b;">
                            Kembali ke Situs?
                        </h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="color:#64748b;font-size:.88rem;padding-top:.75rem;">
                    Anda akan keluar dari panel admin dan diarahkan ke halaman utama situs. Lanjutkan?
                </div>
                <div class="modal-footer border-0 pt-0 gap-2">
                    <button type="button" class="btn btn-light btn-sm px-4" data-bs-dismiss="modal"
                        style="border-radius:8px;font-size:.85rem;">Batal</button>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm px-4"
                            style="background:#1a5f7a;color:#fff;border-radius:8px;font-size:.85rem;">
                            <i class="bi bi-box-arrow-left me-1"></i> Ya, Kembali ke Situs
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Guard terhadap bfcache: jika halaman admin di-restore dari back/forward cache
        // (bukan fresh request), paksa reload agar server bisa cek auth.
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                window.location.reload();
            }
        });

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
    @yield('scripts')
</body>

</html>
