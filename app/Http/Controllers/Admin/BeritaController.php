<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::orderByDesc('tanggal')->orderByDesc('id')->paginate(15);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:80',
            'ringkasan' => 'nullable|string|max:500',
            'isi'       => 'required|string',
            'gambar'    => 'nullable|image|max:2048',
            'penulis'   => 'nullable|string|max:100',
            'tanggal'   => 'required|date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $data['is_active'] = $request->boolean('is_active');

        Berita::create($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.form', ['item' => $berita]);
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:80',
            'ringkasan' => 'nullable|string|max:500',
            'isi'       => 'required|string',
            'gambar'    => 'nullable|image|max:2048',
            'penulis'   => 'nullable|string|max:100',
            'tanggal'   => 'required|date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        } else {
            unset($data['gambar']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $berita->update($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) Storage::disk('public')->delete($berita->gambar);
        $berita->delete();

        return back()->with('success', 'Berita berhasil dihapus.');
    }

    public function toggle(Berita $berita)
    {
        $berita->update(['is_active' => ! $berita->is_active]);
        return back()->with('success', 'Status berita diperbarui.');
    }
}
