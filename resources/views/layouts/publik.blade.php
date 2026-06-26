<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Program Kerja Praktik (KP)')</title>
  <meta name="description" content="@yield('description', 'Program Kerja Praktik (KP) memberikan pengalaman kerja nyata di dunia industri untuk meningkatkan kompetensi mahasiswa.')">
  <meta name="theme-color" content="#0f2c4c">
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <a class="skip-link" href="#main">Lewati ke konten utama</a>

  <header class="site-header">
    <div class="container nav">
      <a class="brand" href="{{ route('beranda') }}" aria-label="Program KP — Beranda">
        <span class="brand__mark" aria-hidden="true">KP</span>
        <span class="brand__name">Program KP<small>Kerja Praktik</small></span>
      </a>
      <button class="nav-toggle" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="navmenu">
        <span></span><span></span><span></span>
      </button>
      <nav aria-label="Navigasi utama">
        <ul class="nav-menu" id="navmenu">
          <li><a href="{{ route('beranda') }}" @if(request()->routeIs('beranda')) aria-current="page" @endif>Beranda</a></li>
          <li class="nav-has-drop">
            <a href="{{ route('profil') }}">Profil</a>
            <button class="drop-toggle" aria-expanded="false" aria-label="Buka menu Profil">
              <span class="drop-arrow" aria-hidden="true">▾</span>
            </button>
            <ul class="nav-dropdown" role="menu">
              <li><a href="{{ route('profil') }}#sejarah" role="menuitem">Sejarah</a></li>
              <li><a href="{{ route('profil') }}#visi-misi" role="menuitem">Visi &amp; Misi</a></li>
              <li><a href="{{ route('profil') }}#fasilitas" role="menuitem">Fasilitas</a></li>
              <li><a href="{{ route('profil') }}#struktur-organisasi" role="menuitem">Struktur Organisasi</a></li>
            </ul>
          </li>
          <li><a href="{{ route('mahasiswa') }}" @if(request()->routeIs('mahasiswa')) aria-current="page" @endif>Mahasiswa</a></li>
          <li><a href="{{ route('galeri') }}" @if(request()->routeIs('galeri')) aria-current="page" @endif>Galeri</a></li>
          <li class="nav-cta"><a href="{{ route('kontak') }}">Hubungi Kami</a></li>
          @auth
            <li><a href="{{ route('admin.dashboard') }}">🔧 Dashboard</a></li>
          @else
            <li><a href="{{ route('login') }}">🔒 Login Admin</a></li>
          @endauth
        </ul>
      </nav>
    </div>
  </header>

  <main id="main">
    @yield('content')
  </main>

  <footer class="site-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <a class="brand" href="{{ route('beranda') }}" aria-label="Program KP — Beranda">
            <span class="brand__mark" aria-hidden="true">KP</span>
            <span class="brand__name">Program KP<small>Kerja Praktik</small></span>
          </a>
          <p>Membangun pengalaman kerja nyata dan kompetensi profesional mahasiswa melalui kemitraan dengan dunia industri.</p>
        </div>
        <div class="footer-col">
          <h4>Navigasi</h4>
          <ul>
            <li><a href="{{ route('beranda') }}">Beranda</a></li>
            <li><a href="{{ route('profil') }}">Profil</a></li>
            <li><a href="{{ route('mahasiswa') }}">Mahasiswa</a></li>
            <li><a href="{{ route('galeri') }}">Galeri</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Profil</h4>
          <ul>
            <li><a href="{{ route('profil') }}#sejarah">Sejarah</a></li>
            <li><a href="{{ route('profil') }}#visi-misi">Visi &amp; Misi</a></li>
            <li><a href="{{ route('profil') }}#fasilitas">Fasilitas</a></li>
            <li><a href="{{ route('profil') }}#struktur-organisasi">Struktur Organisasi</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Kontak</h4>
          <ul>
            <li>Universitas Diponegoro</li>
            <li>Jl. Pendidikan No. 123</li>
            <li><a href="mailto:kp@universitas.ac.id">kp@universitas.ac.id</a></li>
            <li><a href="tel:+6282155325944">+62 821-5532-5944</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Program KP. Hak cipta dilindungi.</p>
        <div class="socials" aria-label="Media sosial">
          <a href="#" aria-label="Instagram">◎</a>
          <a href="#" aria-label="LinkedIn">in</a>
          <a href="#" aria-label="YouTube">▷</a>
        </div>
      </div>
    </div>
  </footer>

  <button class="to-top" aria-label="Kembali ke atas">↑</button>
  <script src="{{ asset('js/main.js') }}" defer></script>
</body>
</html>
