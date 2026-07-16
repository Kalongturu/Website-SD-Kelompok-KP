<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesDbImage;
use App\Http\Controllers\Controller;
use App\Models\SaranaPrasarana;
use Illuminate\Http\Request;

class SarprasController extends Controller
{
    use HandlesDbImage;

    public function index()
    {
        $items = SaranaPrasarana::select(SaranaPrasarana::LIST_COLUMNS)
            ->orderBy('urutan')->orderBy('id')->paginate(20);
        return view('admin.sarpras.index', compact('items'));
    }

    public function create()
    {
        return view('admin.sarpras.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis'         => 'required|string|max:255',
            'jumlah_ganjil' => 'required|integer|min:0',
            'jumlah_genap'  => 'required|integer|min:0',
            'keterangan'    => 'nullable|string|max:2000',
            'gambar'        => 'nullable|image|max:3072',
            'urutan'        => 'integer|min:0',
            'is_active'     => 'boolean',
        ]);

        unset($data['gambar']); // gambar disimpan sebagai biner di gambar_data, bukan path teks

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $sarpra = SaranaPrasarana::create($data);
        $this->saveDbImage($request, $sarpra, 'gambar');

        return redirect()->route('admin.sarpras.index')
            ->with('success', 'Sarana prasarana berhasil ditambahkan.');
    }

    public function edit(SaranaPrasarana $sarpra)
    {
        return view('admin.sarpras.form', ['item' => $sarpra]);
    }

    public function update(Request $request, SaranaPrasarana $sarpra)
    {
        $data = $request->validate([
            'jenis'         => 'required|string|max:255',
            'jumlah_ganjil' => 'required|integer|min:0',
            'jumlah_genap'  => 'required|integer|min:0',
            'keterangan'    => 'nullable|string|max:2000',
            'gambar'        => 'nullable|image|max:3072',
            'urutan'        => 'integer|min:0',
            'is_active'     => 'boolean',
        ]);

        unset($data['gambar']); // gambar baru (bila ada) disimpan sebagai biner di gambar_data

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $sarpra->update($data);
        $this->saveDbImage($request, $sarpra, 'gambar');

        return redirect()->route('admin.sarpras.index')
            ->with('success', 'Sarana prasarana berhasil diperbarui.');
    }

    public function destroy(SaranaPrasarana $sarpra)
    {
        // Gambar tersimpan sebagai biner di kolom gambar_data — ikut terhapus.
        $sarpra->delete();

        return back()->with('success', 'Sarana prasarana berhasil dihapus.');
    }

    public function toggle(SaranaPrasarana $sarpra)
    {
        $sarpra->update(['is_active' => ! $sarpra->is_active]);
        return back()->with('success', 'Status sarana prasarana diperbarui.');
    }
}
