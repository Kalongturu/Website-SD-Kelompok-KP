<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">SD</div>
        <div class="brand-text">
            SDN Dadapsari
            <small>Panel Admin</small>
        </div>
    </div>

    <nav class="sidebar-nav">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <div class="nav-divider"></div>

        {{-- Semua grup collapse dibungkus satu parent agar accordion bekerja --}}
        <div id="sidebarAccordion">

            {{-- Profil --}}
            @php
                $profilOpen = request()->routeIs(
                    'admin.profil-setting.*',
                    'admin.sarpras.*',
                    'admin.ruang-kelas.*',
                    'admin.ebook.*',
                    'admin.video.*',
                );
            @endphp
            <button class="sidebar-link sidebar-collapse-btn" type="button" data-bs-toggle="collapse"
                data-bs-target="#navProfil" aria-expanded="{{ $profilOpen ? 'true' : 'false' }}">
                <i class="bi bi-building-fill"></i>
                <span>Profil</span>
                <i class="bi bi-chevron-down sidebar-arrow ms-auto"></i>
            </button>
            <div class="collapse {{ $profilOpen ? 'show' : '' }}" id="navProfil" data-bs-parent="#sidebarAccordion">
                <a href="{{ route('admin.profil-setting.edit') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.profil-setting.*') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i> Sejarah / Visi / Dana BOS
                </a>
                <a href="{{ route('admin.sarpras.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.sarpras.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Sarana &amp; Prasarana
                </a>
                <a href="{{ route('admin.ruang-kelas.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.ruang-kelas.*') ? 'active' : '' }}">
                    <i class="bi bi-door-closed-fill"></i> Ruang Kelas
                </a>
                <a href="{{ route('admin.ebook.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.ebook.*') ? 'active' : '' }}">
                    <i class="bi bi-book-fill"></i> E-Book
                </a>
                <a href="{{ route('admin.video.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.video.*') ? 'active' : '' }}">
                    <i class="bi bi-play-circle-fill"></i> Video Pembelajaran
                </a>
            </div>

            {{-- Akademik --}}
            @php $akademikOpen = false; @endphp
            <button class="sidebar-link sidebar-collapse-btn" type="button" data-bs-toggle="collapse"
                data-bs-target="#navAkademik" aria-expanded="{{ $akademikOpen ? 'true' : 'false' }}">
                <i class="bi bi-mortarboard-fill"></i>
                <span>Akademik</span>
                <i class="bi bi-chevron-down sidebar-arrow ms-auto"></i>
            </button>
            <div class="collapse {{ $akademikOpen ? 'show' : '' }}" id="navAkademik"
                data-bs-parent="#sidebarAccordion">
                <a href="#" class="sidebar-link sidebar-child"><i class="bi bi-journal-text"></i> Kurikulum</a>
                <a href="#" class="sidebar-link sidebar-child"><i class="bi bi-calendar-event-fill"></i> Kalender
                    Akademik</a>
                <a href="#" class="sidebar-link sidebar-child"><i class="bi bi-person-badge-fill"></i> Guru &amp;
                    Staf</a>
            </div>

            {{-- Kesiswaan --}}
            @php
                $kesiswaanOpen = request()->routeIs('admin.ekskul.*', 'admin.prestasi.*', 'admin.tata-tertib.*');
            @endphp
            <button class="sidebar-link sidebar-collapse-btn" type="button" data-bs-toggle="collapse"
                data-bs-target="#navKesiswaan" aria-expanded="{{ $kesiswaanOpen ? 'true' : 'false' }}">
                <i class="bi bi-people-fill"></i>
                <span>Kesiswaan</span>
                <i class="bi bi-chevron-down sidebar-arrow ms-auto"></i>
            </button>
            <div class="collapse {{ $kesiswaanOpen ? 'show' : '' }}" id="navKesiswaan"
                data-bs-parent="#sidebarAccordion">
                <a href="{{ route('admin.ekskul.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.ekskul.*') ? 'active' : '' }}">
                    <i class="bi bi-trophy-fill"></i> Ekstrakurikuler
                </a>
                <a href="{{ route('admin.prestasi.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}">
                    <i class="bi bi-award-fill"></i> Prestasi Siswa
                </a>
                <a href="{{ route('admin.tata-tertib.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.tata-tertib.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard2-check-fill"></i> Tata Tertib
                </a>
            </div>

            {{-- Informasi --}}
            @php
                $informasiOpen = request()->routeIs(
                    'admin.berita.*',
                    'admin.pengumuman.*',
                    'admin.galeri.*',
                    'admin.ppdb.*',
                );
            @endphp
            <button class="sidebar-link sidebar-collapse-btn" type="button" data-bs-toggle="collapse"
                data-bs-target="#navInformasi" aria-expanded="{{ $informasiOpen ? 'true' : 'false' }}">
                <i class="bi bi-info-circle-fill"></i>
                <span>Informasi</span>
                <i class="bi bi-chevron-down sidebar-arrow ms-auto"></i>
            </button>
            <div class="collapse {{ $informasiOpen ? 'show' : '' }}" id="navInformasi"
                data-bs-parent="#sidebarAccordion">
                <a href="{{ route('admin.berita.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                    <i class="bi bi-newspaper"></i> Berita
                </a>
                <a href="{{ route('admin.pengumuman.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                    <i class="bi bi-megaphone-fill"></i> Pengumuman
                </a>
                <a href="{{ route('admin.galeri.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                    <i class="bi bi-images"></i> Galeri Foto
                </a>
                <a href="{{ route('admin.ppdb.index') }}"
                    class="sidebar-link sidebar-child {{ request()->routeIs('admin.ppdb.*') ? 'active' : '' }}">
                    <i class="bi bi-person-plus-fill"></i> PPDB
                </a>
            </div>

        </div>{{-- end #sidebarAccordion --}}

        <div class="nav-divider"></div>

        {{-- Kontak & Footer --}}
        <a href="{{ route('admin.kontak') }}"
            class="sidebar-link {{ request()->routeIs('admin.kontak') ? 'active' : '' }}">
            <i class="bi bi-telephone-fill"></i>
            <span>Kontak</span>
        </a>

    </nav>

    <div class="sidebar-footer">
        <button type="button" class="sidebar-footer-btn" data-bs-toggle="modal" data-bs-target="#modalKembali">
            <i class="bi bi-box-arrow-left"></i> Kembali ke Situs
        </button>
    </div>
</aside>
