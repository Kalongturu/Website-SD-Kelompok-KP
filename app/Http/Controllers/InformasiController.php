<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pengumuman;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    /**
     * Panel informasi: berita (kartu + pagination) + pengumuman (daftar/modal).
     */
    public function index()
    {
        $berita = Berita::where('is_active', true)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(6);

        $pengumuman = Pengumuman::where('is_active', true)
            ->orderByDesc('penting')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('informasi.index', compact('berita', 'pengumuman'));
    }

    /**
     * Galeri foto dengan filter kategori server-side dan pagination.
     */
    public function galeri(Request $request)
    {
        $query = Galeri::where('is_active', true)
            ->orderBy('urutan')
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        $galeri = $query->paginate(12)->withQueryString();

        // Kategori untuk tab filter selalu dari seluruh data aktif.
        $kategori = Galeri::where('is_active', true)
            ->pluck('kategori')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('informasi.galeri', compact('galeri', 'kategori'));
    }
}
