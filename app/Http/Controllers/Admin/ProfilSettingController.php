<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilSetting;
use Illuminate\Http\Request;

class ProfilSettingController extends Controller
{
    public function edit()
    {
        $setting = ProfilSetting::first() ?? new ProfilSetting();
        return view('admin.profil_setting.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'sejarah_intro'      => 'nullable|string|max:5000',
            'sejarah_komitmen'   => 'nullable|string|max:3000',
            'visi'               => 'nullable|string|max:1000',
            'bos_tahun_anggaran' => 'nullable|string|max:20',
            'bos_jumlah_siswa'   => 'nullable|string|max:50',
            'bos_dana_per_siswa' => 'nullable|string|max:80',
            'bos_total_estimasi' => 'nullable|string|max:80',
            'bos_catatan'        => 'nullable|string|max:2000',
        ]);

        $data = [
            'sejarah_intro'    => $request->input('sejarah_intro'),
            'sejarah_komitmen' => $request->input('sejarah_komitmen'),

            'sejarah_timeline' => $this->buildTimeline($request),

            'visi'   => $request->input('visi'),
            'misi'   => array_values(array_filter($request->input('misi', []), fn($v) => trim($v) !== '')),
            'tujuan' => array_values(array_filter($request->input('tujuan', []), fn($v) => trim($v) !== '')),
            'nilai'  => $this->buildNilai($request),

            'bos_tahun_anggaran' => $request->input('bos_tahun_anggaran'),
            'bos_jumlah_siswa'   => $request->input('bos_jumlah_siswa'),
            'bos_dana_per_siswa' => $request->input('bos_dana_per_siswa'),
            'bos_total_estimasi' => $request->input('bos_total_estimasi'),
            'bos_komponen'       => $this->buildKomponen($request),
            'bos_catatan'        => $request->input('bos_catatan'),
        ];

        $setting = ProfilSetting::first();
        if ($setting) {
            $setting->update($data);
        } else {
            ProfilSetting::create($data);
        }

        return back()->with('success', 'Konten profil berhasil disimpan.');
    }

    private function buildTimeline(Request $request): array
    {
        $tahun    = $request->input('tl_tahun', []);
        $judul    = $request->input('tl_judul', []);
        $deskripsi = $request->input('tl_deskripsi', []);

        $result = [];
        foreach ($tahun as $i => $t) {
            if (trim($t) === '' && trim($judul[$i] ?? '') === '') continue;
            $result[] = [
                'tahun'    => trim($t),
                'judul'    => trim($judul[$i] ?? ''),
                'deskripsi'=> trim($deskripsi[$i] ?? ''),
            ];
        }
        return $result;
    }

    private function buildNilai(Request $request): array
    {
        $icons = $request->input('nilai_icon', []);
        $names = $request->input('nilai_nama', []);

        $result = [];
        foreach ($icons as $i => $icon) {
            $nama = trim($names[$i] ?? '');
            if ($nama === '') continue;
            $result[] = ['icon' => trim($icon), 'nama' => $nama];
        }
        return $result;
    }

    private function buildKomponen(Request $request): array
    {
        $names    = $request->input('bos_nama', []);
        $percents = $request->input('bos_persen', []);
        $amounts  = $request->input('bos_estimasi', []);
        $statuses = $request->input('bos_status', []);

        $result = [];
        foreach ($names as $i => $name) {
            if (trim($name) === '') continue;
            $result[] = [
                'nama'     => trim($name),
                'persen'   => trim($percents[$i] ?? ''),
                'estimasi' => trim($amounts[$i] ?? ''),
                'status'   => trim($statuses[$i] ?? 'Direncanakan'),
            ];
        }
        return $result;
    }
}
