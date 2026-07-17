<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Login Admin — SDN Dadapsari</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Selaras dengan palet oranye di public/css/style.css */
            --primary: #a85400;
            --primary-bright: #f48000;
            --primary-ink: #8f4700;
            --primary-dark: #282828;
            --accent: #ff910b;
            --accent-soft: #fff2e2;
            --highlight: #ffd08a;
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
            position: relative;
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
            background: #fff;
            border-radius: 20px;
            padding: 8px;
            margin-bottom: .75rem;
            box-shadow: 0 8px 24px rgba(40, 40, 40, .25);
        }

        .brand-badge img {
            width: 100%;
            height: 100%;
            object-fit: contain;
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
            box-shadow: 0 24px 60px rgba(40, 40, 40, .25);
        }

        .login-card h2 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: .25rem;
        }

        .login-card .subtitle {
            font-size: .8rem;
            color: #756d66;
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
            color: #756d66;
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
            box-shadow: 0 0 0 3px rgba(255, 145, 11, .18);
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
            color: #756d66;
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

        /* ── Back button (top-left) ── */
        .back-btn {
            position: absolute;
            top: 1.25rem;
            left: 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .5rem 1rem;
            background: rgba(255, 255, 255, .15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 50px;
            color: #fff;
            font-size: .82rem;
            font-weight: 500;
            text-decoration: none;
            transition: background .2s, border-color .2s;
            z-index: 100;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, .28);
            border-color: rgba(255, 255, 255, .45);
            color: #fff;
        }

        .back-btn i {
            font-size: .9rem;
        }

        /* ── Alert ── */
        .alert {
            border-radius: 10px;
            font-size: .82rem;
        }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            body {
                padding: 1rem;
                align-items: flex-start;
                padding-top: 5.5rem;
            }

            .login-wrapper {
                max-width: 100%;
            }

            .back-btn {
                top: .85rem;
                left: .85rem;
                padding: .4rem .85rem;
                font-size: .78rem;
            }

            .brand-badge {
                width: 56px;
                height: 56px;
                font-size: 1.3rem;
                border-radius: 16px;
            }

            .login-brand h1 {
                font-size: 1.15rem;
            }

            .login-brand {
                margin-bottom: 1.5rem;
            }

            .login-card {
                padding: 1.75rem 1.25rem;
                border-radius: 16px;
            }

            .input-icon-wrap .form-control {
                height: 44px;
                font-size: .85rem;
            }

            .btn-login {
                height: 46px;
                font-size: .88rem;
            }
        }

        @media (max-width: 360px) {
            .login-brand h1 {
                font-size: 1rem;
            }

            .login-card h2 {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Back button — top left -->
    <a href="{{ url('/') }}" class="back-btn">
        <i class="bi bi-arrow-left"></i> Kembali ke Situs
    </a>

    <div class="login-wrapper">

        <!-- Branding -->
        <div class="login-brand">
            <div class="brand-badge"><img src="{{ asset('images/logo-sdn-dadapsari.png') }}" alt="Logo SDN Dadapsari"></div>
            <h1>SDN Dadapsari</h1>
            <p>Panel Administrasi Sekolah</p>
        </div>

        <!-- Card -->
        <div class="login-card">
            <h2>Masuk sebagai Admin</h2>
            <p class="subtitle">Masukkan kredensial Anda untuk melanjutkan</p>

            {{-- Alert sukses (mis. setelah reset password berhasil) --}}
            @if (session('status'))
                <div class="alert alert-success d-flex align-items-center gap-2 mb-3" role="alert">
                    <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

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

            <form method="POST" action="{{ url('admin/login') }}" id="loginForm">
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
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                </div>

                <button type="submit" class="btn-login" id="loginSubmit">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                </button>
            </form>
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

        // Kunci tombol setelah submit pertama. Submit kedua memakai token dari sesi
        // yang sudah diregenerasi oleh submit pertama, dan itulah yang memicu 419.
        const loginForm = document.getElementById('loginForm');
        const loginSubmit = document.getElementById('loginSubmit');
        loginForm.addEventListener('submit', function () {
            if (loginForm.dataset.submitting === '1') return;
            loginForm.dataset.submitting = '1';
            // Jangan pakai `disabled` sebelum submit terkirim — tombol yang
            // disabled tidak ikut dikirim; tunda ke tick berikutnya.
            setTimeout(function () {
                loginSubmit.disabled = true;
                loginSubmit.style.opacity = '.75';
                loginSubmit.style.cursor = 'wait';
                loginSubmit.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Memproses…';
            }, 0);
        });
    </script>
</body>

</html>
