@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')

    <!-- Welcome Banner -->
    <div class="p-4 mb-4 rounded-4 text-white"
        style="background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 60%, var(--accent) 100%);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h4 class="fw-700 mb-1" style="font-weight:700;">Selamat Datang, Admin!</h4>
                <p class="mb-0 opacity-75" style="font-size:.88rem;">
                    Kelola konten dan data SDN Dadapsari dari panel ini.
                </p>
            </div>
            <i class="bi bi-shield-fill-check" style="font-size:3rem; opacity:.3;"></i>
        </div>
    </div>

    <!-- ── Stat Cards ── -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['siswa'] }}</div>
                    <div class="stat-label">Total Siswa</div>
                    <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i>12 tahun ini</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-person-badge-fill"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['guru'] }}</div>
                    <div class="stat-label">Guru &amp; Staf</div>
                    <div class="stat-delta flat"><i class="bi bi-dash"></i>Tidak ada perubahan</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon yellow"><i class="bi bi-newspaper"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['berita'] }}</div>
                    <div class="stat-label">Berita Publik</div>
                    <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i>3 bulan ini</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-icon teal"><i class="bi bi-megaphone-fill"></i></div>
                <div>
                    <div class="stat-value">{{ $stats['pengumuman'] }}</div>
                    <div class="stat-label">Pengumuman Aktif</div>
                    <div class="stat-delta up"><i class="bi bi-arrow-up-short"></i>1 baru hari ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Bottom Row: Activity + Quick Actions ── -->
    <div class="row g-3">

        <!-- Aktivitas Terbaru -->
        <div class="col-lg-8">
            <div class="section-card h-100">
                <div class="section-header">
                    <h6><i class="bi bi-clock-history me-2 text-primary"></i>Aktivitas Terbaru</h6>
                    <a href="#" class="btn btn-sm btn-outline-secondary" style="font-size:.75rem;">Lihat Semua</a>
                </div>
                <table class="table table-hover activity-table mb-0">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th class="d-none d-md-table-cell">Oleh</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aktivitas as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="ikon-activity bg-{{ $item['warna'] }} bg-opacity-10 text-{{ $item['warna'] }}">
                                            <i class="bi bi-{{ $item['ikon'] }}"></i>
                                        </span>
                                        {{ $item['aksi'] }}
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell text-muted">{{ $item['oleh'] }}</td>
                                <td class="text-muted">{{ $item['waktu'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Aksi Cepat -->
        <div class="col-lg-4">
            <div class="section-card h-100">
                <div class="section-header">
                    <h6><i class="bi bi-lightning-fill me-2 text-warning"></i>Aksi Cepat</h6>
                </div>
                <div class="p-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="#" class="quick-btn">
                                <i class="bi bi-plus-circle-fill"></i>Tambah Berita
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="quick-btn">
                                <i class="bi bi-megaphone-fill"></i>Pengumuman
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="quick-btn">
                                <i class="bi bi-image-fill"></i>Upload Foto
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="quick-btn">
                                <i class="bi bi-person-plus-fill"></i>Tambah Guru
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="quick-btn">
                                <i class="bi bi-calendar-plus-fill"></i>Event Baru
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.kontak') }}" class="quick-btn">
                                <i class="bi bi-telephone-fill"></i>Edit Footer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
