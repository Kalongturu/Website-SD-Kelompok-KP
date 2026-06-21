<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TataTertib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TataTertibController extends Controller
{
    public function index()
    {
        $items = TataTertib::orderBy('urutan')->orderBy('id')->paginate(20);
        return view('admin.tata_tertib.index', compact('items'));
    }

    public function create()
    {
        return view('admin.tata_tertib.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori'  => 'required|string|max:100',
            'icon'      => 'nullable|string|max:10',
            'isi'       => 'required|string',
            'dokumen'   => 'nullable|file|mimes:pdf|max:5120',
            'urutan'    => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('tata-tertib', 'public');
        }
        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $request->input('urutan', 0);

        TataTertib::create($data);

        return redirect()->route('admin.tata-tertib.index')
            ->with('success', 'Tata tertib berhasil ditambahkan.');
    }

    public function edit(TataTertib $tataTertib)
    {
        return view('admin.tata_tertib.form', ['item' => $tataTertib]);
    }

    public function update(Request $request, TataTertib $tataTertib)
    {
        $data = $request->validate([
            'kategori'  => 'required|string|max:100',
            'icon'      => 'nullable|string|max:10',
            'isi'       => 'required|string',
            'dokumen'   => 'nullable|file|mimes:pdf|max:5120',
            'urutan'    => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('dokumen')) {
            if ($tataTertib->dokumen) Storage::disk('public')->delete($tataTertib->dokumen);
            $data['dokumen'] = $request->file('dokumen')->store('tata-tertib', 'public');
        } else {
            unset($data['dokumen']);
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $request->input('urutan', $tataTertib->urutan);

        $tataTertib->update($data);

        return redirect()->route('admin.tata-tertib.index')
            ->with('success', 'Tata tertib berhasil diperbarui.');
    }

    public function destroy(TataTertib $tataTertib)
    {
        if ($tataTertib->dokumen) Storage::disk('public')->delete($tataTertib->dokumen);
        $tataTertib->delete();

        return back()->with('success', 'Tata tertib berhasil dihapus.');
    }

    public function toggle(TataTertib $tataTertib)
    {
        $tataTertib->update(['is_active' => ! $tataTertib->is_active]);
        return back()->with('success', 'Status tata tertib diperbarui.');
    }
}
