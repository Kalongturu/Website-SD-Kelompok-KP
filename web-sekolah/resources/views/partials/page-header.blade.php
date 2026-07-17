{{--
    Header halaman yang dapat dipakai ulang (reusable).
    Pakai dengan: @include('partials.page-header', ['eyebrow' => '...', 'title' => '...', 'subtitle' => '...'])
--}}
@once
    @push('styles')
        <style>
            .page-header {
                background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--primary-ink) 100%);
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
        </style>
    @endpush
@endonce

<section class="page-header">
    <span class="eyebrow">{{ $eyebrow ?? 'SDN Dadapsari' }}</span>
    <h1>{!! $title !!}</h1>
    @isset($subtitle)
        <p>{{ $subtitle }}</p>
    @endisset
</section>
