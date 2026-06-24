@extends('layouts.app')

@section('title', 'Visi & Misi')
@section('description', 'Visi, misi, tujuan, dan nilai-nilai SDN Dadapsari dalam mewujudkan pendidikan berkualitas.')

@push('styles')
<style>
    /* ── HEADER – amber/orange accent to distinguish from sejarah ── */
    .vm-header {
        background: linear-gradient(135deg, #003d6b 0%, #005c8f 45%, #0078b8 100%);
        color: var(--white);
        padding: 3.5rem 1.5rem 5.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .vm-header::before {
        content: '';
        position: absolute;
        width: 350px; height: 350px;
        background: rgba(255,196,0,.1);
        border-radius: 50%;
        top: -130px; left: -80px;
        filter: blur(8px);
    }
    .vm-header .eyebrow {
        display: inline-block;
        background: rgba(255,196,0,.2);
        color: #ffd54f;
        padding: .3rem .9rem;
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: .8rem;
    }
    .vm-header h1 { font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 800; margin: .4rem 0 .6rem; position: relative; }
    .vm-header p  { max-width: 620px; margin: 0 auto; color: rgba(255,255,255,.8); position: relative; }

    /* ── LOGO STRIP (school identity visual) ── */
    .vm-logo-strip {
        max-width: 960px;
        margin: -2.5rem auto 0;
        padding: 0 1.25rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
        position: relative;
        z-index: 2;
    }
    .vm-logo-strip .back-link { width: 100%; margin-bottom: 0; }
    .vm-logo-box {
        background: var(--white);
        border-radius: 20px;
        padding: 1rem 1.5rem;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-shrink: 0;
    }
    .vm-logo-box img { width: 64px; height: 64px; object-fit: contain; }
    .vm-logo-box-text h3 { font-size: 1rem; font-weight: 800; color: var(--primary-dark); margin: 0; }
    .vm-logo-box-text p  { font-size: .78rem; color: var(--muted); margin: 0; font-style: italic; }

    /* ── LAYOUT ── */
    .vm-wrap {
        max-width: 960px;
        margin: 1.5rem auto 4rem;
        padding: 0 1.25rem;
        display: grid;
        gap: 1.25rem;
    }

    /* ── CARDS ── */
    .vm-card {
        background: var(--white);
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
    }

    /* Visi – special gradient header */
    .vm-card-visi .vm-card-head {
        background: linear-gradient(135deg, #003d6b, #005c8f);
        color: var(--white);
        padding: 1.4rem 1.75rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .vm-card-visi .vm-card-head h3 { color: #fff; font-size: 1.05rem; font-weight: 700; margin: 0; }
    .vm-card-visi .vm-icon-wrap {
        width: 44px; height: 44px; border-radius: 12px;
        background: rgba(255,255,255,.15);
        display: grid; place-items: center; font-size: 1.4rem; flex-shrink: 0;
    }

    /* Other cards */
    .vm-card-head {
        display: flex; align-items: center; gap: 1rem;
        padding: 1.35rem 1.75rem; background: var(--bg);
        border-bottom: 1px solid rgba(0,43,91,.06);
    }
    .vm-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: var(--white); display: grid; place-items: center;
        font-size: 1.4rem; flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,43,91,.1);
    }
    .vm-card-head h3 { font-size: 1.05rem; font-weight: 700; color: var(--primary-dark); margin: 0; }
    .vm-card-body { padding: 1.75rem; }

    /* Visi quote */
    .vm-visi-text {
        font-size: 1.08rem; font-weight: 600; color: var(--primary-dark);
        line-height: 1.75; font-style: italic;
        border-left: 4px solid #ffd54f;
        padding: .75rem 1.25rem;
        background: #fffbea;
        border-radius: 0 12px 12px 0;
        margin: 0;
    }

    /* Numbered list (misi, tujuan) */
    .vm-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .85rem; }
    .vm-list li { display: flex; gap: .85rem; align-items: flex-start; font-size: .95rem; color: var(--text); line-height: 1.6; }
    .vm-list .num {
        flex-shrink: 0; width: 28px; height: 28px; border-radius: 50%;
        background: linear-gradient(135deg, #003d6b, #0078b8);
        color: #fff; font-size: .72rem; font-weight: 700;
        display: grid; place-items: center; margin-top: .05rem;
    }

    /* Nilai grid */
    .nilai-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 1rem; }
    .nilai-item {
        background: var(--bg); border-radius: 12px;
        padding: .85rem 1.1rem;
        display: flex; align-items: center; gap: .75rem;
        font-size: .9rem; font-weight: 600; color: var(--primary-dark);
        border-left: 3px solid var(--accent);
    }
    .nilai-item .ico { font-size: 1.4rem; flex-shrink: 0; }

    .back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .85rem; color: #fff; text-decoration: none;
        margin-bottom: 1.25rem; font-weight: 600;
        text-shadow: 0 1px 6px rgba(0,0,0,.35);
        position: relative; z-index: 2;
    }
    .back-link:hover { color: rgba(255,255,255,.75); }

    @media (max-width: 600px) {
        .nilai-grid { grid-template-columns: 1fr 1fr; }
        .vm-logo-strip { flex-direction: column; align-items: flex-start; }
    }
</style>
@endpush

@section('content')

<section class="vm-header">
    <span class="eyebrow">Profil Sekolah</span>
    <h1>Visi &amp; Misi</h1>
    <p>Landasan filosofi dan arah gerak SDN Dadapsari dalam menyelenggarakan pendidikan yang bermakna dan berkualitas.</p>
</section>

{{-- School logo identity strip --}}
<div class="vm-logo-strip">
    <a href="{{ route('home') }}#profil" class="back-link">← Kembali ke Profil</a>
    <div class="vm-logo-box">
        <img src="{{ asset('images/logo-front.png') }}" alt="Logo SDN Dadapsari">
        <div class="vm-logo-box-text">
            <h3>SD Negeri Dadapsari</h3>
            <p>Kota Semarang &mdash; NPSN 20329393</p>
        </div>
    </div>
</div>

<div class="vm-wrap">

    {{-- VISI --}}
    @if ($setting->visi)
    <div class="vm-card vm-card-visi">
        <div class="vm-card-head">
            <div class="vm-icon-wrap">🎯</div>
            <h3>Visi Sekolah</h3>
        </div>
        <div class="vm-card-body">
            <p class="vm-visi-text">"{{ $setting->visi }}"</p>
        </div>
    </div>
    @endif

    {{-- MISI --}}
    @if (!empty($setting->misi))
    <div class="vm-card">
        <div class="vm-card-head">
            <div class="vm-icon">🚀</div>
            <h3>Misi Sekolah</h3>
        </div>
        <div class="vm-card-body">
            <ol class="vm-list">
                @foreach ($setting->misi as $i => $butir)
                <li>
                    <span class="num">{{ $i + 1 }}</span>
                    <span>{{ $butir }}</span>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
    @endif

    {{-- TUJUAN --}}
    @if (!empty($setting->tujuan))
    <div class="vm-card">
        <div class="vm-card-head">
            <div class="vm-icon">🏆</div>
            <h3>Tujuan Sekolah</h3>
        </div>
        <div class="vm-card-body">
            <ol class="vm-list">
                @foreach ($setting->tujuan as $i => $butir)
                <li>
                    <span class="num">{{ $i + 1 }}</span>
                    <span>{{ $butir }}</span>
                </li>
                @endforeach
            </ol>
        </div>
    </div>
    @endif

    {{-- NILAI --}}
    @if (!empty($setting->nilai))
    <div class="vm-card">
        <div class="vm-card-head">
            <div class="vm-icon">💡</div>
            <h3>Nilai-Nilai Sekolah</h3>
        </div>
        <div class="vm-card-body">
            <div class="nilai-grid">
                @foreach ($setting->nilai as $n)
                <div class="nilai-item">
                    <span class="ico">{{ $n['icon'] ?? '' }}</span>
                    {{ $n['nama'] ?? '' }}
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

</div>

@endsection
