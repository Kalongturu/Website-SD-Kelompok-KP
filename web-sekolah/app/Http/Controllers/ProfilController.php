<?php

namespace App\Http\Controllers;

use App\Models\SaranaPrasarana;
use App\Models\RuangKelas;
use App\Models\ProfilSetting;
use App\Models\EBook;
use App\Models\VideoPembelajaran;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function sejarah()
    {
        $setting = ProfilSetting::getData();
        return view('Profil.sejarah', compact('setting'));
    }

    public function visiMisi()
    {
        $setting = ProfilSetting::getData();
        return view('Profil.visi-misi', compact('setting'));
    }

    public function transparansiDanaBos()
    {
        $setting = ProfilSetting::getData();
        return view('Profil.transparansi-dana-bos', compact('setting'));
    }

    public function fasilitas(Request $request)
    {
        $tab = in_array($request->input('tab'), ['ruang-kelas', 'sarpras', 'media-digital'])
            ? $request->input('tab')
            : 'ruang-kelas';

        $ruangKelas   = null;
        $sarpras      = null;
        $totalGanjil  = 0;
        $totalGenap   = 0;
        $ebooks       = null;
        $videos       = null;

        // select(LIST_COLUMNS) agar byte gambar (bytea) tidak ikut ditarik.
        if ($tab === 'ruang-kelas') {
            $ruangKelas = RuangKelas::select(RuangKelas::LIST_COLUMNS)
                ->where('is_active', true)
                ->orderBy('urutan')
                ->orderBy('id')
                ->paginate(8)
                ->withQueryString();
        } elseif ($tab === 'sarpras') {
            $sarpras = SaranaPrasarana::select(SaranaPrasarana::LIST_COLUMNS)
                ->where('is_active', true)
                ->orderBy('urutan')
                ->orderBy('id')
                ->paginate(10)
                ->withQueryString();

            // Total keseluruhan untuk baris tfoot (bukan hanya halaman aktif).
            $totalGanjil = SaranaPrasarana::where('is_active', true)->sum('jumlah_ganjil');
            $totalGenap  = SaranaPrasarana::where('is_active', true)->sum('jumlah_genap');
        } else {
            $ebooks = EBook::select(EBook::LIST_COLUMNS)
                ->where('is_active', true)
                ->orderBy('urutan')->orderBy('id')
                ->get();
            $videos = VideoPembelajaran::where('is_active', true)
                ->orderBy('urutan')->orderBy('id')
                ->get();
        }

        return view('Profil.fasilitas', compact(
            'sarpras', 'ruangKelas', 'tab', 'totalGanjil', 'totalGenap', 'ebooks', 'videos'
        ));
    }
}
