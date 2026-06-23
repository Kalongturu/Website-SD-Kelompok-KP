@extends('admin.auth.layout')

@section('title', 'Lupa Password')

@section('card')
    <h2>Lupa Password?</h2>
    <p class="subtitle">Masukkan email Anda. Kami akan mengirim tautan untuk membuat password baru.</p>

    {{-- Pesan sukses (netral) setelah tautan dikirim --}}
    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center gap-2 mb-3" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    {{-- Pesan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert">
            <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email Terdaftar</label>
            <div class="input-icon-wrap">
                <i class="bi bi-envelope-fill field-icon"></i>
                <input type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="admin@sekolah.com" value="{{ old('email') }}" required autofocus>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-send-fill me-1"></i> Kirim Tautan Reset
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ route('admin.login') }}" class="extra-link">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke halaman login
        </a>
    </div>
@endsection
