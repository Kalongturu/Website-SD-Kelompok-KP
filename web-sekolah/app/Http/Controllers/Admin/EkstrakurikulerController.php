<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesDbImage;
use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    use HandlesDbImage;

    public function index()
    {
        $items = Ekstrakurikuler::select(Ekstrakurikuler::LIST_COLUMNS)
            ->orderBy('urutan')->orderBy('nama')->paginate(20);
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

        unset($data['foto']); // foto disimpan sebagai biner di foto_data, bukan path teks
        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $request->input('urutan', 0);

        $ekstrakurikuler = Ekstrakurikuler::create($data);
        $this->saveDbImage($request, $ekstrakurikuler, 'foto');

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

        unset($data['foto']); // foto baru (bila ada) disimpan sebagai biner di foto_data

        $data['is_active'] = $request->boolean('is_active');
        $data['urutan']    = $request->input('urutan', $ekstrakurikuler->urutan);

        $ekstrakurikuler->update($data);
        $this->saveDbImage($request, $ekstrakurikuler, 'foto');

        return redirect()->route('admin.ekskul.index')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler)
    {
        // Foto tersimpan sebagai biner di kolom foto_data — ikut terhapus.
        $ekstrakurikuler->delete();

        return back()->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }

    public function toggle(Ekstrakurikuler $ekstrakurikuler)
    {
        $ekstrakurikuler->update(['is_active' => ! $ekstrakurikuler->is_active]);
        return back()->with('success', 'Status ekstrakurikuler diperbarui.');
    }
}
