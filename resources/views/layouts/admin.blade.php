<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Panel Admin') — Program KP</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Inter',system-ui,sans-serif;background:#f1f5f9;color:#1f2937}
    a{color:inherit;text-decoration:none}
    .layout{display:flex;min-height:100vh}
    /* Sidebar */
    .sidebar{width:248px;background:#0f2c4c;color:#cbd5e1;display:flex;flex-direction:column;position:fixed;inset:0 auto 0 0;height:100vh}
    .sidebar__brand{display:flex;align-items:center;gap:10px;padding:20px 22px;border-bottom:1px solid rgba(255,255,255,.1)}
    .sidebar__brand .mark{background:#f0b429;color:#0f2c4c;font-weight:800;font-family:'Plus Jakarta Sans',sans-serif;width:38px;height:38px;display:grid;place-items:center;border-radius:10px}
    .sidebar__brand b{color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:1.05rem}
    .sidebar__brand small{display:block;color:#94a3b8;font-size:.72rem;font-weight:400}
    .menu{padding:14px 12px;display:grid;gap:4px;flex:1}
    .menu a{display:flex;align-items:center;gap:11px;padding:11px 14px;border-radius:9px;font-size:.93rem;font-weight:500;transition:background .15s}
    .menu a:hover{background:rgba(255,255,255,.07);color:#fff}
    .menu a.active{background:#f0b429;color:#0f2c4c;font-weight:600}
    .menu .ico{font-size:1.05rem;width:20px;text-align:center}
    .menu .badge{margin-left:auto;background:#ef4444;color:#fff;font-size:.7rem;font-weight:700;padding:1px 7px;border-radius:99px}
    .sidebar__foot{padding:14px;border-top:1px solid rgba(255,255,255,.1)}
    .sidebar__foot form{margin:0}
    .btn-logout{width:100%;background:rgba(255,255,255,.08);color:#fca5a5;border:none;padding:10px;border-radius:9px;cursor:pointer;font-size:.9rem;font-weight:600;font-family:inherit}
    .btn-logout:hover{background:rgba(239,68,68,.2)}
    /* Main */
    .main{margin-left:248px;flex:1;display:flex;flex-direction:column;width:calc(100% - 248px)}
    .topbar{background:#fff;padding:16px 28px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #e2e8f0;position:sticky;top:0;z-index:10}
    .topbar h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.25rem;color:#0f2c4c}
    .topbar .user{font-size:.88rem;color:#64748b}
    .content{padding:28px;flex:1}
    .view-site{font-size:.85rem;color:#0f2c4c;font-weight:600}
    /* Reusable */
    .alert{background:#dcfce7;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:20px}
    .card-box{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:22px}
    .btn{display:inline-flex;align-items:center;gap:7px;background:#0f2c4c;color:#fff;border:none;padding:10px 18px;border-radius:9px;font-size:.9rem;font-weight:600;cursor:pointer;font-family:inherit;text-decoration:none}
    .btn:hover{background:#1e4976}
    .btn--gold{background:#f0b429;color:#0f2c4c}
    .btn--gold:hover{background:#d99e1a}
    .btn--sm{padding:6px 12px;font-size:.82rem}
    .btn--danger{background:#fee2e2;color:#b91c1c}
    .btn--danger:hover{background:#fecaca}
    .btn--ghost{background:#f1f5f9;color:#334155}
    .btn--ghost:hover{background:#e2e8f0}
    table{width:100%;border-collapse:collapse;background:#fff}
    table th,table td{text-align:left;padding:12px 14px;border-bottom:1px solid #e2e8f0;font-size:.9rem}
    table th{background:#f8fafc;font-weight:600;color:#475569;font-size:.8rem;text-transform:uppercase;letter-spacing:.03em}
    .field{margin-bottom:18px}
    .field label{display:block;font-weight:600;font-size:.88rem;margin-bottom:7px;color:#374151}
    .field input,.field textarea{width:100%;padding:11px 14px;border:1.5px solid #d1d5db;border-radius:9px;font-size:.94rem;font-family:inherit}
    .field input:focus,.field textarea:focus{outline:none;border-color:#0f2c4c}
    .field textarea{min-height:120px;resize:vertical}
    .field .err{color:#dc2626;font-size:.82rem;margin-top:5px;display:block}
    .stat-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:18px;margin-bottom:28px}
    .stat-box{background:#fff;border:1px solid #e2e8f0;border-radius:14px;padding:20px 22px}
    .stat-box .num{font-family:'Plus Jakarta Sans',sans-serif;font-size:2rem;font-weight:800;color:#0f2c4c}
    .stat-box .lbl{color:#64748b;font-size:.88rem;margin-top:2px}
    .page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;gap:12px;flex-wrap:wrap}
    .thumb{width:64px;height:48px;object-fit:cover;border-radius:7px;border:1px solid #e2e8f0}
    .pill{display:inline-block;padding:2px 10px;border-radius:99px;font-size:.76rem;font-weight:600}
    .pill--baru{background:#fee2e2;color:#b91c1c}
    .pill--dibaca{background:#e2e8f0;color:#475569}
    .pagination{display:flex;gap:6px;list-style:none;margin-top:20px;flex-wrap:wrap}
    .pagination a,.pagination span{padding:7px 12px;border-radius:8px;background:#fff;border:1px solid #e2e8f0;font-size:.85rem;color:#334155}
    .pagination .active span{background:#0f2c4c;color:#fff;border-color:#0f2c4c}
    .empty{text-align:center;color:#94a3b8;padding:40px}
    @media(max-width:820px){
      .sidebar{width:64px}
      .sidebar__brand b,.sidebar__brand small,.menu a span:not(.ico):not(.badge),.btn-logout{display:none}
      .main{margin-left:64px;width:calc(100% - 64px)}
    }
  </style>
</head>
<body>
  <div class="layout">
    <aside class="sidebar">
      <div class="sidebar__brand">
        <span class="mark">KP</span>
        <div><b>Admin KP</b><small>Panel Pengelola</small></div>
      </div>
      <nav class="menu">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><span class="ico">🏠</span><span>Dashboard</span></a>
        <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}"><span class="ico">🖼️</span><span>Galeri</span></a>
        <a href="{{ route('admin.mahasiswa.index') }}" class="{{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}"><span class="ico">🎓</span><span>Mahasiswa</span></a>
        <a href="{{ route('admin.konten.index') }}" class="{{ request()->routeIs('admin.konten.*') ? 'active' : '' }}"><span class="ico">📝</span><span>Konten Halaman</span></a>
        <a href="{{ route('admin.pesan.index') }}" class="{{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">
          <span class="ico">✉️</span><span>Pesan Masuk</span>
          @php $pesanBaru = \App\Models\PesanKontak::where('dibaca', false)->count(); @endphp
          @if($pesanBaru)<span class="badge">{{ $pesanBaru }}</span>@endif
        </a>
      </nav>
      <div class="sidebar__foot">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-logout">⎋ Keluar</button>
        </form>
      </div>
    </aside>

    <div class="main">
      <div class="topbar">
        <h1>@yield('title', 'Dashboard')</h1>
        <div>
          <a href="{{ route('beranda') }}" target="_blank" class="view-site">Lihat Website ↗</a>
          <span class="user">&nbsp;•&nbsp; {{ auth()->user()->name }}</span>
        </div>
      </div>
      <div class="content">
        @if (session('sukses'))
          <div class="alert">{{ session('sukses') }}</div>
        @endif
        @yield('content')
      </div>
    </div>
  </div>
</body>
</html>
