@extends('layouts.app')

@section('title', 'Tata Tertib')
@section('description',
    'Tata tertib dan aturan sekolah SDN Dadapsari untuk menumbuhkan kedisiplinan dan karakter siswa.')

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

        .tatib-wrap {
            max-width: 1000px;
            margin: -3rem auto 4rem;
            padding: 0 1.25rem;
        }

        .tatib-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .tatib-card {
            background: var(--white);
            border: 1px solid #eef1f5;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .tatib-card-head {
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: 1.1rem 1.4rem;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--white);
        }

        .tatib-card-head .ico {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .18);
            display: grid;
            place-items: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .tatib-card-head h3 {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .tatib-list {
            list-style: none;
            counter-reset: aturan;
            padding: 1.1rem 1.4rem 1.5rem;
            display: grid;
            gap: .75rem;
        }

        .tatib-list li {
            counter-increment: aturan;
            position: relative;
            padding-left: 2.1rem;
            font-size: .92rem;
            color: var(--text);
            line-height: 1.55;
        }

        .tatib-list li::before {
            content: counter(aturan);
            position: absolute;
            left: 0;
            top: .05rem;
            width: 1.5rem;
            height: 1.5rem;
            background: var(--accent-soft);
            color: var(--primary);
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: .75rem;
            font-weight: 700;
        }

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

        @media (max-width: 768px) {
            .tatib-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ===================== HEADER ===================== --}}
    <section class="page-header">
        <span class="eyebrow">Kesiswaan</span>
        <h1>Tata Tertib Sekolah</h1>
        <p>Aturan dan ketentuan yang berlaku di SDN Dadapsari untuk menumbuhkan kedisiplinan, tanggung jawab, dan
            akhlak mulia.</p>
    </section>

    <div class="tatib-wrap">
        @if ($tataTertib->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h3>Belum ada data tata tertib</h3>
                <p>Tata tertib sekolah akan tampil di sini setelah ditambahkan oleh admin.</p>
            </div>
        @else
            <div class="tatib-grid">
                @foreach ($tataTertib as $kategori => $items)
                    <div class="tatib-card">
                        <div class="tatib-card-head">
                            <span class="ico">{{ $items->first()->icon ?: '📌' }}</span>
                            <h3>{{ $kategori }}</h3>
                        </div>
                        <ul class="tatib-list">
                            @foreach ($items as $item)
                                @foreach ($item->butir() as $baris)
                                    <li>{{ $baris }}</li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection
