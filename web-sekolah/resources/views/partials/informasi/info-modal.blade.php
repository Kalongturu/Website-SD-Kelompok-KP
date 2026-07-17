{{--
    Template modal Informasi (dipakai bersama oleh berita & pengumuman).
    Pakai dengan: @include('partials.informasi.info-modal')
    Konten diisi lewat JavaScript (lihat informasi/index.blade.php).
--}}
@once
    @push('styles')
        <style>
            .info-modal {
                position: fixed;
                inset: 0;
                z-index: 2000;
                display: none;
                align-items: center;
                justify-content: center;
                padding: 1.25rem;
            }

            .info-modal.open {
                display: flex;
            }

            .info-modal-overlay {
                position: absolute;
                inset: 0;
                background: rgba(40, 40, 40, .55);
                backdrop-filter: blur(4px);
            }

            .info-modal-dialog {
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

            .info-modal.open .info-modal-dialog {
                transform: translateY(0) scale(1);
                opacity: 1;
            }

            .info-modal-hero {
                height: 200px;
                display: grid;
                /* Baris grid default berukuran `auto` = mengikuti isi. Gambar
                   selebar wadah (width:100%) yang rasionya persegi jadi setinggi
                   itu pula (mis. 640px), barisnya ikut membengkak, dan height:200px
                   di sini TIDAK mengekangnya — gambar meluber menutupi teks.
                   minmax(0, 1fr) memaksa baris ikut tinggi wadah, bukan isi. */
                grid-template-rows: minmax(0, 1fr);
                place-items: center;
                font-size: 3.4rem;
                background: linear-gradient(135deg, var(--primary-dark), var(--accent));
                flex-shrink: 0;
                overflow: hidden;
            }

            .info-modal-hero img {
                align-self: stretch;
                justify-self: stretch;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .info-modal-close {
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
                z-index: 1;
            }

            .info-modal-close:hover {
                background: var(--white);
            }

            .info-modal-content {
                padding: 1.6rem 1.8rem 2rem;
                overflow-y: auto;
            }

            .info-modal-badge {
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

            .info-modal-content h2 {
                color: var(--primary-dark);
                font-size: 1.5rem;
                line-height: 1.3;
                margin-bottom: .6rem;
            }

            .info-modal-meta {
                display: flex;
                flex-wrap: wrap;
                gap: .4rem 1.1rem;
                margin-bottom: 1.1rem;
                font-size: .85rem;
                color: var(--muted);
            }

            .info-modal-meta span {
                display: inline-flex;
                align-items: center;
                gap: .35rem;
            }

            .info-modal-body {
                color: var(--text);
                font-size: .95rem;
                line-height: 1.7;
                white-space: pre-line;
            }

            .info-modal-foot {
                margin-top: 1.3rem;
            }

            .info-modal-foot a {
                display: inline-flex;
                align-items: center;
                gap: .4rem;
                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                color: var(--white);
                font-weight: 700;
                font-size: .85rem;
                padding: .65rem 1.4rem;
                border-radius: 999px;
                transition: transform .15s ease, box-shadow .15s ease;
            }

            .info-modal-foot a:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(40, 40, 40, .25);
            }
        </style>
    @endpush
@endonce

<div class="info-modal" id="infoModal" role="dialog" aria-modal="true" aria-labelledby="infoModalTitle">
    <div class="info-modal-overlay" data-close></div>
    <div class="info-modal-dialog">
        <button type="button" class="info-modal-close" data-close aria-label="Tutup">&times;</button>
        <div class="info-modal-hero" id="infoModalHero" hidden><span></span></div>
        <div class="info-modal-content">
            <span class="info-modal-badge" id="infoModalBadge" hidden></span>
            <h2 id="infoModalTitle"></h2>
            <div class="info-modal-meta" id="infoModalMeta"></div>
            <div class="info-modal-body" id="infoModalBody"></div>
            <div class="info-modal-foot" id="infoModalFoot" hidden></div>
        </div>
    </div>
</div>
