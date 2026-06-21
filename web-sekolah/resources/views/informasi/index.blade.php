@extends('layouts.app')

@section('title', 'Berita & Pengumuman')
@section('description',
    'Berita kegiatan dan pengumuman resmi SDN Dadapsari. Klik untuk membaca informasi selengkapnya.')

@push('styles')
    <style>
        .info-wrap {
            max-width: 1200px;
            margin: -3rem auto 4rem;
            padding: 0 1.25rem;
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 2rem;
            align-items: start;
        }

        .info-section-head {
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: 1.1rem;
        }

        .info-section-head h2 {
            color: var(--primary-dark);
            font-size: 1.35rem;
            font-weight: 700;
        }

        .info-section-head .line {
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, var(--accent), transparent);
            border-radius: 2px;
        }

        /* ── KOLOM BERITA ── */
        .berita-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        /* ── KOLOM PENGUMUMAN ── */
        .peng-panel {
            background: var(--white);
            border: 1px solid #eef1f5;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            position: sticky;
            top: 90px;
        }

        .peng-panel-head {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: 1.1rem 1.4rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--white);
        }

        .peng-panel-head .ico {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .18);
            display: grid;
            place-items: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .peng-panel-head h2 {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .peng-list {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            background: var(--white);
            border: 1.5px dashed #cbd5e1;
            border-radius: var(--radius);
            padding: 3rem 1.5rem;
            text-align: center;
            color: var(--muted);
        }

        .empty-state .empty-icon {
            font-size: 2.6rem;
            margin-bottom: .5rem;
        }

        .empty-state h3 {
            color: var(--primary-dark);
            margin-bottom: .3rem;
            font-size: 1.05rem;
        }

        .empty-state.compact {
            padding: 2.2rem 1.2rem;
            border-radius: 0;
            border: none;
        }

        @media (max-width: 960px) {
            .info-wrap {
                grid-template-columns: 1fr;
            }

            .peng-panel {
                position: static;
            }
        }

        @media (max-width: 600px) {
            .berita-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ===================== HEADER ===================== --}}
    @include('partials.page-header', [
        'eyebrow' => 'Informasi',
        'title' => 'Berita &amp; Pengumuman',
        'subtitle' =>
            'Kabar terbaru seputar kegiatan, prestasi, dan pengumuman resmi SDN Dadapsari. Klik salah satu item untuk membaca keterangan selengkapnya.',
    ])

    <div class="info-wrap">

        {{-- ===================== BERITA (KARTU) ===================== --}}
        <section>
            <div class="info-section-head">
                <h2>📰 Berita Terbaru</h2>
                <span class="line"></span>
            </div>

            @if ($berita->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📰</div>
                    <h3>Belum ada berita</h3>
                    <p>Berita sekolah akan tampil di sini setelah ditambahkan oleh admin.</p>
                </div>
            @else
                <div class="berita-grid">
                    @foreach ($berita as $item)
                        @include('partials.informasi.berita-card', ['item' => $item])
                    @endforeach
                </div>

                {{ $berita->links('partials.pagination') }}
            @endif
        </section>

        {{-- ===================== PENGUMUMAN (DAFTAR/MODAL) ===================== --}}
        <aside>
            <div class="peng-panel">
                <div class="peng-panel-head">
                    <span class="ico">📢</span>
                    <h2>Pengumuman</h2>
                </div>
                <div class="peng-list">
                    @forelse ($pengumuman as $item)
                        @include('partials.informasi.pengumuman-item', ['item' => $item])
                    @empty
                        <div class="empty-state compact">
                            <div class="empty-icon">📢</div>
                            <h3>Belum ada pengumuman</h3>
                            <p>Pengumuman resmi akan tampil di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </aside>

    </div>

    {{-- ===================== MODAL (TEMPLATE BERSAMA) ===================== --}}
    @include('partials.informasi.info-modal')

@endsection

@push('scripts')
    <script>
        (function () {
            const BERITA = @json($berita->getCollection()->keyBy('id'));
            const PENGUMUMAN = @json($pengumuman->keyBy('id'));

            const modal = document.getElementById('infoModal');
            if (!modal) return;

            const heroEl = document.getElementById('infoModalHero');
            const badgeEl = document.getElementById('infoModalBadge');
            const titleEl = document.getElementById('infoModalTitle');
            const metaEl = document.getElementById('infoModalMeta');
            const bodyEl = document.getElementById('infoModalBody');
            const footEl = document.getElementById('infoModalFoot');

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

            function metaChip(icon, value) {
                if (!value) return '';
                return `<span>${icon} ${escapeHtml(value)}</span>`;
            }

            function openBerita(item) {
                if (item.gambar) {
                    heroEl.innerHTML = `<img src="/storage/${escapeHtml(item.gambar)}" alt="${escapeHtml(item.judul)}">`;
                } else {
                    heroEl.innerHTML = '<span>📰</span>';
                }
                heroEl.hidden = false;

                badgeEl.textContent = item.kategori || '';
                badgeEl.hidden = !item.kategori;

                titleEl.textContent = item.judul || '';

                metaEl.innerHTML =
                    metaChip('🗓️', formatTanggal(item.tanggal)) +
                    metaChip('✍️', item.penulis);

                bodyEl.textContent = item.isi || item.ringkasan || 'Belum ada keterangan untuk berita ini.';

                footEl.hidden = true;
                footEl.innerHTML = '';

                showModal();
            }

            function openPengumuman(item) {
                heroEl.hidden = true;
                heroEl.innerHTML = '';

                badgeEl.textContent = item.penting ? 'Pengumuman Penting' : 'Pengumuman';
                badgeEl.hidden = false;

                titleEl.textContent = item.judul || '';

                metaEl.innerHTML = metaChip('🗓️', formatTanggal(item.tanggal));

                bodyEl.textContent = item.isi || item.ringkasan || 'Belum ada keterangan untuk pengumuman ini.';

                if (item.lampiran) {
                    footEl.innerHTML = `<a href="/storage/${escapeHtml(item.lampiran)}" target="_blank" rel="noopener">📎 Unduh Lampiran</a>`;
                    footEl.hidden = false;
                } else {
                    footEl.hidden = true;
                    footEl.innerHTML = '';
                }

                showModal();
            }

            function showModal() {
                modal.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }

            document.querySelectorAll('.berita-card').forEach(function (card) {
                card.addEventListener('click', function () {
                    const item = BERITA[card.dataset.berita];
                    if (item) openBerita(item);
                });
            });

            document.querySelectorAll('.peng-item').forEach(function (el) {
                el.addEventListener('click', function () {
                    const item = PENGUMUMAN[el.dataset.peng];
                    if (item) openPengumuman(item);
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
