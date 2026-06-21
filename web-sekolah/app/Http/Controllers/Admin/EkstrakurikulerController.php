<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $items = Ekstrakurikuler::orderBy('urutan')->orderBy('nama')->paginate(20);
        return view('admin.ekstrakurikuler.index', compact('items'));
    }

    public function create()
    {
        return view('admin.ekstrakurikuler.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'              => 'required|string|max:255',
            'kategori'          => 'nullable|string|max:80',
            'icon'              => 'nullable|string|max:10',
            'deskripsi_singkat' => 'nullable|string|max:500',
            'deskripsi'         => 'nullable|string',
            'jadwal'            => 'nullable|string|max:200',
            'lokasi'            => 'nullable|string|max:200',
            'pembina'           => 'nullable|string|max:100',
            'urutan'            => 'nullable|integer|min:0',
            'foto'              => 'nullable|image|max:3072',
            'is_active'         => 'boolean',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ekskul', 'public');
        }
        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $request->input('urutan', 0);

        Ekstrakurikuler::create($data);

        return redirect()->route('admin.ekskul.index')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler)
    {
        return view('admin.ekstrakurikuler.form', ['item' => $ekstrakurikuler]);
    }

    public function update(Request $request, Ekstrakurikuler $ekstrakurikuler)
    {
        $data = $request->validate([
            'nama'              => 'required|string|max:255',
            'kategori'          => 'nullable|string|max:80',
            'icon'              => 'nullable|string|max:10',
            'deskripsi_singkat' => 'nullable|string|max:500',
            'deskripsi'         => 'nullable|string',
            'jadwal'            => 'nullable|string|max:200',
            'lokasi'            => 'nullable|string|max:200',
            'pembina'           => 'nullable|string|max:100',
            'urutan'            => 'nullable|integer|min:0',
            'foto'              => 'nullable|image|max:3072',
            'is_active'         => 'boolean',
        ]);

        if ($request->hasFile('foto')) {
            if ($ekstrakurikuler->foto) Storage::disk('public')->delete($ekstrakurikuler->foto);
            $data['foto'] = $request->file('foto')->store('ekskul', 'public');
        } else {
            unset($data['foto']);
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $request->input('urutan', $ekstrakurikuler->urutan);

        $ekstrakurikuler->update($data);

        return redirect()->route('admin.ekskul.index')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        if ($ekstrakurikuler->foto) Storage::disk('public')->delete($ekstrakurikuler->foto);
        $ekstrakurikuler->delete();

        return back()->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    public function toggle(Ekstrakurikuler $ekstrakurikuler)
    {
        $ekstrakurikuler->update(['is_active' => ! $ekstrakurikuler->is_active]);
        return back()->with('success', 'Status ekstrakurikuler diperbarui.');
    }
}
