{{--
    Template kartu Berita.
    Pakai dengan: @include('partials.informasi.berita-card', ['item' => $berita])
    $item adalah instance App\Models\Berita. Kartu memicu modal lewat data-berita.
--}}
@once
    @push('styles')
        <style>
            .berita-card {
                background: var(--white);
                border: 1px solid #eef1f5;
                border-radius: var(--radius);
                box-shadow: var(--shadow);
                overflow: hidden;
                cursor: pointer;
                text-align: left;
                display: flex;
                flex-direction: column;
                width: 100%;
                padding: 0;
                font: inherit;
                color: inherit;
                transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
            }

            .berita-card:hover,
            .berita-card:focus-visible {
                transform: translateY(-8px);
                box-shadow: var(--shadow-lg);
                border-color: var(--accent);
                outline: none;
            }

            .berita-thumb {
                height: 175px;
                display: grid;
                place-items: center;
                font-size: 3rem;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                position: relative;
                flex-shrink: 0;
            }

            .berita-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .berita-badge {
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

            .berita-body {
                padding: 1.3rem 1.4rem 1.5rem;
                display: flex;
                flex-direction: column;
                gap: .5rem;
                flex: 1;
            }

            .berita-date {
                display: inline-flex;
                align-items: center;
                gap: .35rem;
                font-size: .8rem;
                color: var(--muted);
            }

            .berita-body h3 {
                color: var(--primary-dark);
                font-size: 1.12rem;
                line-height: 1.35;
            }

            .berita-body p {
                color: var(--muted);
                font-size: .9rem;
                flex: 1;
            }

            .berita-more {
                margin-top: .3rem;
                font-size: .82rem;
                font-weight: 600;
                color: var(--accent);
            }

            .berita-more::after {
                content: ' →';
            }
        </style>
    @endpush
@endonce

<button type="button" class="berita-card" data-berita="{{ $item->id }}" aria-haspopup="dialog">
    <div class="berita-thumb">
        @if ($item->gambar)
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}">
        @else
            <span>📰</span>
        @endif
        @if ($item->kategori)
            <span class="berita-badge">{{ $item->kategori }}</span>
        @endif
    </div>
    <div class="berita-body">
        @if ($item->tanggal)
            <span class="berita-date">🗓️ {{ $item->tanggal->translatedFormat('d M Y') }}</span>
        @endif
        <h3>{{ $item->judul }}</h3>
        <p>{{ $item->preview() }}</p>
        <span class="berita-more">Baca selengkapnya</span>
    </div>
</button>
