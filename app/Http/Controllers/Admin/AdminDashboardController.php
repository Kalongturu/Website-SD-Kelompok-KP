<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'siswa'        => 320,
            'guru'         => 24,
            'berita'       => 12,
            'pengumuman'   => 5,
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
