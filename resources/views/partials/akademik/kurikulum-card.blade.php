{{--
    Template kartu Kurikulum — merender konten berbasis "blok".
    Pakai dengan: @include('partials.akademik.kurikulum-card', ['judulKurikulum' => '...', 'blok' => [...]])
    Tipe blok yang didukung: 'paragraf', 'subjudul', 'ol', 'ul'.
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

            .kurikulum-body {
                padding: 2rem 2.25rem;
                color: var(--text);
                line-height: 1.75;
            }

            .kurikulum-body p {
                margin: 0 0 1rem;
            }

            .kurikulum-body h3 {
                color: var(--primary-dark);
                font-size: 1.1rem;
                font-weight: 700;
                margin: 1.75rem 0 .75rem;
            }

            .kurikulum-body ol,
            .kurikulum-body ul {
                margin: 0 0 1.25rem;
                padding-left: 1.5rem;
            }

            .kurikulum-body li {
                margin-bottom: .35rem;
            }
        </style>
    @endpush
@endonce

<div class="content-wrap">
    <div class="content-card">
        <div class="content-card-head">{{ $judulKurikulum }}</div>
        <div class="kurikulum-body">
            @foreach ($blok as $b)
                @switch($b['tipe'])
                    @case('paragraf')
                        <p>{{ $b['isi'] }}</p>
                    @break

                    @case('subjudul')
                        <h3>{{ $b['isi'] }}</h3>
                    @break

                    @case('ol')
                        <ol @isset($b['start']) start="{{ $b['start'] }}" @endisset>
                            @foreach ($b['item'] as $li)
                                <li>{{ $li }}</li>
                            @endforeach
                        </ol>
                    @break

                    @case('ul')
                        <ul>
                            @foreach ($b['item'] as $li)
                                <li>{{ $li }}</li>
                            @endforeach
                        </ul>
                    @break
                @endswitch
            @endforeach
        </div>
    </div>
</div>
