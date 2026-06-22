<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EBookController extends Controller
{
    public function index()
    {
        $items = EBook::orderBy('urutan')->orderBy('id')->paginate(20);
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

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('ebooks/cover', 'public');
        }

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        EBook::create($data);

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

        if ($request->hasFile('cover')) {
            if ($ebook->cover) Storage::disk('public')->delete($ebook->cover);
            $data['cover'] = $request->file('cover')->store('ebooks/cover', 'public');
        } else {
            unset($data['cover']);
        }

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $ebook->update($data);

        return redirect()->route('admin.ebook.index')
            ->with('success', 'E-Book berhasil diperbarui.');
    }

    public function destroy(EBook $ebook)
    {
        if ($ebook->cover) Storage::disk('public')->delete($ebook->cover);
        $ebook->delete();

        return back()->with('success', 'E-Book berhasil dihapus.');
    }

    public function toggle(EBook $ebook)
    {
        $ebook->update(['is_active' => ! $ebook->is_active]);
        return back()->with('success', 'Status E-Book diperbarui.');
    }
}
