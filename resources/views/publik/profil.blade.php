@extends('layouts.publik')
@php use App\Models\Konten; @endphp

@section('title', 'Profil Program KP')
@section('description', 'Profil Program Kerja Praktik: sejarah, visi misi, fasilitas, dan struktur organisasi.')

@section('content')
  <section class="page-hero" aria-labelledby="ph-title">
    <div class="container">
      <span class="hero__badge">Profil</span>
      <h1 id="ph-title">Profil Program Kerja Praktik</h1>
      <p>Kenali lebih dalam Program KP — dari perjalanan sejarahnya, visi dan misi yang memandu, fasilitas pendukung, hingga tim yang mengelolanya.</p>
    </div>
  </section>

  <nav class="profil-subnav" aria-label="Navigasi profil">
    <ul>
      <li><a href="#sejarah">Sejarah</a></li>
      <li><a href="#visi-misi">Visi &amp; Misi</a></li>
      <li><a href="#fasilitas">Fasilitas</a></li>
      <li><a href="#struktur-organisasi">Struktur Organisasi</a></li>
    </ul>
  </nav>

  <section id="sejarah" class="section section--tint section--profil" aria-labelledby="sejarah-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">Sejarah</span>
        <h2 id="sejarah-title">Perjalanan Program KP</h2>
        <p>{{ Konten::get('profil_sejarah', 'Sejak didirikan, Program Kerja Praktik terus berkembang untuk menjawab tantangan dunia industri dan kebutuhan kompetensi mahasiswa.') }}</p>
      </div>
      <div class="timeline" data-reveal>
        @foreach ([
          ['2018', 'Pendirian Program KP', 'Program Kerja Praktik resmi dibentuk sebagai bagian dari kurikulum Teknik Komputer, menjalin kemitraan perdana dengan 2 perusahaan industri lokal.'],
          ['2020', 'Adaptasi Mode Daring', 'Di tengah pandemi, program berhasil beralih ke model KP hibrida — mempertahankan kualitas pengalaman kerja dengan memanfaatkan teknologi kolaborasi jarak jauh.'],
          ['2022', 'Perluasan Mitra Industri', 'Jumlah mitra industri bertambah hingga mencakup sektor teknologi informasi, telekomunikasi, dan pemerintahan.'],
          ['2024', 'Pembaruan Kurikulum KP', 'Panduan teknis dan sistem penilaian KP diperbarui sesuai standar MBKM.'],
          ['2026', 'Program KP Saat Ini', 'Tahun Akademik 2026 mencatat mahasiswa aktif KP dengan sistem pemantauan berbasis web.'],
        ] as $item)
          <div class="timeline-item">
            <div class="timeline-dot">{{ $item[0] }}</div>
            <div class="timeline-body">
              <div class="timeline-year">{{ $item[0] }}</div>
              <h3>{{ $item[1] }}</h3>
              <p>{{ $item[2] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <section id="visi-misi" class="section section--profil" aria-labelledby="vm-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">Arah Program</span>
        <h2 id="vm-title">Visi &amp; Misi</h2>
        <p>Landasan yang memandu setiap kegiatan dan pengambilan keputusan dalam Program Kerja Praktik.</p>
      </div>
      <div class="grid grid--3" data-reveal style="max-width:880px;margin-inline:auto">
        <article class="card card--accent">
          <div class="card__icon" aria-hidden="true">🎯</div>
          <h3>Visi</h3>
          <p>{{ Konten::get('profil_visi', 'Menjadi program kerja praktik unggulan yang menghasilkan lulusan profesional, kompeten, dan siap menghadapi tantangan dunia kerja global.') }}</p>
        </article>
        <article class="card card--accent">
          <div class="card__icon" aria-hidden="true">🚀</div>
          <h3>Misi</h3>
          <p style="color:var(--slate-500);font-size:.96rem;white-space:pre-line">{{ Konten::get('profil_misi', "✔ Memberikan pengalaman kerja nyata di industri terkemuka\n✔ Meningkatkan kompetensi teknis dan non-teknis mahasiswa\n✔ Memperluas jaringan kemitraan dengan dunia industri\n✔ Mendukung implementasi kebijakan MBKM") }}</p>
        </article>
        <article class="card card--accent">
          <div class="card__icon" aria-hidden="true">🤝</div>
          <h3>Nilai</h3>
          <ul style="color:var(--slate-500);font-size:.96rem;display:grid;gap:8px;padding-left:0;list-style:none">
            <li>⭑ Integritas dalam setiap proses</li>
            <li>⭑ Kolaborasi lintas disiplin</li>
            <li>⭑ Pembelajaran berkelanjutan</li>
            <li>⭑ Inovasi berorientasi industri</li>
          </ul>
        </article>
      </div>
    </div>
  </section>

  <section id="fasilitas" class="section section--tint section--profil" aria-labelledby="fasilitas-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">Fasilitas</span>
        <h2 id="fasilitas-title">Dukungan untuk Mahasiswa KP</h2>
        <p>Berbagai fasilitas dan layanan tersedia untuk mendukung kelancaran pelaksanaan Kerja Praktik mahasiswa.</p>
      </div>
      <div class="fasilitas-grid" data-reveal>
        @foreach ([
          ['📋','Portal Administrasi KP','Sistem informasi terpadu untuk pengajuan, pemantauan status, dan pengumpulan laporan Kerja Praktik secara daring.'],
          ['👨‍🏫','Bimbingan Dosen','Setiap mahasiswa mendapatkan satu dosen pembimbing yang siap memberikan arahan, konsultasi, dan evaluasi selama periode KP.'],
          ['🏢','Jaringan Mitra Industri','Akses ke lebih dari 50 mitra industri di sektor teknologi, manufaktur, telekomunikasi, energi, dan instansi pemerintahan.'],
          ['📚','Perpustakaan & Referensi','Koleksi panduan teknis, template laporan, dan referensi industri yang dapat diakses oleh seluruh peserta KP.'],
          ['💻','Laboratorium Komputer','Fasilitas lab komputer dengan perangkat lunak industri untuk persiapan KP.'],
          ['🛡️','Asuransi & Perlindungan','Perlindungan asuransi kecelakaan kerja selama masa KP berlangsung.'],
        ] as $f)
          <article class="card card--accent">
            <div class="card__icon" aria-hidden="true">{{ $f[0] }}</div>
            <h3>{{ $f[1] }}</h3>
            <p>{{ $f[2] }}</p>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <section id="struktur-organisasi" class="section section--profil" aria-labelledby="org-title">
    <div class="container">
      <div class="section-head">
        <span class="eyebrow">Tim Pengelola</span>
        <h2 id="org-title">Struktur Organisasi</h2>
        <p>Tim yang bertanggung jawab atas pengelolaan, pelaksanaan, dan pengembangan Program Kerja Praktik.</p>
      </div>
      <div class="org-grid" data-reveal>
        @foreach ([
          ['Dr. Ahmad Fauzi, M.T.','Ketua Program KP'],
          ['Ir. Siti Rahayu, M.Sc.','Koordinator Lapangan'],
          ['Budi Santoso, S.T., M.T.','Dosen Pembimbing I'],
          ['Dewi Anggraini, M.Kom.','Dosen Pembimbing II'],
          ['Rizki Pratama, A.Md.','Staf Administrasi'],
          ['Nur Azizah, S.Pd.','Koordinator Kemitraan'],
        ] as $o)
          <div class="org-card">
            <div class="org-card__avatar" aria-hidden="true">👤</div>
            <div class="org-card__name">{{ $o[0] }}</div>
            <div class="org-card__role">{{ $o[1] }}</div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection
