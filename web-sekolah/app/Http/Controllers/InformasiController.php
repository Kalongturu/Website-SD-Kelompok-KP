<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformasiController extends Controller
{
    /**
     * Panel informasi: berita (kartu + pagination) + pengumuman (daftar/modal).
     */
    public function index()
    {
        $berita = Berita::select(Berita::LIST_COLUMNS)
            ->where('is_active', true)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(6);

        $pengumuman = Pengumuman::select(Pengumuman::LIST_COLUMNS)
            ->where('is_active', true)
            ->orderByDesc('penting')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get();

        return view('informasi.index', compact('berita', 'pengumuman'));
    }

    /**
     * Menyajikan gambar berita langsung dari kolom biner (bytea) di database.
     * Byte diambil sebagai base64 lalu di-decode agar andal lintas driver PDO
     * (tidak bergantung pada cara PDO mengembalikan bytea sebagai stream/teks).
     */
    public function gambar(Berita $berita)
    {
        $row = DB::table('berita')
            ->where('id', $berita->id)
            ->selectRaw("encode(gambar_data, 'base64') as b64, gambar_mime")
            ->first();

        abort_if(! $row || empty($row->b64), 404);

        $bytes = base64_decode($row->b64);

        return response($bytes)
            ->header('Content-Type', $row->gambar_mime ?: 'image/jpeg')
            ->header('Content-Length', (string) strlen($bytes))
            ->header('Cache-Control', 'public, max-age=86400');
    }

    /**
     * Menyajikan lampiran pengumuman langsung dari kolom biner (bytea) di database.
     * Ditampilkan inline (browser memutuskan tampil/unduh) dengan nama berkas asli.
     */
    public function lampiran(Pengumuman $pengumuman)
    {
        $row = DB::table('pengumuman')
            ->where('id', $pengumuman->id)
            ->selectRaw("encode(lampiran_data, 'base64') as b64, lampiran_mime, lampiran_nama")
            ->first();

        abort_if(! $row || empty($row->b64), 404);

        $bytes = base64_decode($row->b64);
        $nama  = $row->lampiran_nama ?: ('lampiran-' . $pengumuman->id);

        return response($bytes)
            ->header('Content-Type', $row->lampiran_mime ?: 'application/octet-stream')
            ->header('Content-Length', (string) strlen($bytes))
            ->header('Content-Disposition', 'inline; filename="' . addslashes($nama) . '"');
    }

    /**
     * Menyajikan gambar galeri langsung dari kolom biner (bytea) di database.
     * Byte diambil sebagai base64 lalu di-decode agar andal lintas driver PDO.
     */
    public function galeriGambar(Galeri $galeri)
    {
        $row = DB::table('galeri')
            ->where('id', $galeri->id)
            ->selectRaw("encode(gambar_data, 'base64') as b64, gambar_mime")
            ->first();

        abort_if(! $row || empty($row->b64), 404);

        $bytes = base64_decode($row->b64);

        return response($bytes)
            ->header('Content-Type', $row->gambar_mime ?: 'image/jpeg')
            ->header('Content-Length', (string) strlen($bytes))
            ->header('Cache-Control', 'public, max-age=86400');
    }

    /**
     * Galeri foto dengan filter kategori server-side dan pagination.
     */
    public function galeri(Request $request)
    {
        // select(LIST_COLUMNS) agar byte gambar (bytea) tidak ikut ditarik.
        // Tanpa ini, paginate(12) menarik 12 gambar penuh padahal kartu galeri
        // hanya memakai galeriUrl() yang menunjuk ke route galeri.gambar.
        $query = Galeri::select(Galeri::LIST_COLUMNS)
            ->where('is_active', true)
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
