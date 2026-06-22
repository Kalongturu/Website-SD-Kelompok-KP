<?php

namespace App\Http\Controllers;

use App\Models\KalenderAkademik;
use App\Models\Guru;

class AkademikController extends Controller
{
    public function kalender()
    {
        $kaldik = KalenderAkademik::query()
            ->where('is_active', true)
            ->orderBy('urutan')
            ->orderByDesc('tahun_ajaran')
            ->get();

        return view('Akademik.kalender_akademik', [
            'judulKaldik' => 'KALDIK KOTA SEMARANG',
            'kaldik' => $kaldik,
        ]);
    }

    public function guru()
    {
        // Kepala Sekolah ditampilkan sebagai sorotan utama di bagian atas.
        $kepala = Guru::where('is_active', true)
            ->where('is_kepala', true)
            ->orderBy('urutan')
            ->first();

        // Guru & staf lainnya tampil dalam grid di bawahnya.
        $guru = Guru::where('is_active', true)
            ->where('is_kepala', false)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('Akademik.guru', compact('kepala', 'guru'));
    }
}
