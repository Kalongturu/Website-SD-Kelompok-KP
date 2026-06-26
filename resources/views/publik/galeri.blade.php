@extends('layouts.publik')

@section('title', 'Galeri Program KP')

@section('content')
  <section class="page-hero" aria-labelledby="gl-title">
    <div class="container">
      <span class="hero__badge">Galeri</span>
      <h1 id="gl-title">Galeri Program KP</h1>
      <p>Dokumentasi kegiatan mahasiswa selama mengikuti Program Kerja Praktik — mulai dari pembekalan, kegiatan di industri, hingga presentasi hasil.</p>
    </div>
  </section>

  <section class="section section--tint" aria-labelledby="gal-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">Dokumentasi</span>
        <h2 id="gal-title">Momen Kegiatan</h2>
        <p>Rangkaian aktivitas yang terdokumentasi sepanjang program.</p>
      </div>
      <div class="gallery" data-reveal>
        @forelse ($galeri as $g)
          <article class="gallery-card">
            <figure>
              <img src="{{ asset('storage/' . $g->gambar) }}" alt="{{ $g->judul }}" loading="lazy" decoding="async">
              <figcaption>
                <h3>{{ $g->judul }}</h3>
                @if ($g->deskripsi)<p>{{ $g->deskripsi }}</p>@endif
              </figcaption>
            </figure>
          </article>
        @empty
          <p style="text-align:center;grid-column:1/-1;padding:24px">Belum ada foto di galeri.</p>
        @endforelse
      </div>
    </div>
  </section>
@endsection
