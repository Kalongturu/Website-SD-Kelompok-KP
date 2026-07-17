<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesDbImage;
use App\Http\Controllers\Controller;
use App\Models\EBook;
use Illuminate\Http\Request;

class EBookController extends Controller
{
    use HandlesDbImage;

    public function index()
    {
        $items = EBook::select(EBook::LIST_COLUMNS)
            ->orderBy('urutan')->orderBy('id')->paginate(20);
        return view('admin.ebook.index', compact('items'));
    }

    public function create()
    {
        return view('admin.ebook.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'          => 'required|string|max:255',
            'penulis'        => 'nullable|string|max:255',
            'penerbit'       => 'nullable|string|max:255',
            'mata_pelajaran' => 'nullable|string|max:100',
            'kelas'          => 'nullable|string|max:50',
            'deskripsi'      => 'nullable|string|max:2000',
            'link_url'       => 'required|url|max:500',
            'cover'          => 'nullable|image|max:2048',
            'urutan'         => 'integer|min:0',
            'is_active'      => 'boolean',
        ]);

        unset($data['cover']); // cover disimpan sebagai biner di cover_data, bukan path teks

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $ebook = EBook::create($data);
        $this->saveDbImage($request, $ebook, 'cover');

        return redirect()->route('admin.ebook.index')
            ->with('success', 'E-Book berhasil ditambahkan.');
    }

    public function edit(EBook $ebook)
    {
        return view('admin.ebook.form', ['item' => $ebook]);
    }

    public function update(Request $request, EBook $ebook)
    {
        $data = $request->validate([
            'judul'          => 'required|string|max:255',
            'penulis'        => 'nullable|string|max:255',
            'penerbit'       => 'nullable|string|max:255',
            'mata_pelajaran' => 'nullable|string|max:100',
            'kelas'          => 'nullable|string|max:50',
            'deskripsi'      => 'nullable|string|max:2000',
            'link_url'       => 'required|url|max:500',
            'cover'          => 'nullable|image|max:2048',
            'urutan'         => 'integer|min:0',
            'is_active'      => 'boolean',
        ]);

        unset($data['cover']); // cover baru (bila ada) disimpan sebagai biner di cover_data

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $ebook->update($data);
        $this->saveDbImage($request, $ebook, 'cover');

        return redirect()->route('admin.ebook.index')
            ->with('success', 'E-Book berhasil diperbarui.');
    }

    public function destroy(EBook $ebook)
    {
        // Cover tersimpan sebagai biner di kolom cover_data — ikut terhapus.
        $ebook->delete();

        return back()->with('success', 'E-Book berhasil dihapus.');
    }

    public function toggle(EBook $ebook)
    {
        $ebook->update(['is_active' => ! $ebook->is_active]);
        return back()->with('success', 'Status E-Book diperbarui.');
    }
}
