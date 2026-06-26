<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaranaPrasarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SarprasController extends Controller
{
    public function index()
    {
        $items = SaranaPrasarana::orderBy('urutan')->orderBy('id')->paginate(20);
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

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('sarpras', 'public');
        }

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        SaranaPrasarana::create($data);

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

        if ($request->hasFile('gambar')) {
            if ($sarpra->gambar) Storage::disk('public')->delete($sarpra->gambar);
            $data['gambar'] = $request->file('gambar')->store('sarpras', 'public');
        } else {
            unset($data['gambar']);
        }

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $sarpra->update($data);

        return redirect()->route('admin.sarpras.index')
            ->with('success', 'Sarana prasarana berhasil diperbarui.');
    }

    public function destroy(SaranaPrasarana $sarpra)
    {
        if ($sarpra->gambar) Storage::disk('public')->delete($sarpra->gambar);
        $sarpra->delete();

        return back()->with('success', 'Sarana prasarana berhasil dihapus.');
    }

    public function toggle(SaranaPrasarana $sarpra)
    {
        $sarpra->update(['is_active' => ! $sarpra->is_active]);
        return back()->with('success', 'Status sarana prasarana diperbarui.');
    }
}
