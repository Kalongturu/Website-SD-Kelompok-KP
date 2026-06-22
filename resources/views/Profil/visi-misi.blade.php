@extends('layouts.app')

@section('title', 'Visi & Misi')
@section('description', 'Visi, misi, dan tujuan SDN Dadapsari dalam mewujudkan pendidikan berkualitas.')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, #2a8aa3 100%);
        color: var(--white); padding: 3.5rem 1.5rem 5rem; text-align: center;
    }
    .page-header .eyebrow { color: var(--accent); }
    .page-header h1 { font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 800; margin: .4rem 0 .6rem; }
    .page-header p  { max-width: 620px; margin: 0 auto; color: rgba(255,255,255,.8); }

    .vm-wrap { max-width: 940px; margin: -3rem auto 4rem; padding: 0 1.25rem; display: grid; gap: 1.5rem; }

    .vm-card { background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow-lg); overflow: hidden; }
    .vm-card-head {
        display: flex; align-items: center; gap: 1rem;
        padding: 1.35rem 1.75rem; background: var(--accent-soft);
        border-bottom: 1px solid rgba(0,43,91,.06);
    }
    .vm-icon {
        width: 44px; height: 44px; border-radius: 12px; display: grid; place-items: center;
        font-size: 1.4rem; flex-shrink: 0; background: var(--white);
        box-shadow: 0 2px 8px rgba(0,43,91,.1);
    }
    .vm-card-head h3 { font-size: 1.05rem; font-weight: 700; color: var(--primary-dark); margin: 0; }
    .vm-card-body { padding: 1.75rem; }

    .vm-visi-text {
        font-size: 1.08rem; font-weight: 600; color: var(--primary-dark); line-height: 1.7;
        font-style: italic; border-left: 4px solid var(--accent); padding-left: 1.25rem; margin: 0;
    }

    .vm-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .85rem; }
    .vm-list li { display: flex; gap: .85rem; align-items: flex-start; font-size: .95rem; color: var(--text); line-height: 1.6; }
    .vm-list .num {
        flex-shrink: 0; width: 26px; height: 26px; border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: #fff; font-size: .72rem; font-weight: 700; display: grid; place-items: center; margin-top: .1rem;
    }

    .nilai-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
    .nilai-item {
        background: var(--bg); border-radius: 12px; padding: 1rem 1.1rem;
        display: flex; align-items: center; gap: .75rem;
        font-size: .9rem; font-weight: 600; color: var(--primary-dark);
    }
    .nilai-item .ico { font-size: 1.4rem; flex-shrink: 0; }

    .back-link {
        display: inline-flex; align-items: center; gap: .4rem;
        font-size: .85rem; color: #fff; text-decoration: none;
        margin-bottom: 1.25rem; font-weight: 600;
        text-shadow: 0 1px 6px rgba(0,0,0,.35);
    }
    .back-link:hover { color: rgba(255,255,255,.75); }

    @media (max-width: 600px) { .nilai-grid { grid-template-columns: 1fr 1fr; } }
</style>
@endpush

@section('content')

<section class="page-header">
    <span class="eyebrow">Profil Sekolah</span>
    <h1>Visi &amp; Misi</h1>
    <p>Landasan filosofi dan arah gerak SDN Dadapsari dalam menyelenggarakan pendidikan yang bermakna dan berkualitas.</p>
</section>

<div class="vm-wrap">
    <a href="{{ route('home') }}#profil" class="back-link">← Kembali ke Profil</a>

    {{-- VISI --}}
    @if ($setting->visi)
    <div class="vm-card">
        <div class="vm-card-head">
            <div class="vm-icon">🎯</div>
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
