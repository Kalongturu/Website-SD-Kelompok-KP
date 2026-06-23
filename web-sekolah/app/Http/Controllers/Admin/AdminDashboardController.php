<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Guru;
use App\Models\Pengumuman;
use App\Models\RuangKelas;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'siswa'        => (int) RuangKelas::where('is_active', true)->sum('jumlah_siswa'),
            'guru'         => Guru::where('is_active', true)->count(),
            'berita'       => Berita::where('is_active', true)->count(),
            'pengumuman'   => Pengumuman::where('is_active', true)->count(),
        ];

        $aktivitas = [
            ['waktu' => '2 menit lalu',  'aksi' => 'Berita baru ditambahkan',          'oleh' => 'Admin',    'ikon' => 'newspaper',       'warna' => 'primary'],
            ['waktu' => '1 jam lalu',    'aksi' => 'Data siswa diperbarui',             'oleh' => 'Admin',    'ikon' => 'person-fill',     'warna' => 'success'],
            ['waktu' => '3 jam lalu',    'aksi' => 'Pengumuman PPDB dipublikasikan',    'oleh' => 'Admin',    'ikon' => 'megaphone-fill',  'warna' => 'warning'],
            ['waktu' => 'Kemarin',       'aksi' => 'Foto galeri diunggah',              'oleh' => 'Admin',    'ikon' => 'images',          'warna' => 'info'],
            ['waktu' => 'Kemarin',       'aksi' => 'Data guru diperbarui',              'oleh' => 'Admin',    'ikon' => 'person-badge',    'warna' => 'secondary'],
        ];

        return view('admin.admin_dashboard', compact('stats', 'aktivitas'));
    }
}
