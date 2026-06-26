<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Website resmi SDN Dadapsari — informasi profil, akademik, kesiswaan, dan berita sekolah.')">
    <title>@yield('title', 'SDN Dadapsari') — Website Sekolah</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

<body>

    {{-- Admin notice bar: ditampilkan saat admin masih login dan mengunjungi situs publik --}}
    @auth
    <div id="admin-bar" style="
        position: fixed; top: 0; left: 0; right: 0; z-index: 9999;
        background: #002b5b;
        color: #fff;
        display: flex; align-items: center; justify-content: space-between;
        padding: .45rem 1.25rem;
        font-size: .78rem;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 2px 8px rgba(0,0,0,.3);
        gap: 1rem;
    ">
        <span style="display:flex;align-items:center;gap:.5rem;opacity:.85;">
            <span style="font-size:.95rem;">🔒</span>
            Anda masih login sebagai <strong style="color:#57c5b6;">Admin</strong>.
            Gunakan tombol berikut untuk kembali ke panel atau logout.
        </span>
        <div style="display:flex;align-items:center;gap:.5rem;flex-shrink:0;">
            <a href="{{ route('admin.dashboard') }}"
               style="background:#57c5b6;color:#002b5b;font-weight:700;font-size:.75rem;
                      padding:.3rem .85rem;border-radius:50px;text-decoration:none;
                      display:inline-flex;align-items:center;gap:.35rem;">
                ← Dashboard
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
                @csrf
                <button type="submit"
                    style="background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);
                           color:#fff;font-size:.75rem;font-weight:600;
                           padding:.3rem .85rem;border-radius:50px;cursor:pointer;
                           font-family:inherit;display:inline-flex;align-items:center;gap:.35rem;">
                    Logout
                </button>
            </form>
        </div>
    </div>
    <div style="height: 34px;"></div>{{-- spacer agar konten tidak tertimpa bar --}}
    @endauth

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <a href="#beranda" class="back-to-top" aria-label="Kembali ke atas">↑</a>

    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>