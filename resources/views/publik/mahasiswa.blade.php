@extends('layouts.publik')

@section('title', 'Data Mahasiswa KP')

@section('content')
  <section class="page-hero" aria-labelledby="mh-title">
    <div class="container">
      <span class="hero__badge">Mahasiswa</span>
      <h1 id="mh-title">Data Mahasiswa KP</h1>
      <p>Daftar mahasiswa yang mengikuti Program Kerja Praktik. Mereka menjalankan kegiatan magang pada berbagai mitra industri untuk meningkatkan kompetensi dan pengalaman kerja profesional.</p>
    </div>
  </section>

  <section class="section section--tint" aria-labelledby="tbl-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">Daftar Peserta</span>
        <h2 id="tbl-title">Peserta Kerja Praktik</h2>
        <p>Mahasiswa yang terdaftar sebagai peserta program.</p>
      </div>
      <div class="table-wrap" data-reveal>
        <table class="data-table">
          <caption class="sr-only">Daftar mahasiswa peserta Program KP.</caption>
          <thead>
            <tr><th scope="col">No</th><th scope="col">Nama</th><th scope="col">NIM</th><th scope="col">Program Studi</th></tr>
          </thead>
          <tbody>
            @forelse ($mahasiswa as $i => $m)
              <tr>
                <td data-label="No">{{ $i + 1 }}</td>
                <td data-label="Nama">{{ $m->nama }}</td>
                <td data-label="NIM">{{ $m->nim ?: '-' }}</td>
                <td data-label="Program Studi">{{ $m->jurusan ?: '-' }}</td>
              </tr>
            @empty
              <tr><td colspan="4" style="text-align:center;padding:24px">Belum ada data mahasiswa.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </section>

  @if ($mahasiswa->whereNotNull('deskripsi')->count())
    <section class="section" aria-labelledby="unggul-title">
      <div class="container">
        <div class="section-head">
          <span class="eyebrow">Sorotan</span>
          <h2 id="unggul-title">Profil Mahasiswa</h2>
          <p>Mahasiswa peserta kerja praktik.</p>
        </div>
        <div class="grid grid--3" data-reveal>
          @foreach ($mahasiswa->whereNotNull('deskripsi') as $m)
            <article class="card card--accent">
              <div class="card__icon" aria-hidden="true">🎓</div>
              <h3>{{ $m->nama }}</h3>
              <p>{{ $m->deskripsi }}</p>
            </article>
          @endforeach
        </div>
      </div>
    </section>
  @endif
@endsection
