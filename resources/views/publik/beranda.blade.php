@extends('layouts.publik')
@php use App\Models\Konten; @endphp

@section('title', 'Program Kerja Praktik (KP) — Membangun Kompetensi Profesional Mahasiswa')

@section('content')
  <section class="hero" aria-labelledby="hero-title">
    <div class="container hero__inner">
      <span class="hero__badge">{{ Konten::get('beranda_badge', 'Tahun Akademik 2026') }}</span>
      <h1 id="hero-title">{!! Konten::get('beranda_judul', 'Program <span class="accent">Kerja Praktik</span> untuk Mahasiswa Siap Kerja') !!}</h1>
      <p class="hero__lead">{{ Konten::get('beranda_lead', 'Membangun pengalaman kerja nyata di dunia industri dan meningkatkan kompetensi mahasiswa menuju jenjang profesional.') }}</p>
      <div class="hero__actions">
        <a href="{{ route('profil') }}" class="btn btn--gold btn--lg">Tentang Program</a>
        <a href="{{ route('kontak') }}" class="btn btn--ghost btn--lg">Hubungi Kami</a>
      </div>
      <div class="trust">
        <p>Didukung mitra industri terpercaya</p>
        <ul>
          <li>Manufaktur</li><li>Teknologi Informasi</li><li>Telekomunikasi</li><li>Energi</li><li>Pemerintahan</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="section section--tint" aria-labelledby="about-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">Tentang Program</span>
        <h2 id="about-title">Apa itu Program KP?</h2>
        <p>{{ Konten::get('beranda_tentang', 'Program Kerja Praktik dirancang untuk memberikan pengalaman magang langsung di dunia kerja, sehingga mahasiswa memperoleh pengetahuan dan keterampilan profesional yang relevan dengan kebutuhan industri.') }}</p>
      </div>
    </div>
  </section>

  <section class="section" aria-labelledby="features-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">Keunggulan</span>
        <h2 id="features-title">Mengapa Memilih Program KP</h2>
        <p>Tiga pilar yang menjadikan pengalaman kerja praktik bermakna dan terarah.</p>
      </div>
      <div class="grid grid--3" data-reveal>
        <article class="card card--accent">
          <div class="card__icon" aria-hidden="true">🏢</div>
          <h3>Mitra Industri</h3>
          <p>Bekerja sama dengan beragam perusahaan dan instansi sebagai tempat pelaksanaan kerja praktik.</p>
        </article>
        <article class="card card--accent">
          <div class="card__icon" aria-hidden="true">🧭</div>
          <h3>Pembimbing Berpengalaman</h3>
          <p>Setiap mahasiswa didampingi dosen pembimbing yang berpengalaman selama proses kerja praktik.</p>
        </article>
        <article class="card card--accent">
          <div class="card__icon" aria-hidden="true">📈</div>
          <h3>Pengalaman Kerja Nyata</h3>
          <p>Mahasiswa terlibat langsung dalam proyek industri untuk mengasah kompetensi dunia kerja.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="section section--navy" aria-labelledby="stats-title">
    <div class="container">
      <h2 id="stats-title" class="sr-only">Statistik Program KP</h2>
      <div class="stats" data-reveal>
        <div class="stat"><span class="stat__num"><span data-count="150">0</span><span class="plus">+</span></span><span class="stat__label">Mahasiswa KP</span></div>
        <div class="stat"><span class="stat__num"><span data-count="50">0</span><span class="plus">+</span></span><span class="stat__label">Mitra Industri</span></div>
        <div class="stat"><span class="stat__num"><span data-count="20">0</span><span class="plus">+</span></span><span class="stat__label">Dosen Pembimbing</span></div>
        <div class="stat"><span class="stat__num"><span data-count="100">0</span><span class="plus">%</span></span><span class="stat__label">Tingkat Partisipasi</span></div>
      </div>
    </div>
  </section>

  <section class="section section--tint" aria-labelledby="cta-title">
    <div class="container">
      <div class="section-head" style="margin-bottom:0">
        <span class="eyebrow">Mulai Sekarang</span>
        <h2 id="cta-title">Siap Memulai Kerja Praktik?</h2>
        <p>Pelajari profil program lebih lanjut atau hubungi tim kami untuk informasi pendaftaran.</p>
        <div class="hero__actions" style="margin-top:28px">
          <a href="{{ route('profil') }}" class="btn btn--lg">Lihat Profil Program</a>
          <a href="{{ route('kontak') }}" class="btn btn--gold btn--lg">Hubungi Tim KP</a>
        </div>
      </div>
    </div>
  </section>
@endsection
