<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pengumuman;

class InformasiController extends Controller
{
    /**
     * Panel informasi: berita (kartu) + pengumuman (daftar/modal).
     */
    public function index()
    {
        $berita = Berita::where('is_active', true)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        $pengumuman = Pengumuman::where('is_active', true)
            ->orderByDesc('penting')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('informasi.index', compact('berita', 'pengumuman'));
    }
}
