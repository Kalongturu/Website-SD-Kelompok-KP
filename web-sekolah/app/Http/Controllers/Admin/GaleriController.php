<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::orderBy('urutan')->orderByDesc('tanggal')->orderByDesc('id')->paginate(20);
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'kategori'   => 'nullable|string|max:80',
            'keterangan' => 'nullable|string|max:1000',
            'gambar'     => 'required|image|max:3072',
            'tanggal'    => 'nullable|date',
            'urutan'     => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $data['gambar']    = $request->file('gambar')->store('galeri', 'public');
        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        Galeri::create($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.form', ['item' => $galeri]);
    }

    public function update(Request $request, Galeri $galeri)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'kategori'   => 'nullable|string|max:80',
            'keterangan' => 'nullable|string|max:1000',
            'gambar'     => 'nullable|image|max:3072',
            'tanggal'    => 'nullable|date',
            'urutan'     => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($galeri->gambar) Storage::disk('public')->delete($galeri->gambar);
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        } else {
            unset($data['gambar']);
        }

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri->gambar) Storage::disk('public')->delete($galeri->gambar);
        $galeri->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function toggle(Galeri $galeri)
    {
        $galeri->update(['is_active' => ! $galeri->is_active]);
        return back()->with('success', 'Status foto diperbarui.');
    }
}
