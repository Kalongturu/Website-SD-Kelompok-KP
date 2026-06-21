<?php

namespace App\Http\Controllers;

use App\Models\SaranaPrasarana;
use App\Models\RuangKelas;
use App\Models\ProfilSetting;
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
        $tab = in_array($request->input('tab'), ['ruang-kelas', 'sarpras'])
            ? $request->input('tab')
            : 'ruang-kelas';

        $ruangKelas  = null;
        $sarpras     = null;
        $totalGanjil = 0;
        $totalGenap  = 0;

        if ($tab === 'ruang-kelas') {
            $ruangKelas = RuangKelas::where('is_active', true)
                ->orderBy('urutan')
                ->orderBy('id')
                ->paginate(8)
                ->withQueryString();
        } else {
            $sarpras = SaranaPrasarana::where('is_active', true)
                ->orderBy('urutan')
                ->orderBy('id')
                ->paginate(10)
                ->withQueryString();

            // Total keseluruhan untuk baris tfoot (bukan hanya halaman aktif).
            $totalGanjil = SaranaPrasarana::where('is_active', true)->sum('jumlah_ganjil');
            $totalGenap  = SaranaPrasarana::where('is_active', true)->sum('jumlah_genap');
        }

        return view('Profil.fasilitas', compact('sarpras', 'ruangKelas', 'tab', 'totalGanjil', 'totalGenap'));
    }
}
