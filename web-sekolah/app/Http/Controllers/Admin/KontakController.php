<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function edit()
    {
        $footer = FooterSetting::getData();
        return view('admin.kontak', compact('footer'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nama_sekolah' => 'required|string|max:100',
            'deskripsi'    => 'nullable|string|max:500',
            'alamat'       => 'nullable|string|max:200',
            'telepon'      => 'nullable|string|max:30',
            'email'        => 'nullable|email|max:100',
            'jam_weekday'  => 'nullable|string|max:50',
            'jam_sabtu'    => 'nullable|string|max:50',
            'copyright'    => 'nullable|string|max:200',
        ]);

        FooterSetting::updateOrCreate(['id' => 1], $data);

        return back()->with('success', 'Pengaturan footer berhasil disimpan.');
    }
}
