@extends('layouts.app')

@section('title', 'Sejarah Sekolah')
@section('description', 'Sejarah berdiri dan perkembangan SDN Dadapsari sejak tahun 1965 hingga sekarang.')

@push('styles')
<style>
    /* ── PAGE HEADER ── */
    .sejarah-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, #2a8aa3 100%);
        color: var(--white);
        padding: 3.5rem 1.5rem 6rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .sejarah-header::before {
        content: '';
        position: absolute;
        width: 300px; height: 300px;
        background: rgba(87,197,182,.15);
        border-radius: 50%;
        top: -100px; right: -60px;
        filter: blur(8px);
    }
    .sejarah-header .eyebrow { color: var(--accent); }
    .sejarah-header h1 { font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 800; margin: .4rem 0 .6rem; position: relative; }
    .sejarah-header p  { max-width: 620px; margin: 0 auto; color: rgba(255,255,255,.8); position: relative; }

    /* ── HERO PHOTO STRIP ── */
    .sejarah-photo-strip {
        max-width: 860px;
        margin: -3.5rem auto 0;
        padding: 0 1.25rem;
        position: relative;
        z-index: 2;
    }
    .sejarah-photo-strip img {
        width: 100%;
        height: auto;
        max-height: 460px;
        object-fit: contain;
        background: var(--bg);
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        display: block;
    }
    .sejarah-photo-caption {
        text-align: center;
        font-size: .78rem;
        color: var(--muted);
        margin-top: .6rem;
        font-style: italic;
    }

    /* ── IDENTITY BADGES ── */
    .sejarah-ids {
        max-width: 860px;
        margin: 1.25rem auto 0;
        padding: 0 1.25rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .id-badge {
        background: var(--white);
        border-radius: 12px;
        box-shadow: var(--shadow);
        padding: .6rem 1.1rem;
        display: flex;
        align-items: center;
        gap: .6rem;
        font-size: .82rem;
    }
    .id-badge .label { color: var(--muted); font-size: .72rem; text-transform: uppercase; letter-spacing: .5px; font-weight: 700; }
    .id-badge .val   { font-weight: 700; color: var(--primary-dark); }

    /* ── MAIN CARD ── */
    .sejarah-wrap { max-width: 860px; margin: 1.5rem auto 4rem; padding: 0 1.25rem; }

    .sejarah-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        padding: 2.5rem;
    }

    .sejarah-card p { line-height: 1.85; color: var(--text); margin-bottom: 1.2rem; font-size: .97rem; }
    .sejarah-card p:last-child { margin-bottom: 0; }

    /* ── SEJARAH SINGKAT (blok utama) ── */
    .sejarah-singkat { margin-bottom: 1.75rem; padding-bottom: 1.75rem; border-bottom: 1px solid #eef1f5; }
    .sejarah-singkat-title {
        text-align: center;
        font-size: clamp(1.15rem, 2.6vw, 1.55rem);
        font-weight: 800;
        color: var(--primary-dark);
        letter-spacing: .3px;
        margin-bottom: 1.4rem;
    }
    .sejarah-singkat-title::after {
        content: '';
        display: block;
        width: 64px; height: 3px;
        background: var(--accent);
        border-radius: 3px;
        margin: .65rem auto 0;
    }
    .sejarah-singkat p { text-align: justify; }

    .sejarah-section-title {
        font-size: 1.1rem; font-weight: 700; color: var(--primary-dark);
        border-left: 4px solid var(--accent); padding-left: .9rem;
        margin: 2rem 0 1.25rem;
    }

    /* ── TIMELINE ── */
    .timeline {
        position: relative;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 52px;
        top: 0; bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, var(--accent), rgba(87,197,182,.1));
    }
    .timeline-item {
        display: grid;
        grid-template-columns: 104px 1fr;
        gap: 1rem;
        padding-bottom: 1.75rem;
        position: relative;
    }
    .timeline-item:last-child { padding-bottom: 0; }

    .timeline-year-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }
    .timeline-year-badge {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: #fff;
        font-size: .75rem;
        font-weight: 800;
        padding: .3rem .6rem;
        border-radius: 8px;
        letter-spacing: .5px;
        white-space: nowrap;
        position: relative;
        z-index: 1;
    }
    .timeline-dot {
        width: 12px; height: 12px;
        background: var(--accent);
        border: 2px solid var(--white);
        box-shadow: 0 0 0 2px var(--accent);
        border-radius: 50%;
        margin-top: .6rem;
        position: relative;
        z-index: 1;
    }
    .timeline-content {
        background: var(--bg);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        border-left: 3px solid var(--accent-soft);
    }
    .timeline-content h4 { font-size: .97rem; color: var(--primary-dark); margin-bottom: .3rem; font-weight: 700; }
    .timeline-content p  { font-size: .88rem; color: var(--muted); margin: 0; line-height: 1.6; }

    /* ── KOMITMEN HIGHLIGHT ── */
    .komitmen-wrap {
        background: linear-gradient(135deg, var(--primary-dark), var(--primary));
        color: var(--white);
        border-radius: var(--radius);
        padding: 2rem;
        margin-top: 2rem;
    }
    .komitmen-wrap .sejarah-section-title { color: var(--accent); border-left-color: rgba(255,255,255,.4); }
    .komitmen-wrap p { color: rgba(255,255,255,.88); margin-bottom: 1rem; font-size: .95rem; line-height: 1.8; }
    .komitmen-wrap p:last-child { margin-bottom: 0; }

    /* ── MOTTO STRIP ── */
    .motto-strip {
        background: var(--accent-soft);
        border-left: 5px solid var(--accent);
        border-radius: 0 12px 12px 0;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary-dark);
        font-style: italic;
    }

    .back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .85rem; color: #fff; text-decoration: none;
        margin-bottom: 1.25rem; font-weight: 600;
        text-shadow: 0 1px 6px rgba(0,0,0,.35);
        position: relative; z-index: 2;
    }
    .back-link:hover { color: rgba(255,255,255,.75); }

    @media (max-width: 600px) {
        .timeline::before { left: 20px; }
        .timeline-item { grid-template-columns: 44px 1fr; }
        .timeline-year-badge { font-size: .68rem; padding: .25rem .4rem; }
    }
</style>
@endpush

@section('content')

<section class="sejarah-header">
    <span class="eyebrow">Profil Sekolah</span>
    <h1>Sejarah SDN Dadapsari</h1>
    <p>Perjalanan panjang sejak 1965 — dari SDN Mlayu Darat hingga menjadi SDN Dadapsari yang berprestasi.</p>
</section>

{{-- School Photo --}}
<div class="sejarah-photo-strip">
    <a href="{{ route('home') }}#profil" class="back-link">← Kembali ke Profil</a>
    <img src="{{ asset('images/sekolah-1.jpeg') }}" alt="SDN Dadapsari Kota Semarang">
    <p class="sejarah-photo-caption">SDN Dadapsari — Jl. Petek No. 117-119, Kec. Semarang Utara, Kota Semarang</p>
</div>

{{-- Identity badges --}}
<div class="sejarah-ids">
    <div class="id-badge">
        <div>
            <div class="label">NPSN</div>
            <div class="val">20329393</div>
        </div>
    </div>
    <div class="id-badge">
        <div>
            <div class="label">NSS</div>
            <div class="val">1010301133008</div>
        </div>
    </div>
    <div class="id-badge">
        <div>
            <div class="label">Tahun Berdiri</div>
            <div class="val">1965</div>
        </div>
    </div>
    <div class="id-badge">
        <div>
            <div class="label">Status</div>
            <div class="val">Negeri</div>
        </div>
    </div>
</div>

<div class="sejarah-wrap">
    <div class="sejarah-card">

        {{-- Sejarah Singkat --}}
        @if ($setting->sejarah_singkat)
            <div class="sejarah-singkat">
                @if ($setting->sejarah_singkat_judul)
                    <h2 class="sejarah-singkat-title">{{ $setting->sejarah_singkat_judul }}</h2>
                @endif
                @foreach (array_filter(explode("\n\n", $setting->sejarah_singkat)) as $para)
                    <p>{{ trim($para) }}</p>
                @endforeach
            </div>
        @endif

        {{-- Motto --}}
        <div class="motto-strip">
            "Santun dalam berperilaku, hebat dalam prestasi"
        </div>

        {{-- Paragraf Pengantar --}}
        @if ($setting->sejarah_intro)
            @foreach (array_filter(explode("\n\n", $setting->sejarah_intro)) as $para)
                <p>{{ trim($para) }}</p>
            @endforeach
        @endif

        {{-- Timeline --}}
        @if (!empty($setting->sejarah_timeline))
            <div class="sejarah-section-title">Perjalanan Sekolah</div>
            <div class="timeline">
                @foreach ($setting->sejarah_timeline as $item)
                    <div class="timeline-item">
                        <div class="timeline-year-col">
                            @if (!empty($item['tahun']))
                                <div class="timeline-year-badge">{{ $item['tahun'] }}</div>
                            @endif
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="timeline-content">
                            @if (!empty($item['judul']))
                                <h4>{{ $item['judul'] }}</h4>
                            @endif
                            @if (!empty($item['deskripsi']))
                                <p>{{ $item['deskripsi'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Paragraf Komitmen --}}
        @if ($setting->sejarah_komitmen)
            <div class="komitmen-wrap">
                <div class="sejarah-section-title">Komitmen Kami</div>
                @foreach (array_filter(explode("\n\n", $setting->sejarah_komitmen)) as $para)
                    <p>{{ trim($para) }}</p>
                @endforeach
            </div>
        @endif

    </div>
</div>

@endsection
