{{--
    Template item Pengumuman (daftar).
    Pakai dengan: @include('partials.informasi.pengumuman-item', ['item' => $pengumuman])
    $item adalah instance App\Models\Pengumuman. Item memicu modal lewat data-peng.
--}}
@once
    @push('styles')
        <style>
            .peng-item {
                display: flex;
                align-items: flex-start;
                gap: 1rem;
                width: 100%;
                text-align: left;
                background: var(--white);
                border: none;
                border-bottom: 1px solid rgba(0, 43, 91, .07);
                padding: 1.1rem 1.4rem;
                cursor: pointer;
                font: inherit;
                color: inherit;
                transition: background .2s ease;
            }

            .peng-item:last-child {
                border-bottom: none;
            }

            .peng-item:hover,
            .peng-item:focus-visible {
                background: var(--accent-soft);
                outline: none;
            }

            .peng-date {
                flex-shrink: 0;
                width: 58px;
                text-align: center;
                background: linear-gradient(135deg, var(--primary), var(--accent));
                color: var(--white);
                border-radius: 12px;
                padding: .5rem .3rem;
                line-height: 1.1;
            }

            .peng-date .d {
                display: block;
                font-size: 1.25rem;
                font-weight: 800;
            }

            .peng-date .m {
                display: block;
                font-size: .68rem;
                text-transform: uppercase;
                letter-spacing: .5px;
            }

            .peng-info {
                flex: 1;
                min-width: 0;
                display: flex;
                flex-direction: column;
                gap: .25rem;
            }

            .peng-info h3 {
                color: var(--primary-dark);
                font-size: 1rem;
                line-height: 1.4;
                display: flex;
                align-items: center;
                gap: .5rem;
                flex-wrap: wrap;
            }

            .peng-badge-penting {
                font-size: .65rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .5px;
                color: #b42318;
                background: #fee4e2;
                padding: .15rem .5rem;
                border-radius: 50px;
            }

            .peng-info p {
                color: var(--muted);
                font-size: .86rem;
            }

            .peng-more {
                font-size: .78rem;
                font-weight: 600;
                color: var(--accent);
            }

            .peng-more::after {
                content: ' →';
            }
        </style>
    @endpush
@endonce

<button type="button" class="peng-item" data-peng="{{ $item->id }}" aria-haspopup="dialog">
    <span class="peng-date">
        <span class="d">{{ $item->tanggal ? $item->tanggal->translatedFormat('d') : '—' }}</span>
        <span class="m">{{ $item->tanggal ? $item->tanggal->translatedFormat('M') : '' }}</span>
    </span>
    <span class="peng-info">
        <h3>
            {{ $item->judul }}
            @if ($item->penting)
                <span class="peng-badge-penting">Penting</span>
            @endif
        </h3>
        <p>{{ $item->preview() }}</p>
        <span class="peng-more">Lihat selengkapnya</span>
    </span>
</button>
