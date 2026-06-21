<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — SDN Dadapsari</title>

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

        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
        }

        /* ── Branding ── */
        .login-brand {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-badge {
            display: inline-grid;
            place-items: center;
            width: 68px;
            height: 68px;
            background: var(--accent);
            border-radius: 20px;
            font-size: 1.6rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: .75rem;
            box-shadow: 0 8px 24px rgba(87, 197, 182, .4);
        }

        .login-brand h1 {
            color: #fff;
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: .2rem;
        }

        .login-brand p {
            color: rgba(255, 255, 255, .65);
            font-size: .82rem;
            margin: 0;
        }

        /* ── Card ── */
        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.25rem 2rem;
            box-shadow: 0 24px 60px rgba(0, 43, 91, .25);
        }

        .login-card h2 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: .25rem;
        }

        .login-card .subtitle {
            font-size: .8rem;
            color: #94a3b8;
            margin-bottom: 1.75rem;
        }

        /* ── Input group ── */
        .form-label {
            font-size: .82rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: .4rem;
        }

        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap .field-icon {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
            pointer-events: none;
        }

        .input-icon-wrap .form-control {
            padding-left: 2.6rem;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            font-size: .88rem;
            height: 46px;
            transition: border-color .2s, box-shadow .2s;
        }

        .input-icon-wrap .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(87, 197, 182, .18);
        }

        /* toggle password */
        .toggle-pass {
            position: absolute;
            right: .9rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0;
            color: #94a3b8;
            font-size: 1rem;
            cursor: pointer;
            transition: color .2s;
        }

        .toggle-pass:hover {
            color: var(--primary);
        }

        /* ── Remember + Forgot ── */
        .row-extras {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .form-check-label {
            font-size: .8rem;
            color: #64748b;
        }

        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .forgot-link {
            font-size: .8rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        /* ── Submit button ── */
        .btn-login {
            width: 100%;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: .92rem;
            font-weight: 600;
            letter-spacing: .3px;
            transition: opacity .2s, transform .15s;
        }

        .btn-login:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ── Back link ── */
        .back-home {
            text-align: center;
            margin-top: 1.4rem;
        }

        .back-home a {
            font-size: .8rem;
            color: rgba(255, 255, 255, .75);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            transition: color .2s;
        }

        .back-home a:hover {
            color: #fff;
        }

        /* ── Alert ── */
        .alert {
            border-radius: 10px;
            font-size: .82rem;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- Branding -->
        <div class="login-brand">
            <div class="brand-badge">SD</div>
            <h1>SDN Dadapsari</h1>
            <p>Panel Administrasi Sekolah</p>
        </div>

        <!-- Card -->
        <div class="login-card">
            <h2>Masuk sebagai Admin</h2>
            <p class="subtitle">Masukkan kredensial Anda untuk melanjutkan</p>

            {{-- Alert error --}}
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ url('admin/login') }}">
                @csrf

                {{-- Email / Username --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email atau Username</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person-fill field-icon"></i>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" placeholder="admin@sekolah.com"
                            value="{{ old('email') }}" autocomplete="email" required autofocus>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-lock-fill field-icon"></i>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                            autocomplete="current-password" required>
                        <button type="button" class="toggle-pass" id="togglePass" aria-label="Tampilkan password">
                            <i class="bi bi-eye-fill" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="row-extras">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <a href="#" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </button>
            </form>
        </div>

        <!-- Back to site -->
        <div class="back-home">
            <a href="{{ url('/') }}">
                <i class="bi bi-arrow-left"></i> Kembali ke Halaman Utama
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePass = document.getElementById('togglePass');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePass.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            toggleIcon.className = isHidden ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
        });
    </script>
</body>

</html>
