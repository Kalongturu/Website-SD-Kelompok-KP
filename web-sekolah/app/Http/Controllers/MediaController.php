<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesDbImage;
use App\Models\EBook;
use App\Models\Ekstrakurikuler;
use App\Models\Prestasi;
use App\Models\RuangKelas;
use App\Models\SaranaPrasarana;
use App\Models\Siswa;
use App\Models\VideoPembelajaran;

/**
 * Menyajikan gambar yang tersimpan sebagai data biner (bytea) di database untuk
 * modul-modul yang sebelumnya hanya menyimpan path teks. Route-nya publik (di
 * luar grup redirect.admin) agar gambar dapat dimuat SEMUA user — pengunjung
 * biasa maupun admin yang sedang login (thumbnail di dashboard).
 */
class MediaController extends Controller
{
    use HandlesDbImage;

    public function ekskulFoto(Ekstrakurikuler $ekstrakurikuler)
    {
        return $this->serveDbImage($ekstrakurikuler, 'foto');
    }

    public function prestasiFoto(Prestasi $prestasi)
    {
        return $this->serveDbImage($prestasi, 'foto');
    }

    public function sarprasGambar(SaranaPrasarana $sarpra)
    {
        return $this->serveDbImage($sarpra, 'gambar');
    }

    public function ruangKelasGambar(RuangKelas $ruangKelas)
    {
        return $this->serveDbImage($ruangKelas, 'gambar');
    }

    public function ebookCover(EBook $ebook)
    {
        return $this->serveDbImage($ebook, 'cover');
    }

    public function siswaFoto(Siswa $siswa)
    {
        return $this->serveDbImage($siswa, 'foto');
    }

    public function videoThumbnail(VideoPembelajaran $video)
    {
        return $this->serveDbImage($video, 'thumbnail');
    }
}
