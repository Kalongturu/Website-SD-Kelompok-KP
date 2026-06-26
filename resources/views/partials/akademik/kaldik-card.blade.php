{{--
    Template kartu Kalender Akademik.
    Pakai dengan: @include('partials.akademik.kaldik-card', ['judulKaldik' => '...', 'kaldik' => [...]])
    Setiap item: ['judul' => '...', 'link' => '...']
--}}
@once
    @push('styles')
        <style>
            .content-wrap {
                max-width: 980px;
                margin: -3rem auto 4rem;
                padding: 0 1.25rem;
            }

            .content-card {
                background: var(--white);
                border-radius: var(--radius);
                box-shadow: var(--shadow-lg);
                overflow: hidden;
            }

            .content-card-head {
                background: var(--accent-soft);
                color: var(--primary);
                font-weight: 700;
                letter-spacing: .5px;
                text-transform: uppercase;
                font-size: .9rem;
                text-align: center;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid rgba(0, 43, 91, .06);
            }

            .kaldik-list {
                list-style: none;
                margin: 0;
                padding: 1.5rem;
                display: grid;
                gap: 1.25rem;
            }

            .kaldik-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                flex-wrap: wrap;
                padding-bottom: 1.25rem;
                border-bottom: 1px solid rgba(0, 43, 91, .06);
            }

            .kaldik-item:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }

            .kaldik-item span {
                font-weight: 600;
                color: var(--text);
            }

            .kaldik-btn {
                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                color: var(--white);
                font-weight: 700;
                font-size: .8rem;
                letter-spacing: .5px;
                text-transform: uppercase;
                text-decoration: none;
                padding: .6rem 1.4rem;
                border-radius: 999px;
                transition: transform .15s ease, box-shadow .15s ease;
                white-space: nowrap;
            }

            .kaldik-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0, 43, 91, .25);
            }
        </style>
    @endpush
@endonce

<div class="content-wrap">
    <div class="content-card">
        <div class="content-card-head">{{ $judulKaldik }}</div>
        <ul class="kaldik-list">
            @forelse ($kaldik as $i => $item)
                <li class="kaldik-item">
                    <span>{{ $i + 1 }}. KALDIK TP {{ $item->tahun_ajaran }}</span>
                    <a class="kaldik-btn" href="{{ $item->fileUrl() }}" target="_blank" rel="noopener">
                        Lihat Kalender
                    </a>
                </li>
            @empty
                <li style="padding:1.25rem;text-align:center;color:#64748b;">
                    Kalender akademik belum tersedia.
                </li>
            @endforelse
        </ul>
    </div>
</div>
