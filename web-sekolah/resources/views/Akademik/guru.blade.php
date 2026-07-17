@extends('layouts.app')

@section('title', 'Guru & Staf')
@section('description', 'Tenaga pendidik dan kependidikan SDN Dadapsari Semarang — kepala sekolah, guru, dan staf.')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--primary-ink) 100%);
        color: var(--white);
        padding: 3.5rem 1.5rem 5rem;
        text-align: center;
    }
    .page-header .eyebrow { color: var(--accent); }
    .page-header h1 { font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 800; margin: .4rem 0 .6rem; }
    .page-header p { max-width: 640px; margin: 0 auto; color: rgba(255, 255, 255, .8); }

    .guru-wrap { max-width: 1180px; margin: 2.5rem auto 4rem; padding: 0 1.25rem; }
    /* Tarik konten naik agar kartu sorotan Kepala Sekolah menumpuk di header —
       hanya saat kartu kepala memang ada, supaya judul seksi tak menabrak header. */
    .guru-wrap.has-kepala { margin-top: -3rem; }

    /* ── Foto placeholder (silhouette) ── */
    .guru-ph {
        width: 100%; height: 100%;
        display: grid; place-items: center;
        background: linear-gradient(135deg, var(--primary), var(--accent));
    }
    .guru-ph svg { width: 46%; height: 46%; fill: rgba(255, 255, 255, .85); }

    /* ── KEPALA SEKOLAH (sorotan) ── */
    .guru-kepala { display: flex; justify-content: center; margin-bottom: 3rem; }
    .kepala-card {
        position: relative;
        background: var(--white);
        border: 1px solid #eef1f5;
        border-top: 4px solid var(--accent);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        width: min(330px, 100%);
        padding: 2.4rem 1.75rem 1.9rem;
        text-align: center;
    }
    .kepala-ribbon {
        position: absolute;
        top: -.85rem; left: 50%; transform: translateX(-50%);
        background: var(--accent);
        color: var(--primary-dark);
        font-size: .72rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: .7px;
        padding: .3rem 1.1rem; border-radius: 50px;
        box-shadow: 0 6px 16px rgba(255, 145, 11, .4);
        white-space: nowrap;
    }
    .kepala-photo {
        width: 185px; aspect-ratio: 3 / 4; margin: .5rem auto 1.3rem;
        border-radius: 14px; overflow: hidden;
        box-shadow: 0 12px 28px rgba(40, 40, 40, .18);
    }
    .kepala-photo img { width: 100%; height: 100%; object-fit: cover; }
    .kepala-name {
        display: inline-block;
        font-size: 1.1rem; font-weight: 700; color: var(--primary-dark);
        border-bottom: 2px solid var(--accent); padding-bottom: 4px;
    }
    .kepala-jabatan {
        margin-top: .6rem;
        font-size: .82rem; font-weight: 600; color: var(--primary);
        text-transform: uppercase; letter-spacing: .6px;
    }
    .kepala-nip { margin-top: .3rem; font-size: .76rem; color: var(--muted); }

    /* ── GRID GURU & STAF ── */
    .guru-section-title {
        text-align: center; color: var(--primary-dark);
        font-size: 1.3rem; font-weight: 700; margin-bottom: .35rem;
    }
    .guru-section-sub { text-align: center; color: var(--muted); font-size: .9rem; margin-bottom: 2rem; }

    .guru-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }

    .guru-card {
        background: var(--white);
        border: 1px solid #eef1f5;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        text-align: center;
        display: flex; flex-direction: column;
        transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }
    .guru-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: var(--accent);
    }
    .guru-photo { aspect-ratio: 3 / 4; overflow: hidden; background: #eef2f6; }
    .guru-photo img { width: 100%; height: 100%; object-fit: cover; }
    .guru-info { padding: 1rem .9rem 1.25rem; display: flex; flex-direction: column; gap: .35rem; flex: 1; }
    .guru-name {
        display: inline-block; align-self: center;
        font-size: .92rem; font-weight: 700; color: var(--primary-dark); line-height: 1.3;
        border-bottom: 2px solid var(--accent); padding-bottom: 3px;
    }
    .guru-jabatan {
        font-size: .76rem; font-weight: 600; color: var(--primary);
        text-transform: uppercase; letter-spacing: .5px; margin-top: .15rem;
    }
    .guru-nip { font-size: .72rem; color: var(--muted); }

    /* ── EMPTY STATE ── */
    .empty-state {
        background: var(--white);
        border: 1.5px dashed #cbd5e1;
        border-radius: var(--radius);
        padding: 3.5rem 1.5rem;
        text-align: center;
        color: var(--muted);
    }
    .empty-state .empty-icon { font-size: 3rem; margin-bottom: .6rem; }
    .empty-state h3 { color: var(--primary-dark); margin-bottom: .3rem; }

    @media (max-width: 992px) { .guru-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 700px)  { .guru-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 420px)  { .guru-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')

    <section class="page-header">
        <span class="eyebrow">Akademik</span>
        <h1>Guru &amp; Staf</h1>
        <p>Tenaga pendidik dan kependidikan SDN Dadapsari Semarang yang berdedikasi membimbing dan melayani peserta didik.</p>
    </section>

    <div class="guru-wrap {{ $kepala ? 'has-kepala' : '' }}">

        @if (! $kepala && $guru->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">👩‍🏫</div>
                <h3>Belum ada data guru &amp; staf</h3>
                <p>Data akan tampil di sini setelah ditambahkan oleh admin.</p>
            </div>
        @else

            {{-- ── KEPALA SEKOLAH ── --}}
            @if ($kepala)
                <div class="guru-kepala">
                    <div class="kepala-card">
                        <span class="kepala-ribbon">{{ $kepala->jabatan }}</span>
                        <div class="kepala-photo">
                            @if ($kepala->fotoUrl())
                                <img src="{{ $kepala->fotoUrl() }}" alt="{{ $kepala->nama }}">
                            @else
                                <span class="guru-ph">@include('partials.akademik.guru-silhouette')</span>
                            @endif
                        </div>
                        <span class="kepala-name">{{ $kepala->nama }}</span>
                        @if ($kepala->nip)
                            <div class="kepala-nip">NIP. {{ $kepala->nip }}</div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ── GURU & STAF ── --}}
            @if ($guru->isNotEmpty())
                <h2 class="guru-section-title">Guru &amp; Staf</h2>
                <p class="guru-section-sub">Bersama membangun generasi yang cerdas, berkarakter, dan berakhlak mulia.</p>

                <div class="guru-grid">
                    @foreach ($guru as $g)
                        <div class="guru-card">
                            <div class="guru-photo">
                                @if ($g->fotoUrl())
                                    <img src="{{ $g->fotoUrl() }}" alt="{{ $g->nama }}">
                                @else
                                    <span class="guru-ph">@include('partials.akademik.guru-silhouette')</span>
                                @endif
                            </div>
                            <div class="guru-info">
                                <span class="guru-name">{{ $g->nama }}</span>
                                <span class="guru-jabatan">{{ $g->jabatan }}</span>
                                @if ($g->nip)
                                    <span class="guru-nip">NIP. {{ $g->nip }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        @endif

    </div>

@endsection
