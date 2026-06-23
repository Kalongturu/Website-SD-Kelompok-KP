@extends('admin.auth.layout')

@section('title', 'Reset Password')

@section('card')
    <h2>Buat Password Baru</h2>
    <p class="subtitle">Masukkan password baru untuk akun <strong>{{ $email }}</strong>.</p>

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
            <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        {{-- Token & email dibawa diam-diam; keduanya diverifikasi server. --}}
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <div class="input-icon-wrap">
                <i class="bi bi-lock-fill field-icon"></i>
                <input type="password" id="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Minimal 8 karakter" autocomplete="new-password" required autofocus>
                <button type="button" class="toggle-pass" data-target="password" aria-label="Tampilkan password">
                    <i class="bi bi-eye-fill"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Ulangi Password Baru</label>
            <div class="input-icon-wrap">
                <i class="bi bi-shield-lock-fill field-icon"></i>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="form-control" placeholder="Ketik ulang password" autocomplete="new-password" required>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-check2-circle me-1"></i> Simpan Password Baru
        </button>
    </form>
@endsection

@section('scripts')
<script>
    // Tombol mata: tampilkan/sembunyikan password.
    document.querySelectorAll('.toggle-pass').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById(btn.dataset.target);
            const icon = btn.querySelector('i');
            const hidden = input.type === 'password';
            input.type = hidden ? 'text' : 'password';
            icon.className = hidden ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
        });
    });
</script>
@endsection
