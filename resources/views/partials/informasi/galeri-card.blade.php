{{--
    Template kartu Galeri Foto.
    Pakai dengan: @include('partials.informasi.galeri-card', ['item' => $foto])
    $item adalah instance App\Models\Galeri. Kartu memicu lightbox lewat data-galeri.
--}}
@once
    @push('styles')
        <style>
            .galeri-card {
                position: relative;
                display: block;
                width: 100%;
                padding: 0;
                border: none;
                cursor: pointer;
                font: inherit;
                color: inherit;
                aspect-ratio: 4 / 3;
                border-radius: var(--radius);
                overflow: hidden;
                box-shadow: var(--shadow);
                background: var(--white);
                transition: transform .3s ease, box-shadow .3s ease;
            }

            .galeri-card:hover,
            .galeri-card:focus-visible {
                transform: translateY(-6px);
                box-shadow: var(--shadow-lg);
                outline: none;
            }

            .galeri-media {
                position: absolute;
                inset: 0;
                display: grid;
                place-items: center;
                font-size: 3rem;
            }

            .galeri-media img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform .4s ease;
            }

            .galeri-card:hover .galeri-media img {
                transform: scale(1.07);
            }

            /* Placeholder gradien bila foto belum ada */
            .galeri-media.ph0 { background: linear-gradient(135deg, var(--primary), var(--accent)); }
            .galeri-media.ph1 { background: linear-gradient(135deg, var(--primary-dark), var(--primary)); }
            .galeri-media.ph2 { background: linear-gradient(135deg, #2a8aa3, var(--accent)); }
            .galeri-media.ph3 { background: linear-gradient(135deg, #1a5f7a, #57c5b6); }

            .galeri-overlay {
                position: absolute;
                inset: 0;
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                gap: .3rem;
                padding: 1rem 1.1rem;
                background: linear-gradient(to top, rgba(0, 43, 91, .82) 0%, rgba(0, 43, 91, .25) 45%, transparent 75%);
                color: var(--white);
                text-align: left;
            }

            .galeri-badge {
                align-self: flex-start;
                background: rgba(255, 255, 255, .92);
                color: var(--primary-dark);
                font-size: .68rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .5px;
                padding: .2rem .6rem;
                border-radius: 50px;
            }

            .galeri-overlay h3 {
                font-size: 1rem;
                font-weight: 700;
                line-height: 1.3;
            }

            .galeri-zoom {
                position: absolute;
                top: .8rem;
                right: .8rem;
                width: 34px;
                height: 34px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .9);
                color: var(--primary-dark);
                display: grid;
                place-items: center;
                font-size: 1rem;
                opacity: 0;
                transform: scale(.8);
                transition: opacity .25s ease, transform .25s ease;
            }

            .galeri-card:hover .galeri-zoom,
            .galeri-card:focus-visible .galeri-zoom {
                opacity: 1;
                transform: scale(1);
            }
        </style>
    @endpush
@endonce

@php $gambarUrl = $item->gambarUrl(); @endphp
<button type="button" class="galeri-card" data-galeri="{{ $item->id }}" aria-haspopup="dialog">
    <span class="galeri-media {{ $gambarUrl ? '' : 'ph' . ($item->id % 4) }}">
        @if ($gambarUrl)
            <img src="{{ $gambarUrl }}" alt="{{ $item->judul }}" loading="lazy">
        @else
            <span>📷</span>
        @endif
    </span>
    <span class="galeri-zoom">🔍</span>
    <span class="galeri-overlay">
        @if ($item->kategori)
            <span class="galeri-badge">{{ $item->kategori }}</span>
        @endif
        <h3>{{ $item->judul }}</h3>
    </span>
</button>
