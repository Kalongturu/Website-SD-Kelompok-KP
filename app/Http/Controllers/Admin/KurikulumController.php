<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KurikulumSetting;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function edit()
    {
        $setting = KurikulumSetting::getData();

        return view('admin.kurikulum.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'judul'        => 'nullable|string|max:200',
            'blok_tipe'    => 'array',
            'blok_tipe.*'  => 'in:paragraf,subjudul,ol,ul',
            'blok_isi'     => 'array',
            'blok_isi.*'   => 'nullable|string|max:5000',
            'blok_start'   => 'array',
            'blok_start.*' => 'nullable|integer|min:1',
        ]);

        $data = [
            'judul' => trim((string) $request->input('judul')) ?: 'KURIKULUM SDN DADAPSARI SEMARANG',
            'blok'  => $this->buildBlok($request),
        ];

        $setting = KurikulumSetting::first();
        if ($setting) {
            $setting->update($data);
        } else {
            KurikulumSetting::create($data);
        }

        return back()->with('success', 'Konten kurikulum berhasil disimpan.');
    }

    /**
     * Susun array "blok" dari input form yang sejajar (blok_tipe[], blok_isi[], blok_start[]).
     * - paragraf / subjudul → simpan teks tunggal di 'isi'
     * - ol / ul             → setiap baris = satu item; 'start' opsional khusus ol
     */
    private function buildBlok(Request $request): array
    {
        $tipe  = $request->input('blok_tipe', []);
        $isi   = $request->input('blok_isi', []);
        $start = $request->input('blok_start', []);

        $result = [];
        foreach ($tipe as $i => $t) {
            $t = in_array($t, ['paragraf', 'subjudul', 'ol', 'ul'], true) ? $t : 'paragraf';
            $content = trim($isi[$i] ?? '');
            if ($content === '') continue;

            if ($t === 'paragraf' || $t === 'subjudul') {
                $result[] = ['tipe' => $t, 'isi' => $content];
                continue;
            }

            // Daftar (ol/ul): pecah per baris, buang baris kosong.
            $items = array_values(array_filter(
                array_map('trim', preg_split('/\r\n|\r|\n/', $content)),
                fn ($v) => $v !== ''
            ));
            if (empty($items)) continue;

            $block = ['tipe' => $t, 'item' => $items];

            $s = trim((string) ($start[$i] ?? ''));
            if ($t === 'ol' && $s !== '' && (int) $s > 1) {
                $block['start'] = (int) $s;
            }

            $result[] = $block;
        }

        return $result;
    }
}
