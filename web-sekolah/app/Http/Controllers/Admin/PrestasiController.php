<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $items = Prestasi::orderByDesc('tanggal')->orderByDesc('id')->paginate(15);
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

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('prestasi', 'public');
        }
        $data['is_active'] = $request->boolean('is_active');

        Prestasi::create($data);

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

        if ($request->hasFile('foto')) {
            if ($prestasi->foto) Storage::disk('public')->delete($prestasi->foto);
            $data['foto'] = $request->file('foto')->store('prestasi', 'public');
        } else {
            unset($data['foto']);
        }

        $data['is_active'] = $request->boolean('is_active');

        $prestasi->update($data);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->foto) Storage::disk('public')->delete($prestasi->foto);
        $prestasi->delete();

        return back()->with('success', 'Prestasi berhasil dihapus.');
    }

    public function toggle(Prestasi $prestasi)
    {
        $prestasi->update(['is_active' => ! $prestasi->is_active]);
        return back()->with('success', 'Status prestasi diperbarui.');
    }
}
