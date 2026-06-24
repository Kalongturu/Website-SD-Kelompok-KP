<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\PpdbSetting;
use App\Models\Ekstrakurikuler;
use App\Models\Prestasi;
use App\Models\ProfilSetting;
use App\Models\RuangKelas;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        $berita = Berita::select(Berita::LIST_COLUMNS)
            ->where('is_active', true)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        $galeriPreview = Galeri::where('is_active', true)
            ->orderBy('urutan')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        $ppdb = PpdbSetting::getData();

        $profil = ProfilSetting::getData();

        $ekskulPreview = Ekstrakurikuler::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('nama')
            ->limit(3)
            ->get();

        $prestasiPreview = Prestasi::where('is_active', true)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        // Statistik hero — dihitung dinamis dari data sekolah
        $stats = [
            'siswa'       => (int) RuangKelas::where('is_active', true)->sum('jumlah_siswa'),
            'guru'        => Guru::where('is_active', true)->count(),
            'ruang_kelas' => RuangKelas::where('is_active', true)->count(),
            'prestasi'    => Prestasi::where('is_active', true)->count(),
        ];

        return view('home', compact(
            'berita', 'galeriPreview', 'ppdb',
            'ekskulPreview', 'prestasiPreview', 'stats', 'profil'
        ));
    }
}
