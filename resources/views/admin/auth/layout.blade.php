<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <title>@yield('title', 'Admin') — SDN Dadapsari</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1a5f7a;
            --primary-dark: #002b5b;
            --accent: #57c5b6;
            --accent-soft: #e6f7f4;
        }
        * { font-family: 'Poppins', sans-serif; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--accent) 100%);
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem; position: relative;
        }
        .login-wrapper { width: 100%; max-width: 440px; }
        .login-brand { text-align: center; margin-bottom: 2rem; }
        .brand-badge {
            display: inline-grid; place-items: center; width: 68px; height: 68px;
            background: #fff; border-radius: 20px; padding: 8px;
            margin-bottom: .75rem; box-shadow: 0 8px 24px rgba(0, 43, 91, .25);
        }
        .brand-badge img { width: 100%; height: 100%; object-fit: contain; }
        .login-brand h1 { color: #fff; font-size: 1.35rem; font-weight: 700; margin-bottom: .2rem; }
        .login-brand p { color: rgba(255, 255, 255, .65); font-size: .82rem; margin: 0; }
        .login-card { background: #fff; border-radius: 20px; padding: 2.25rem 2rem; box-shadow: 0 24px 60px rgba(0, 43, 91, .25); }
        .login-card h2 { font-size: 1.1rem; font-weight: 600; color: var(--primary-dark); margin-bottom: .25rem; }
        .login-card .subtitle { font-size: .8rem; color: #94a3b8; margin-bottom: 1.75rem; }
        .form-label { font-size: .82rem; font-weight: 500; color: #374151; margin-bottom: .4rem; }
        .input-icon-wrap { position: relative; }
        .input-icon-wrap .field-icon {
            position: absolute; left: .9rem; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 1rem; pointer-events: none;
        }
        .input-icon-wrap .form-control {
            padding-left: 2.6rem; border-radius: 10px; border: 1.5px solid #e2e8f0;
            font-size: .88rem; height: 46px; transition: border-color .2s, box-shadow .2s;
        }
        .input-icon-wrap .form-control:focus {
            border-color: var(--accent); box-shadow: 0 0 0 3px rgba(87, 197, 182, .18);
        }
        .toggle-pass {
            position: absolute; right: .9rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; padding: 0; color: #94a3b8; font-size: 1rem; cursor: pointer; transition: color .2s;
        }
        .toggle-pass:hover { color: var(--primary); }
        .btn-login {
            width: 100%; height: 48px; background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border: none; border-radius: 12px; color: #fff; font-size: .92rem; font-weight: 600;
            letter-spacing: .3px; transition: opacity .2s, transform .15s;
        }
        .btn-login:hover { opacity: .9; transform: translateY(-1px); }
        .btn-login:active { transform: translateY(0); }
        .back-btn {
            position: absolute; top: 1.25rem; left: 1.25rem; display: inline-flex; align-items: center; gap: .45rem;
            padding: .5rem 1rem; background: rgba(255, 255, 255, .15); backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, .25); border-radius: 50px; color: #fff; font-size: .82rem;
            font-weight: 500; text-decoration: none; transition: background .2s, border-color .2s; z-index: 100;
        }
        .back-btn:hover { background: rgba(255, 255, 255, .28); border-color: rgba(255, 255, 255, .45); color: #fff; }
        .alert { border-radius: 10px; font-size: .82rem; }
        .extra-link { font-size: .82rem; color: var(--primary); text-decoration: none; font-weight: 500; }
        .extra-link:hover { text-decoration: underline; }
        @media (max-width: 480px) {
            body { padding: 1rem; align-items: flex-start; padding-top: 5.5rem; }
            .login-card { padding: 1.75rem 1.25rem; border-radius: 16px; }
        }
    </style>
</head>

<body>

    <a href="{{ route('admin.login') }}" class="back-btn">
        <i class="bi bi-arrow-left"></i> Kembali ke Login
    </a>

    <div class="login-wrapper">
        <div class="login-brand">
            <div class="brand-badge"><img src="{{ asset('images/logo-sdn-dadapsari.png') }}" alt="Logo SDN Dadapsari"></div>
            <h1>SDN Dadapsari</h1>
            <p>Panel Administrasi Sekolah</p>
        </div>

        <div class="login-card">
            @yield('card')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
