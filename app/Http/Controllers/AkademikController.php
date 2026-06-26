<?php

namespace App\Http\Controllers;

use App\Models\KalenderAkademik;
use App\Models\Guru;
use App\Models\KurikulumSetting;
use Illuminate\Support\Facades\DB;

class AkademikController extends Controller
{
    public function kurikulum()
    {
        $setting = KurikulumSetting::getData();

        return view('Akademik.kurikulum', [
            'judulKurikulum' => $setting->judul,
            'blok' => $setting->blok,
        ]);
    }

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
        // select(LIST_COLUMNS) agar byte foto (foto_data/bytea) tidak ikut ditarik.
        $kepala = Guru::select(Guru::LIST_COLUMNS)
            ->where('is_active', true)
            ->where('is_kepala', true)
            ->orderBy('urutan')
            ->first();

        // Guru & staf lainnya tampil dalam grid di bawahnya.
        $guru = Guru::select(Guru::LIST_COLUMNS)
            ->where('is_active', true)
            ->where('is_kepala', false)
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('Akademik.guru', compact('kepala', 'guru'));
    }

    /**
     * Menyajikan foto guru/staf langsung dari kolom biner (bytea) di database.
     * Byte diambil sebagai base64 lalu di-decode agar andal lintas driver PDO
     * (tidak bergantung pada cara PDO mengembalikan bytea sebagai stream/teks).
     */
    public function guruFoto(Guru $guru)
    {
        $row = DB::table('guru')
            ->where('id', $guru->id)
            ->selectRaw("encode(foto_data, 'base64') as b64, foto_mime")
            ->first();

        abort_if(! $row || empty($row->b64), 404);

        $bytes = base64_decode($row->b64);

        return response($bytes)
            ->header('Content-Type', $row->foto_mime ?: 'image/jpeg')
            ->header('Content-Length', (string) strlen($bytes))
            ->header('Cache-Control', 'public, max-age=86400');
    }
}
