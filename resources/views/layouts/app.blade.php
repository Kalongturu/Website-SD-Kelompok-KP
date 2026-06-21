<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'Website resmi SDN Nusantara — informasi profil, akademik, kesiswaan, dan berita sekolah.')">
    <title>@yield('title', 'SDN Nusantara') — Website Sekolah</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

<body>
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