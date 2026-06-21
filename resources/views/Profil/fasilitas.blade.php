@extends('layouts.app')

@section('title', 'Fasilitas')
@section('description',
    'Data sarana dan prasarana SDN Dadapsari — ruang kelas, perpustakaan, laboratorium, dan
    fasilitas penunjang lainnya.')

    @push('styles')
        <style>
            .page-header {
                background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, #2a8aa3 100%);
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
                max-width: 620px;
                margin: 0 auto;
                color: rgba(255, 255, 255, .8);
            }

            .sarpras-wrap {
                max-width: 980px;
                margin: -3rem auto 4rem;
                padding: 0 1.25rem;
            }

            .sarpras-card {
                background: var(--white);
                border-radius: var(--radius);
                box-shadow: var(--shadow-lg);
                overflow: hidden;
            }

            .sarpras-card-head {
                background: var(--accent-soft);
                color: var(--primary);
                font-weight: 700;
                letter-spacing: .5px;
                text-transform: uppercase;
                font-size: .85rem;
                padding: 1rem 1.5rem;
                border-bottom: 1px solid rgba(0, 43, 91, .06);
            }

            .table-scroll {
                overflow-x: auto;
            }

            table.sarpras {
                width: 100%;
                border-collapse: collapse;
                font-size: .95rem;
            }

            table.sarpras thead th {
                text-align: left;
                color: var(--text);
                font-weight: 700;
                padding: 1rem 1.5rem;
                border-bottom: 2px solid rgba(0, 43, 91, .08);
                white-space: nowrap;
            }

            table.sarpras th.num,
            table.sarpras td.num {
                text-align: center;
            }

            table.sarpras tbody td {
                padding: .85rem 1.5rem;
                color: var(--text);
                border-bottom: 1px solid rgba(0, 43, 91, .05);
            }

            table.sarpras tbody tr:nth-child(even) {
                background: #fafbfc;
            }

            table.sarpras tbody tr:hover {
                background: var(--accent-soft);
            }

            table.sarpras tfoot td {
                padding: 1rem 1.5rem;
                font-weight: 800;
                color: var(--primary-dark);
                border-top: 2px solid rgba(0, 43, 91, .12);
                background: #f4f6f9;
            }

            .sarpras-source {
                margin: 1rem .25rem 0;
                font-size: .8rem;
                color: var(--muted);
                font-style: italic;
            }

            .sarpras-source a {
                color: var(--primary);
            }
        </style>
    @endpush

@section('content')

    {{-- ===================== HEADER ===================== --}}
    <section class="page-header">
        <span class="eyebrow">Profil Sekolah</span>
        <h1>Sarana dan Prasarana<br>SDN Dadapsari</h1>
        <p>Informasi kelengkapan ruang dan fasilitas penunjang kegiatan belajar mengajar di SDN Dadapsari.</p>
    </section>

    {{-- ===================== TABEL SARPRAS ===================== --}}
    <div class="sarpras-wrap">
        <div class="sarpras-card">
            <div class="sarpras-card-head">Data Sarpras</div>
            <div class="table-scroll">
                <table class="sarpras">
                    <thead>
                        <tr>
                            <th class="num">No</th>
                            <th>Jenis Sarpras</th>
                            <th class="num">Jml 2020 Ganjil</th>
                            <th class="num">Jml 2020 Genap</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sarpras as $i => $item)
                            <tr>
                                <td class="num">{{ $i + 1 }}</td>
                                <td>{{ $item['jenis'] }}</td>
                                <td class="num">{{ $item['ganjil'] }}</td>
                                <td class="num">{{ $item['genap'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td>Total</td>
                            <td class="num">{{ collect($sarpras)->sum('ganjil') }}</td>
                            <td class="num">{{ collect($sarpras)->sum('genap') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <p class="sarpras-source">Sumber: <a href="https://dapo.kemdikbud.go.id/" target="_blank"
                rel="noopener">https://dapo.kemdikbud.go.id/</a></p>
    </div>

@endsection
