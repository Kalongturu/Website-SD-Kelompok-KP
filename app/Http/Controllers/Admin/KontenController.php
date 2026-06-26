<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konten;
use Illuminate\Http\Request;

class KontenController extends Controller
{
    public function index()
    {
        $konten = Konten::orderBy('id')->get();
        return view('admin.konten.index', compact('konten'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'konten' => ['required', 'array'],
            'konten.*' => ['nullable', 'string'],
        ]);

        foreach ($data['konten'] as $id => $nilai) {
            Konten::where('id', $id)->update(['nilai' => $nilai]);
        }

        return redirect()->route('admin.konten.index')->with('sukses', 'Konten halaman berhasil disimpan.');
    }
}
