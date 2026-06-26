@extends('layouts.publik')

@section('title', 'Hubungi Kami — Program KP')

@section('content')
  <section class="page-hero" aria-labelledby="kt-title">
    <div class="container">
      <span class="hero__badge">Kontak</span>
      <h1 id="kt-title">Hubungi Kami</h1>
      <p>Punya pertanyaan tentang Program Kerja Praktik? Kirimkan pesan melalui formulir di bawah ini dan tim kami akan menghubungi Anda.</p>
    </div>
  </section>

  <section class="section section--tint" aria-labelledby="form-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">Sampaikan Pesan</span>
        <h2 id="form-title">Kirim Pertanyaan</h2>
        <p>Kami siap membantu memberikan informasi seputar pendaftaran dan pelaksanaan KP.</p>
      </div>

      <div class="contact-grid">
        <div class="contact-info" data-reveal>
          <div class="contact-item">
            <span class="ico" aria-hidden="true">📍</span>
            <div><strong>Alamat</strong><p>Universitas Diponegoro, Jl. Pendidikan No. 123, Semarang</p></div>
          </div>
          <div class="contact-item">
            <span class="ico" aria-hidden="true">✉️</span>
            <div><strong>Email</strong><p><a href="mailto:kp@universitas.ac.id">kp@universitas.ac.id</a></p></div>
          </div>
          <div class="contact-item">
            <span class="ico" aria-hidden="true">📞</span>
            <div><strong>Telepon</strong><p><a href="tel:+6282155325944">+62 821-5532-5944</a></p></div>
          </div>
        </div>

        <form class="form" method="POST" action="{{ route('kontak.kirim') }}" data-reveal>
          @csrf

          @if (session('sukses'))
            <div style="background:#dcfce7;border:1px solid #86efac;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:8px">
              {{ session('sukses') }}
            </div>
          @endif

          <div class="field">
            <label for="nama">Nama Lengkap <span class="req" aria-hidden="true">*</span></label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" autocomplete="name" placeholder="Nama lengkap Anda" required>
            @error('nama') <small style="color:#dc2626">{{ $message }}</small> @enderror
          </div>
          <div class="field">
            <label for="email">Email <span class="req" aria-hidden="true">*</span></label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="nama@email.com" required>
            @error('email') <small style="color:#dc2626">{{ $message }}</small> @enderror
          </div>
          <div class="field">
            <label for="subjek">Subjek</label>
            <input type="text" id="subjek" name="subjek" value="{{ old('subjek') }}" placeholder="Perihal pesan (opsional)">
          </div>
          <div class="field">
            <label for="pesan">Pesan <span class="req" aria-hidden="true">*</span></label>
            <textarea id="pesan" name="pesan" placeholder="Tulis pertanyaan atau pesan Anda..." required>{{ old('pesan') }}</textarea>
            @error('pesan') <small style="color:#dc2626">{{ $message }}</small> @enderror
          </div>
          <button type="submit" class="btn btn--gold btn--lg">Kirim Pesan</button>
          <p class="form__note">Dengan mengirim, Anda menyetujui data Anda digunakan untuk merespons pertanyaan ini.</p>
        </form>
      </div>
    </div>
  </section>
@endsection
