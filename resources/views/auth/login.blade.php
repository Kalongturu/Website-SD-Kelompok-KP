<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin — Program KP</title>
  <link rel="icon" href="{{ asset('favicon.ico') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Inter',system-ui,sans-serif;background:linear-gradient(135deg,#0f2c4c,#1e4976);min-height:100vh;display:grid;place-items:center;padding:20px;color:#1f2937}
    .login-card{background:#fff;width:100%;max-width:400px;border-radius:18px;padding:40px 34px;box-shadow:0 30px 60px rgba(0,0,0,.3)}
    .brand{display:flex;align-items:center;gap:12px;justify-content:center;margin-bottom:8px}
    .brand__mark{background:#0f2c4c;color:#fff;font-weight:800;font-family:'Plus Jakarta Sans',sans-serif;width:46px;height:46px;display:grid;place-items:center;border-radius:12px;font-size:1.1rem}
    h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:1.4rem;text-align:center;color:#0f2c4c;margin-bottom:4px}
    .sub{text-align:center;color:#6b7280;font-size:.9rem;margin-bottom:26px}
    label{display:block;font-weight:600;font-size:.88rem;margin-bottom:6px;color:#374151}
    input[type=email],input[type=password]{width:100%;padding:12px 14px;border:1.5px solid #d1d5db;border-radius:10px;font-size:.95rem;margin-bottom:16px;transition:border .2s}
    input:focus{outline:none;border-color:#0f2c4c}
    .btn{width:100%;background:#0f2c4c;color:#fff;border:none;padding:13px;border-radius:10px;font-size:1rem;font-weight:600;cursor:pointer;transition:background .2s}
    .btn:hover{background:#1e4976}
    .err{background:#fef2f2;border:1px solid #fca5a5;color:#b91c1c;padding:10px 14px;border-radius:9px;font-size:.88rem;margin-bottom:18px}
    .remember{display:flex;align-items:center;gap:8px;margin-bottom:18px;font-size:.88rem;color:#374151}
    .remember input{width:auto;margin:0}
    .back{display:block;text-align:center;margin-top:20px;font-size:.86rem;color:#6b7280;text-decoration:none}
    .back:hover{color:#0f2c4c}
  </style>
</head>
<body>
  <div class="login-card">
    <div class="brand"><span class="brand__mark">KP</span></div>
    <h1>Login Admin</h1>
    <p class="sub">Masuk untuk mengelola konten website</p>

    @if ($errors->any())
      <div class="err">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.proses') }}">
      @csrf
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@kp.test" required autofocus>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" placeholder="••••••••" required>

      <label class="remember"><input type="checkbox" name="ingat" value="1"> Ingat saya</label>

      <button type="submit" class="btn">Masuk</button>
    </form>

    <a class="back" href="{{ route('beranda') }}">← Kembali ke website</a>
  </div>
</body>
</html>
