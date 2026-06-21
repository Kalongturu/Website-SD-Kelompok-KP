<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Prestasi;
use App\Models\TataTertib;
use Illuminate\Http\Request;

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
            ->paginate(9);

        return view('kesiswaan.ekstrakurikuler', compact('ekstrakurikuler'));
    }

    /**
     * Prestasi siswa (kartu) dengan filter server-side dan pagination.
     */
    public function prestasi(Request $request)
    {
        $query = Prestasi::where('is_active', true)
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_kejuaraan', 'like', "%{$q}%")
                    ->orWhere('nama_siswa', 'like', "%{$q}%")
                    ->orWhere('penyelenggara', 'like', "%{$q}%");
            });
        }

        if ($request->filled('tahun') && $request->tahun !== 'all') {
            $query->whereYear('tanggal', $request->tahun);
        }

        $prestasi = $query->paginate(9)->withQueryString();

        // Opsi filter selalu dari seluruh data aktif.
        $allPrestasi = Prestasi::where('is_active', true)->get(['kategori', 'tanggal']);

        $kategori = $allPrestasi->pluck('kategori')
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $tahun = $allPrestasi->pluck('tanggal')
            ->filter()
            ->map(fn($tanggal) => $tanggal->format('Y'))
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
