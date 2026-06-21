<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Prestasi;
use App\Models\TataTertib;

class KesiswaanController extends Controller
{
    /**
     * Daftar ekstrakurikuler (kartu) + data untuk panel detail.
     */
    public function ekstrakurikuler()
    {
        $ekstrakurikuler = Ekstrakurikuler::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('nama')
            ->get();

        return view('kesiswaan.ekstrakurikuler', compact('ekstrakurikuler'));
    }

    /**
     * Prestasi siswa (kartu) lengkap dengan kategori & tahun untuk panel filter.
     */
    public function prestasi()
    {
        $prestasi = Prestasi::where('is_active', true)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        // Kategori lomba yang tersedia (mis. MAPSI, KSN, Siswa Berprestasi) untuk tab/panel.
        $kategori = $prestasi->pluck('kategori')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        // Tahun pelaksanaan untuk filter waktu.
        $tahun = $prestasi->pluck('tanggal')
            ->filter()
            ->map(fn ($tanggal) => $tanggal->format('Y'))
            ->unique()
            ->sortDesc()
            ->values();

        return view('kesiswaan.prestasi', compact('prestasi', 'kategori', 'tahun'));
    }

    /**
     * Tata tertib sekolah, dikelompokkan per kategori.
     */
    public function tataTertib()
    {
        $tataTertib = TataTertib::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get()
            ->groupBy('kategori');

        return view('kesiswaan.tata_tertib', compact('tataTertib'));
    }
}
