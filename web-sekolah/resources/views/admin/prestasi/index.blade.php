@extends('layouts.admin')

@section('title', 'Kelola Prestasi Siswa')
@section('page-title', 'Prestasi Siswa')

@section('styles')
<style>
    .prestasi-table th, .prestasi-table td { font-size: .82rem; vertical-align: middle; }
    .badge-tingkat { font-size:.7rem; padding:.2rem .6rem; border-radius:50px; font-weight:600; }
    .badge-tingkat.nasional  { background:#fef3c7; color:#92400e; }
    .badge-tingkat.provinsi  { background:#dbeafe; color:#1e40af; }
    .badge-tingkat.kota      { background:#dcfce7; color:#14532d; }
    .badge-tingkat.kecamatan { background:#f3f4f6; color:#374151; }
    .badge-tingkat.sekolah   { background:#ede9fe; color:#4c1d95; }
    .badge-tingkat.lainnya   { background:#f1f5f9; color:#475569; }
    .peringkat-badge { font-size:.72rem; font-weight:700; color:#fff; background:var(--primary); padding:.15rem .55rem; border-radius:6px; }
</style>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" style="font-size:.85rem;">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="section-card">
    <div class="section-header">
        <h6><i class="bi bi-award-fill me-2 text-warning"></i>Daftar Prestasi ({{ $items->total() }})</h6>
        <a href="{{ route('admin.prestasi.create') }}" class="btn btn-sm"
           style="background:var(--primary);color:#fff;border-radius:8px;font-size:.8rem;">
            <i class="bi bi-plus-lg me-1"></i> Tambah
        </a>
    </div>

    @if ($items->isEmpty())
        <div class="p-5 text-center text-muted">
            <i class="bi bi-award" style="font-size:2.5rem;opacity:.3;"></i>
            <p class="mt-2 mb-0" style="font-size:.9rem;">Belum ada data prestasi. Klik "Tambah" untuk mulai.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle prestasi-table mb-0">
                <thead style="background:#f8fafc;font-size:.78rem;color:#64748b;text-transform:uppercase;">
                    <tr>
                        <th style="padding:.75rem 1rem;">#</th>
                        <th>Kejuaraan</th>
                        <th>Kategori</th>
                        <th>Tingkat</th>
                        <th>Peringkat</th>
                        <th>Siswa</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th style="width:110px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td style="padding:.6rem 1rem;color:#756d66;">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                            <td>
                                <div style="font-weight:600;color:var(--primary-dark);max-width:220px;">{{ $item->nama_kejuaraan }}</div>
                                @if ($item->penyelenggara)
                                    <div style="font-size:.72rem;color:#756d66;">{{ $item->penyelenggara }}</div>
                                @endif
                                @if ($item->tempat)
                                    <div style="font-size:.72rem;color:#756d66;"><i class="bi bi-geo-alt"></i> {{ $item->tempat }}</div>
                                @endif
                            </td>
                            <td>
                                @if ($item->kategori)
                                    <span style="font-size:.72rem;background:var(--accent-soft);color:var(--primary);padding:.15rem .55rem;border-radius:50px;">{{ $item->kategori }}</span>
                                @else —
                                @endif
                            </td>
                            <td>
                                @php
                                    $tClass = match(strtolower($item->tingkat ?? '')) {
                                        'nasional' => 'nasional', 'provinsi' => 'provinsi',
                                        'kota', 'kabupaten' => 'kota', 'kecamatan' => 'kecamatan',
                                        'sekolah' => 'sekolah', default => 'lainnya'
                                    };
                                @endphp
                                @if ($item->tingkat)
                                    <span class="badge-tingkat {{ $tClass }}">{{ $item->tingkat }}</span>
                                @else —
                                @endif
                            </td>
                            <td>
                                @if ($item->peringkat)
                                    <span class="peringkat-badge">{{ $item->peringkat }}</span>
                                @else —
                                @endif
                            </td>
                            <td>
                                <div style="font-size:.82rem;">{{ $item->nama_siswa ?: '—' }}</div>
                                @if ($item->kelas) <div style="font-size:.7rem;color:#756d66;">Kelas {{ $item->kelas }}</div> @endif
                            </td>
                            <td style="white-space:nowrap;font-size:.8rem;">
                                {{ $item->tanggal ? $item->tanggal->translatedFormat('d M Y') : '—' }}
                            </td>
                            <td>
                                <span style="font-size:.72rem;font-weight:600;color:{{ $item->is_active ? '#16a34a' : '#dc2626' }};">
                                    <i class="bi bi-circle-fill me-1" style="font-size:.45rem;vertical-align:middle;"></i>
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="{{ route('admin.prestasi.edit', $item) }}"
                                       class="btn btn-sm btn-light" style="font-size:.72rem;border-radius:6px;padding:.25rem .5rem;">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.prestasi.toggle', $item) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-light"
                                            style="font-size:.72rem;border-radius:6px;padding:.25rem .5rem;
                                                   color:{{ $item->is_active ? '#ca8a04' : '#15803d' }};">
                                            <i class="bi bi-{{ $item->is_active ? 'eye-slash' : 'eye' }}-fill"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.prestasi.destroy', $item) }}"
                                          onsubmit="return confirm('Hapus data prestasi ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light"
                                            style="font-size:.72rem;border-radius:6px;padding:.25rem .5rem;color:#dc2626;">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($items->hasPages())
            <div class="p-3">{{ $items->links() }}</div>
        @endif
    @endif
</div>

@endsection
