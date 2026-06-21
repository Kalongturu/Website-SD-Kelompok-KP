@extends('layouts.app')

@section('title', 'Ekstrakurikuler')
@section('description',
    'Daftar kegiatan ekstrakurikuler SDN Dadapsari untuk menyalurkan minat dan bakat siswa.')

@push('styles')
    <style>
        .page-header {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, #2a8aa3 100%);
            color: var(--white);
            padding: 3.5rem 1.5rem 5rem;
            text-align: center;
        }

        .page-header .eyebrow {
            color: var(--accent);
        }

        .page-header h1 {
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            font-weight: 800;
            margin: .4rem 0 .6rem;
        }

        .page-header p {
            max-width: 640px;
            margin: 0 auto;
            color: rgba(255, 255, 255, .8);
        }

        .ekskul-wrap {
            max-width: 1200px;
            margin: -3rem auto 4rem;
            padding: 0 1.25rem;
        }

        .ekskul-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        /* ── KARTU EKSTRAKURIKULER ── */
        .ekskul-card {
            background: var(--white);
            border: 1px solid #eef1f5;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            cursor: pointer;
            text-align: left;
            display: flex;
            flex-direction: column;
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        .ekskul-card:hover,
        .ekskul-card:focus-visible {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
            outline: none;
        }

        .ekskul-thumb {
            height: 160px;
            display: grid;
            place-items: center;
            font-size: 3.2rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            position: relative;
        }

        .ekskul-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .ekskul-badge {
            position: absolute;
            top: .8rem;
            left: .8rem;
            background: rgba(255, 255, 255, .92);
            color: var(--primary-dark);
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: .25rem .7rem;
            border-radius: 50px;
        }

        .ekskul-body {
            padding: 1.3rem 1.4rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: .5rem;
            flex: 1;
        }

        .ekskul-body h3 {
            color: var(--primary-dark);
            font-size: 1.15rem;
        }

        .ekskul-body p {
            color: var(--muted);
            font-size: .9rem;
            flex: 1;
        }

        .ekskul-meta {
            display: flex;
            align-items: center;
            gap: .4rem;
            font-size: .82rem;
            color: var(--primary);
            font-weight: 600;
        }

        .ekskul-more {
            margin-top: .4rem;
            font-size: .82rem;
            font-weight: 600;
            color: var(--accent);
        }

        .ekskul-more::after {
            content: ' →';
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            background: var(--white);
            border: 1.5px dashed #cbd5e1;
            border-radius: var(--radius);
            padding: 3.5rem 1.5rem;
            text-align: center;
            color: var(--muted);
        }

        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: .6rem;
        }

        .empty-state h3 {
            color: var(--primary-dark);
            margin-bottom: .3rem;
        }

        /* ── MODAL DETAIL ── */
        .ekskul-modal {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
        }

        .ekskul-modal.open {
            display: flex;
        }

        .ekskul-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 43, 91, .55);
            backdrop-filter: blur(4px);
        }

        .ekskul-modal-dialog {
            position: relative;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: min(640px, 100%);
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transform: translateY(16px) scale(.98);
            opacity: 0;
            transition: transform .25s ease, opacity .25s ease;
        }

        .ekskul-modal.open .ekskul-modal-dialog {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .ekskul-modal-hero {
            height: 150px;
            display: grid;
            place-items: center;
            font-size: 3.4rem;
            background: linear-gradient(135deg, var(--primary-dark), var(--accent));
            flex-shrink: 0;
        }

        .ekskul-modal-close {
            position: absolute;
            top: .8rem;
            right: .8rem;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, .9);
            color: var(--primary-dark);
            font-size: 1.3rem;
            line-height: 1;
            cursor: pointer;
            display: grid;
            place-items: center;
            transition: background .2s ease;
        }

        .ekskul-modal-close:hover {
            background: var(--white);
        }

        .ekskul-modal-content {
            padding: 1.6rem 1.8rem 2rem;
            overflow-y: auto;
        }

        .ekskul-modal-content .badge-kategori {
            display: inline-block;
            background: var(--accent-soft);
            color: var(--primary);
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: .25rem .8rem;
            border-radius: 50px;
            margin-bottom: .6rem;
        }

        .ekskul-modal-content h2 {
            color: var(--primary-dark);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .ekskul-info-list {
            list-style: none;
            display: grid;
            gap: .7rem;
            margin-bottom: 1.2rem;
            padding: 1rem 1.1rem;
            background: var(--bg);
            border-radius: 12px;
        }

        .ekskul-info-list li {
            display: flex;
            gap: .7rem;
            align-items: flex-start;
            font-size: .92rem;
        }

        .ekskul-info-list .ico {
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .ekskul-info-list .lbl {
            color: var(--muted);
            min-width: 78px;
            flex-shrink: 0;
        }

        .ekskul-info-list .val {
            color: var(--text);
            font-weight: 600;
        }

        .ekskul-desc {
            color: var(--text);
            font-size: .95rem;
            white-space: pre-line;
        }

        @media (max-width: 992px) {
            .ekskul-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .ekskul-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ===================== HEADER ===================== --}}
    <section class="page-header">
        <span class="eyebrow">Kesiswaan</span>
        <h1>Ekstrakurikuler</h1>
        <p>Wadah pengembangan minat, bakat, dan karakter siswa SDN Dadapsari. Klik salah satu kegiatan untuk melihat
            keterangan lebih lengkap.</p>
    </section>

    {{-- ===================== DAFTAR EKSTRAKURIKULER ===================== --}}
    <div class="ekskul-wrap">
        @if ($ekstrakurikuler->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">⚽</div>
                <h3>Belum ada data ekstrakurikuler</h3>
                <p>Data ekstrakurikuler akan tampil di sini setelah ditambahkan oleh admin.</p>
            </div>
        @else
            <div class="ekskul-grid">
                @foreach ($ekstrakurikuler as $item)
                    <button type="button" class="ekskul-card" data-ekskul="{{ $item->id }}"
                        aria-haspopup="dialog">
                        <div class="ekskul-thumb">
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}">
                            @else
                                <span>{{ $item->icon ?: '🎯' }}</span>
                            @endif
                            @if ($item->kategori)
                                <span class="ekskul-badge">{{ $item->kategori }}</span>
                            @endif
                        </div>
                        <div class="ekskul-body">
                            <h3>{{ $item->nama }}</h3>
                            <p>{{ $item->deskripsi_singkat ?: \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 90) }}</p>
                            @if ($item->jadwal)
                                <span class="ekskul-meta">🗓️ {{ $item->jadwal }}</span>
                            @endif
                            <span class="ekskul-more">Lihat detail</span>
                        </div>
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ===================== MODAL DETAIL ===================== --}}
    <div class="ekskul-modal" id="ekskulModal" role="dialog" aria-modal="true" aria-labelledby="ekskulModalTitle">
        <div class="ekskul-modal-overlay" data-close></div>
        <div class="ekskul-modal-dialog">
            <button type="button" class="ekskul-modal-close" data-close aria-label="Tutup">&times;</button>
            <div class="ekskul-modal-hero" id="ekskulModalHero"><span></span></div>
            <div class="ekskul-modal-content">
                <span class="badge-kategori" id="ekskulModalKategori"></span>
                <h2 id="ekskulModalTitle"></h2>
                <ul class="ekskul-info-list" id="ekskulModalInfo"></ul>
                <p class="ekskul-desc" id="ekskulModalDesc"></p>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            const DATA = @json($ekstrakurikuler->keyBy('id'));

            const modal = document.getElementById('ekskulModal');
            if (!modal) return;

            const heroEl = document.getElementById('ekskulModalHero');
            const kategoriEl = document.getElementById('ekskulModalKategori');
            const titleEl = document.getElementById('ekskulModalTitle');
            const infoEl = document.getElementById('ekskulModalInfo');
            const descEl = document.getElementById('ekskulModalDesc');

            function escapeHtml(str) {
                const div = document.createElement('div');
                div.textContent = str == null ? '' : String(str);
                return div.innerHTML;
            }

            function infoRow(icon, label, value) {
                if (!value) return '';
                return `<li><span class="ico">${icon}</span><span class="lbl">${label}</span>` +
                    `<span class="val">${escapeHtml(value)}</span></li>`;
            }

            function openModal(item) {
                // Hero: gambar bila ada, jika tidak gunakan ikon/emoji.
                if (item.foto) {
                    heroEl.innerHTML = `<img src="/storage/${escapeHtml(item.foto)}" alt="${escapeHtml(item.nama)}" ` +
                        `style="width:100%;height:100%;object-fit:cover;">`;
                } else {
                    heroEl.innerHTML = `<span>${escapeHtml(item.icon || '🎯')}</span>`;
                }

                kategoriEl.textContent = item.kategori || '';
                kategoriEl.style.display = item.kategori ? '' : 'none';
                titleEl.textContent = item.nama || '';

                infoEl.innerHTML =
                    infoRow('🗓️', 'Jadwal', item.jadwal) +
                    infoRow('📍', 'Lokasi', item.lokasi) +
                    infoRow('👤', 'Pembina', item.pembina);
                infoEl.style.display = infoEl.innerHTML ? '' : 'none';

                descEl.textContent = item.deskripsi || 'Belum ada keterangan rinci untuk kegiatan ini.';

                modal.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }

            document.querySelectorAll('.ekskul-card').forEach(function (card) {
                card.addEventListener('click', function () {
                    const item = DATA[card.dataset.ekskul];
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
