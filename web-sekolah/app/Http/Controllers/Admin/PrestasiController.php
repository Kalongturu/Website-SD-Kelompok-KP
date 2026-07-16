<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesDbImage;
use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    use HandlesDbImage;

    public function index()
    {
        $items = Prestasi::select(Prestasi::LIST_COLUMNS)
            ->orderByDesc('tanggal')->orderByDesc('id')->paginate(15);
        return view('admin.prestasi.index', compact('items'));
    }

    public function create()
    {
        return view('admin.prestasi.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kejuaraan' => 'required|string|max:255',
            'kategori'       => 'required|string|max:80',
            'tingkat'        => 'nullable|string|max:80',
            'peringkat'      => 'nullable|string|max:80',
            'nama_siswa'     => 'nullable|string|max:255',
            'kelas'          => 'nullable|string|max:20',
            'penyelenggara'  => 'nullable|string|max:200',
            'tanggal'        => 'nullable|date',
            'tempat'         => 'nullable|string|max:200',
            'deskripsi'      => 'nullable|string',
            'foto'           => 'nullable|image|max:3072',
            'is_active'      => 'boolean',
        ]);

        unset($data['foto']); // foto disimpan sebagai biner di foto_data, bukan path teks
        $data['is_active'] = $request->boolean('is_active');

        $prestasi = Prestasi::create($data);
        $this->saveDbImage($request, $prestasi, 'foto');

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Prestasi $prestasi)
    {
        return view('admin.prestasi.form', ['item' => $prestasi]);
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        $data = $request->validate([
            'nama_kejuaraan' => 'required|string|max:255',
            'kategori'       => 'required|string|max:80',
            'tingkat'        => 'nullable|string|max:80',
            'peringkat'      => 'nullable|string|max:80',
            'nama_siswa'     => 'nullable|string|max:255',
            'kelas'          => 'nullable|string|max:20',
            'penyelenggara'  => 'nullable|string|max:200',
            'tanggal'        => 'nullable|date',
            'tempat'         => 'nullable|string|max:200',
            'deskripsi'      => 'nullable|string',
            'foto'           => 'nullable|image|max:3072',
            'is_active'      => 'boolean',
        ]);

        unset($data['foto']); // foto baru (bila ada) disimpan sebagai biner di foto_data

        $data['is_active'] = $request->boolean('is_active');

        $prestasi->update($data);
        $this->saveDbImage($request, $prestasi, 'foto');

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        // Foto tersimpan sebagai biner di kolom foto_data — ikut terhapus.
        $prestasi->delete();

        return back()->with('success', 'Prestasi berhasil dihapus.');
    }

    public function toggle(Prestasi $prestasi)
    {
        $prestasi->update(['is_active' => ! $prestasi->is_active]);
        return back()->with('success', 'Status prestasi diperbarui.');
    }
}
