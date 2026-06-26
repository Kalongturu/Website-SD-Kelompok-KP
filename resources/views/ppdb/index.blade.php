@extends('layouts.app')

@section('title', 'PPDB')
@section('description',
    'Penerimaan Peserta Didik Baru (PPDB) SDN Dadapsari — pendaftaran siswa baru, panduan, dan daftar ulang.')

@push('styles')
    <style>
        .ppdb-wrap {
            max-width: 1080px;
            margin: -3rem auto 4rem;
            padding: 0 1.25rem;
        }

        .ppdb-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        /* ── KARTU POIN PPDB ── */
        .ppdb-card {
            background: var(--white);
            border: 1px solid #eef1f5;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.8rem 1.7rem;
            display: flex;
            flex-direction: column;
            gap: .9rem;
            border-top: 4px solid var(--accent);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .ppdb-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
        }

        .ppdb-card.featured {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            color: var(--white);
            border-top-color: var(--accent);
        }

        .ppdb-ico {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            font-size: 1.9rem;
            background: var(--accent-soft);
            flex-shrink: 0;
        }

        .ppdb-card.featured .ppdb-ico {
            background: rgba(255, 255, 255, .15);
        }

        .ppdb-card h3 {
            color: var(--primary-dark);
            font-size: 1.2rem;
        }

        .ppdb-card.featured h3 {
            color: var(--white);
        }

        .ppdb-card p {
            color: var(--muted);
            font-size: .92rem;
            flex: 1;
        }

        .ppdb-card.featured p {
            color: rgba(255, 255, 255, .85);
        }

        /* ── TOMBOL AKSI ── */
        .ppdb-btn {
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            border: none;
            cursor: pointer;
            font: inherit;
            font-weight: 700;
            font-size: .85rem;
            padding: .7rem 1.5rem;
            border-radius: 999px;
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .ppdb-btn-primary {
            background: var(--accent);
            color: var(--primary-dark);
        }

        .ppdb-btn-outline {
            background: var(--accent-soft);
            color: var(--primary);
        }

        .ppdb-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 43, 91, .2);
        }

        /* ── MODAL PANDUAN ── */
        .ppdb-modal {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
        }

        .ppdb-modal.open {
            display: flex;
        }

        .ppdb-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 43, 91, .55);
            backdrop-filter: blur(4px);
        }

        .ppdb-modal-dialog {
            position: relative;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: min(560px, 100%);
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transform: translateY(16px) scale(.98);
            opacity: 0;
            transition: transform .25s ease, opacity .25s ease;
        }

        .ppdb-modal.open .ppdb-modal-dialog {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .ppdb-modal-head {
            display: flex;
            align-items: center;
            gap: .9rem;
            padding: 1.4rem 1.7rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--white);
        }

        .ppdb-modal-head .ico {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .18);
            display: grid;
            place-items: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .ppdb-modal-head h2 {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .ppdb-modal-close {
            position: absolute;
            top: .9rem;
            right: .9rem;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, .9);
            color: var(--primary-dark);
            font-size: 1.3rem;
            line-height: 1;
            cursor: pointer;
            display: grid;
            place-items: center;
        }

        .ppdb-modal-body {
            padding: 1.6rem 1.8rem 2rem;
            overflow-y: auto;
        }

        .ppdb-steps {
            list-style: none;
            counter-reset: langkah;
            display: grid;
            gap: 1rem;
        }

        .ppdb-steps li {
            counter-increment: langkah;
            position: relative;
            padding-left: 2.6rem;
            font-size: .94rem;
            color: var(--text);
            line-height: 1.55;
        }

        .ppdb-steps li::before {
            content: counter(langkah);
            position: absolute;
            left: 0;
            top: -.1rem;
            width: 1.9rem;
            height: 1.9rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--white);
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: .85rem;
            font-weight: 700;
        }

        @media (max-width: 700px) {
            .ppdb-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ===================== HEADER ===================== --}}
    @include('partials.page-header', [
        'eyebrow' => 'Informasi',
        'title' => $judul,
        'subtitle' =>
            'Informasi lengkap seputar penerimaan peserta didik baru SDN Dadapsari, mulai dari pendaftaran hingga daftar ulang.',
    ])

    <div class="ppdb-wrap">

        {{-- Status PPDB — diatur lewat dashboard admin (PpdbSetting) --}}
        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:.75rem 1.25rem;justify-content:center;
                    background:var(--white);border:1px solid #eef1f5;border-left:4px solid {{ $ppdb->is_open ? '#16a34a' : '#dc2626' }};
                    border-radius:var(--radius);box-shadow:var(--shadow);padding:1rem 1.5rem;margin-bottom:2rem;">
            <span style="display:inline-flex;align-items:center;gap:.45rem;font-weight:700;font-size:.85rem;
                         color:{{ $ppdb->is_open ? '#15803d' : '#b91c1c' }};
                         background:{{ $ppdb->is_open ? '#dcfce7' : '#fee2e2' }};
                         padding:.35rem .9rem;border-radius:50px;">
                <span style="width:.5rem;height:.5rem;border-radius:50%;background:currentColor;"></span>
                {{ $ppdb->is_open ? 'Pendaftaran Dibuka' : 'Pendaftaran Ditutup' }}
            </span>
            <strong style="color:var(--primary-dark);font-size:.92rem;">Tahun Ajaran {{ $ppdb->tahun_ajaran }}</strong>
            @if ($ppdb->tanggal_buka || $ppdb->tanggal_tutup)
                <span style="color:var(--muted);font-size:.85rem;">
                    🗓️ Periode:
                    {{ $ppdb->tanggal_buka ? $ppdb->tanggal_buka->translatedFormat('d M Y') : '—' }}
                    s/d
                    {{ $ppdb->tanggal_tutup ? $ppdb->tanggal_tutup->translatedFormat('d M Y') : '—' }}
                </span>
            @endif
        </div>

        <div class="ppdb-grid">
            @foreach ($poin as $item)
                <article class="ppdb-card {{ $item['tipe'] === 'link' ? 'featured' : '' }}">
                    <div class="ppdb-ico">{{ $item['icon'] }}</div>
                    <h3>{{ $item['judul'] }}</h3>
                    <p>{{ $item['deskripsi'] }}</p>

                    @if ($item['tipe'] === 'link')
                        @php $bisaDaftar = $ppdb->is_open && !empty($item['link']) && $item['link'] !== '#'; @endphp
                        @if ($bisaDaftar)
                            <a class="ppdb-btn ppdb-btn-primary" href="{{ $item['link'] }}" target="_blank"
                                rel="noopener">{{ $item['cta'] }} →</a>
                        @else
                            <span class="ppdb-btn ppdb-btn-primary" aria-disabled="true"
                                  style="opacity:.55;cursor:not-allowed;"
                                  title="{{ $ppdb->is_open ? 'Tautan pendaftaran belum diatur admin' : 'Pendaftaran belum dibuka' }}">
                                {{ $ppdb->is_open ? 'Link Belum Tersedia' : 'Belum Dibuka' }}
                            </span>
                        @endif
                    @else
                        <button type="button" class="ppdb-btn ppdb-btn-outline" data-ppdb="{{ $item['key'] }}"
                            aria-haspopup="dialog">{{ $item['cta'] }}</button>
                    @endif
                </article>
            @endforeach
        </div>
    </div>

    {{-- ===================== MODAL PANDUAN ===================== --}}
    <div class="ppdb-modal" id="ppdbModal" role="dialog" aria-modal="true" aria-labelledby="ppdbModalTitle">
        <div class="ppdb-modal-overlay" data-close></div>
        <div class="ppdb-modal-dialog">
            <button type="button" class="ppdb-modal-close" data-close aria-label="Tutup">&times;</button>
            <div class="ppdb-modal-head">
                <span class="ico" id="ppdbModalIcon"></span>
                <h2 id="ppdbModalTitle"></h2>
            </div>
            <div class="ppdb-modal-body">
                <ol class="ppdb-steps" id="ppdbModalSteps"></ol>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            const DATA = @json(collect($poin)->keyBy('key'));

            const modal = document.getElementById('ppdbModal');
            if (!modal) return;

            const iconEl = document.getElementById('ppdbModalIcon');
            const titleEl = document.getElementById('ppdbModalTitle');
            const stepsEl = document.getElementById('ppdbModalSteps');

            function escapeHtml(str) {
                const div = document.createElement('div');
                div.textContent = str == null ? '' : String(str);
                return div.innerHTML;
            }

            function openModal(item) {
                iconEl.textContent = item.icon || '📋';
                titleEl.textContent = item.judul || '';
                stepsEl.innerHTML = (item.langkah || [])
                    .map(function (langkah) { return `<li>${escapeHtml(langkah)}</li>`; })
                    .join('');
                modal.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }

            document.querySelectorAll('[data-ppdb]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const item = DATA[btn.dataset.ppdb];
                    if (item) openModal(item);
                });
            });

            modal.querySelectorAll('[data-close]').forEach(function (el) {
                el.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
            });
        })();
    </script>
@endpush
