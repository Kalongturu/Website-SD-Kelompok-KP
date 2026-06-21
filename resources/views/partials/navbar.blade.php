<nav class="navbar" id="navbar">
    {{-- this is navbar links for template this website --}}
    <div class="nav-container">
        <a href="#beranda" class="logo">
            <span class="logo-mark">SD</span>
            <span class="logo-text">SDN <strong>Dadapsari</strong></span>
        </a>

        <button class="nav-toggle" id="navToggle" aria-label="Buka menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

        <ul class="nav-links" id="navLinks">
            <li><a href="#beranda">Beranda</a></li>

            <li class="dropdown">
                <a href="#profil">Profil</a>
                <ul class="dropdown-menu">
                    <li><a href="#sejarah">Sejarah</a></li>
                    <li><a href="#visi-misi">Visi &amp; Misi</a></li>
                    <li><a href="#struktur">Struktur Organisasi</a></li>
                    <li><a href="{{ route('profil.fasilitas') }}">Fasilitas</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#akademik">Akademik</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('akademik.kurikulum') }}">Kurikulum</a></li>
                    <li><a href="{{ route('akademik.kalender') }}">Kalender Akademik</a></li>
                    <li><a href="#guru">Guru &amp; Staf</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#kesiswaan">Kesiswaan</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('kesiswaan.ekstrakurikuler') }}">Ekstrakurikuler</a></li>
                    <li><a href="{{ route('kesiswaan.prestasi') }}">Prestasi Siswa</a></li>
                    <li><a href="{{ route('kesiswaan.tata-tertib') }}">Tata Tertib</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#informasi">Informasi</a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('informasi.index') }}">Berita &amp; Pengumuman</a></li>
                    <li><a href="{{ route('ppdb.index') }}">PPDB</a></li>
                    <li><a href="#galeri">Galeri Foto</a></li>
                </ul>
            </li>

            <li><a href="#kontak">Kontak</a></li>
            <li class="nav-cta"><a href="{{ url('admin/login') }}" class="btn-ppdb">Login Admin</a></li>
        </ul>
    </div>
</nav>
