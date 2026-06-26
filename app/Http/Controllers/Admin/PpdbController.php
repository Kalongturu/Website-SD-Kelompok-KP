<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbSetting;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function index()
    {
        $ppdb = PpdbSetting::getData();
        return view('admin.ppdb.index', compact('ppdb'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'tahun_ajaran'  => 'required|string|max:20',
            'is_open'       => 'boolean',
            'tanggal_buka'  => 'nullable|date',
            'tanggal_tutup' => 'nullable|date|after_or_equal:tanggal_buka',
            'link_daftar'   => 'nullable|url|max:500',
            'pengumuman'    => 'nullable|string|max:1000',
        ]);

        $data['is_open'] = $request->boolean('is_open');

        PpdbSetting::updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Pengaturan PPDB berhasil disimpan.');
    }
}
