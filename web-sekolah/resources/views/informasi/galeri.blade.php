@extends('layouts.app')

@section('title', 'Galeri Foto')
@section('description',
    'Galeri foto kegiatan, prestasi, dan suasana SDN Dadapsari. Klik foto untuk melihat keterangannya.')

@push('styles')
    <style>
        .galeri-wrap {
            max-width: 1200px;
            margin: -3rem auto 4rem;
            padding: 0 1.25rem;
        }

        /* ── PANEL FILTER ── */
        .galeri-panel {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.1rem 1.4rem;
            margin-bottom: 1.75rem;
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .galeri-tab {
            border: 1.5px solid #e2e8f0;
            background: var(--white);
            color: var(--text);
            font-size: .85rem;
            font-weight: 600;
            padding: .45rem 1rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all .2s ease;
        }

        .galeri-tab:hover {
            border-color: var(--accent);
            color: var(--primary);
        }

        .galeri-tab.active {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-color: transparent;
            color: var(--white);
        }

        /* ── GRID FOTO ── */
        .galeri-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.25rem;
        }

        /* ── EMPTY / NO RESULT ── */
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

        /* ── LIGHTBOX MODAL ── */
        .galeri-modal {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
        }

        .galeri-modal.open {
            display: flex;
        }

        .galeri-modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(40, 40, 40, .65);
            backdrop-filter: blur(4px);
        }

        .galeri-modal-dialog {
            position: relative;
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: min(760px, 100%);
            max-height: 92vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transform: translateY(16px) scale(.98);
            opacity: 0;
            transition: transform .25s ease, opacity .25s ease;
        }

        .galeri-modal.open .galeri-modal-dialog {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .galeri-modal-media {
            position: relative;
            background: var(--primary-dark);
            display: grid;
            place-items: center;
            min-height: 240px;
            max-height: 58vh;
            font-size: 4rem;
            color: rgba(255, 255, 255, .85);
            overflow: hidden;
        }

        .galeri-modal-media img {
            width: 100%;
            max-height: 58vh;
            object-fit: contain;
        }

        /* Placeholder emoji saat album tanpa foto */
        .galeri-modal-ph { grid-area: 1 / 1; }

        /* ── Tombol navigasi carousel ── */
        .galeri-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            border: none;
            border-radius: 50%;
            background: rgba(40, 40, 40, .55);
            color: #fff;
            font-size: 1.2rem;
            line-height: 1;
            cursor: pointer;
            display: grid;
            place-items: center;
            z-index: 2;
            transition: background .2s ease, transform .15s ease;
        }

        .galeri-nav:hover { background: rgba(40, 40, 40, .8); }
        .galeri-nav:active { transform: translateY(-50%) scale(.92); }
        .galeri-nav-prev { left: .75rem; }
        .galeri-nav-next { right: .75rem; }

        .galeri-counter {
            position: absolute;
            bottom: .7rem;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(40, 40, 40, .6);
            color: #fff;
            font-size: .78rem;
            font-weight: 600;
            padding: .2rem .8rem;
            border-radius: 50px;
            z-index: 2;
        }

        @media (max-width: 700px) {
            .galeri-nav { width: 38px; height: 38px; font-size: 1rem; }
        }

        .galeri-modal-close {
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
            z-index: 1;
            transition: background .2s ease;
        }

        .galeri-modal-close:hover {
            background: var(--white);
        }

        .galeri-modal-content {
            padding: 1.4rem 1.7rem 1.8rem;
            overflow-y: auto;
        }

        .galeri-modal-badge {
            display: inline-block;
            background: var(--accent-soft);
            color: var(--primary);
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: .25rem .8rem;
            border-radius: 50px;
            margin-bottom: .55rem;
        }

        .galeri-modal-content h2 {
            color: var(--primary-dark);
            font-size: 1.4rem;
            line-height: 1.3;
            margin-bottom: .4rem;
        }

        .galeri-modal-date {
            font-size: .85rem;
            color: var(--muted);
            margin-bottom: .9rem;
            display: flex;
            align-items: center;
            gap: .35rem;
        }

        .galeri-modal-desc {
            color: var(--text);
            font-size: .95rem;
            line-height: 1.7;
            white-space: pre-line;
        }

        @media (max-width: 992px) {
            .galeri-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 700px) {
            .galeri-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endpush

@section('content')

    {{-- ===================== HEADER ===================== --}}
    @include('partials.page-header', [
        'eyebrow' => 'Informasi',
        'title' => 'Galeri Foto',
        'subtitle' =>
            'Dokumentasi kegiatan, prestasi, dan suasana keseharian di SDN Dadapsari. Klik salah satu foto untuk melihat keterangannya.',
    ])

    <div class="galeri-wrap">
        @if ($galeri->isEmpty() && !request()->filled('kategori'))
            <div class="empty-state">
                <div class="empty-icon">📷</div>
                <h3>Belum ada foto</h3>
                <p>Foto galeri akan tampil di sini setelah ditambahkan oleh admin.</p>
            </div>
        @else
            {{-- ===================== PANEL FILTER ===================== --}}
            @if ($kategori->isNotEmpty())
                <div class="galeri-panel">
                    <a class="galeri-tab {{ !request()->filled('kategori') || request('kategori') === 'all' ? 'active' : '' }}"
                        href="{{ route('informasi.galeri') }}">Semua</a>
                    @foreach ($kategori as $kat)
                        <a class="galeri-tab {{ request('kategori') === $kat ? 'active' : '' }}"
                            href="{{ route('informasi.galeri', ['kategori' => $kat]) }}">{{ $kat }}</a>
                    @endforeach
                </div>
            @endif

            {{-- ===================== GRID FOTO ===================== --}}
            @if ($galeri->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">🔎</div>
                    <h3>Tidak ada foto pada kategori ini</h3>
                    <p>Coba pilih kategori lain.</p>
                </div>
            @else
                <div class="galeri-grid">
                    @foreach ($galeri as $item)
                        @include('partials.informasi.galeri-card', ['item' => $item])
                    @endforeach
                </div>

                {{ $galeri->links('partials.pagination') }}
            @endif
        @endif
    </div>

    {{-- ===================== LIGHTBOX MODAL ===================== --}}
    <div class="galeri-modal" id="galeriModal" role="dialog" aria-modal="true" aria-labelledby="galeriModalTitle">
        <div class="galeri-modal-overlay" data-close></div>
        <div class="galeri-modal-dialog">
            <button type="button" class="galeri-modal-close" data-close aria-label="Tutup">&times;</button>
            <div class="galeri-modal-media" id="galeriModalMedia">
                <span class="galeri-modal-ph">📷</span>
                <button type="button" class="galeri-nav galeri-nav-prev" id="galeriPrev" aria-label="Foto sebelumnya" hidden>&#10094;</button>
                <button type="button" class="galeri-nav galeri-nav-next" id="galeriNext" aria-label="Foto berikutnya" hidden>&#10095;</button>
                <span class="galeri-counter" id="galeriCounter" hidden></span>
            </div>
            <div class="galeri-modal-content">
                <span class="galeri-modal-badge" id="galeriModalBadge" hidden></span>
                <h2 id="galeriModalTitle"></h2>
                <p class="galeri-modal-date" id="galeriModalDate" hidden></p>
                <p class="galeri-modal-desc" id="galeriModalDesc"></p>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        (function () {
            @php
                $galeriData = $galeri->getCollection()->keyBy('id')->map(fn ($g) => [
                    'judul'      => $g->judul,
                    'kategori'   => $g->kategori,
                    'keterangan' => $g->keterangan,
                    'tanggal'    => optional($g->tanggal)->toDateString(),
                    'fotos'      => $g->fotoUrls(),
                ]);
            @endphp
            const DATA = @json($galeriData);

            const modal = document.getElementById('galeriModal');
            if (!modal) return;

            const mediaEl = document.getElementById('galeriModalMedia');
            const badgeEl = document.getElementById('galeriModalBadge');
            const titleEl = document.getElementById('galeriModalTitle');
            const dateEl = document.getElementById('galeriModalDate');
            const descEl = document.getElementById('galeriModalDesc');
            const prevBtn = document.getElementById('galeriPrev');
            const nextBtn = document.getElementById('galeriNext');
            const counterEl = document.getElementById('galeriCounter');
            const phEl = mediaEl.querySelector('.galeri-modal-ph');

            let fotos = [];      // URL foto album yang sedang dibuka
            let idx = 0;         // indeks foto aktif
            let imgEl = null;    // <img> tunggal yang di-reuse untuk menampilkan foto

            function escapeHtml(str) {
                const div = document.createElement('div');
                div.textContent = str == null ? '' : String(str);
                return div.innerHTML;
            }

            function formatTanggal(value) {
                if (!value) return '';
                const d = new Date(value);
                if (isNaN(d)) return '';
                return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            }

            function renderFoto() {
                const hasFoto = fotos.length > 0;
                phEl.style.display = hasFoto ? 'none' : '';

                if (hasFoto) {
                    if (!imgEl) {
                        imgEl = document.createElement('img');
                        mediaEl.insertBefore(imgEl, prevBtn);
                    }
                    imgEl.src = fotos[idx];
                    imgEl.alt = titleEl.textContent || '';
                } else if (imgEl) {
                    imgEl.remove();
                    imgEl = null;
                }

                // Panah & penghitung hanya relevan bila album punya >1 foto.
                const multi = fotos.length > 1;
                prevBtn.hidden = !multi;
                nextBtn.hidden = !multi;
                counterEl.hidden = !multi;
                if (multi) counterEl.textContent = (idx + 1) + ' / ' + fotos.length;
            }

            function showFoto(n) {
                if (fotos.length === 0) return;
                idx = (n + fotos.length) % fotos.length; // berputar (wrap-around)
                renderFoto();
            }

            function openModal(item) {
                fotos = Array.isArray(item.fotos) ? item.fotos.filter(Boolean) : [];
                idx = 0;

                titleEl.textContent = item.judul || '';

                badgeEl.textContent = item.kategori || '';
                badgeEl.hidden = !item.kategori;

                const tgl = formatTanggal(item.tanggal);
                if (tgl) {
                    dateEl.innerHTML = '🗓️ ' + escapeHtml(tgl);
                    dateEl.hidden = false;
                } else {
                    dateEl.hidden = true;
                }

                descEl.textContent = item.keterangan || 'Belum ada keterangan untuk foto ini.';

                renderFoto();

                modal.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }

            document.querySelectorAll('.galeri-card').forEach(function (card) {
                card.addEventListener('click', function () {
                    const item = DATA[card.dataset.galeri];
                    if (item) openModal(item);
                });
            });

            prevBtn.addEventListener('click', function (e) { e.stopPropagation(); showFoto(idx - 1); });
            nextBtn.addEventListener('click', function (e) { e.stopPropagation(); showFoto(idx + 1); });

            modal.querySelectorAll('[data-close]').forEach(function (el) {
                el.addEventListener('click', closeModal);
            });

            document.addEventListener('keydown', function (e) {
                if (!modal.classList.contains('open')) return;
                if (e.key === 'Escape') closeModal();
                else if (e.key === 'ArrowLeft') showFoto(idx - 1);
                else if (e.key === 'ArrowRight') showFoto(idx + 1);
            });

            // Geser (swipe) di layar sentuh untuk pindah foto.
            let touchX = null;
            mediaEl.addEventListener('touchstart', function (e) { touchX = e.changedTouches[0].clientX; }, { passive: true });
            mediaEl.addEventListener('touchend', function (e) {
                if (touchX === null || fotos.length < 2) { touchX = null; return; }
                const dx = e.changedTouches[0].clientX - touchX;
                if (Math.abs(dx) > 40) showFoto(dx < 0 ? idx + 1 : idx - 1);
                touchX = null;
            }, { passive: true });

        })();
    </script>
@endpush
