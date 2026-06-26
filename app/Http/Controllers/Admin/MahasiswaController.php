<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index()
    {
        $items = Mahasiswa::latest()->paginate(20);
        return view('admin.mahasiswa.index', compact('items'));
    }

    public function create()
    {
        return view('admin.mahasiswa.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        Mahasiswa::create($data);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.form', ['item' => $mahasiswa]);
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $data = $this->validasi($request);

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto) Storage::disk('public')->delete($mahasiswa->foto);
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        } else {
            unset($data['foto']);
        }

        $mahasiswa->update($data);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->foto) Storage::disk('public')->delete($mahasiswa->foto);
        $mahasiswa->delete();

        return back()->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama'      => 'required|string|max:255',
            'nim'       => 'nullable|string|max:50',
            'jurusan'   => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|max:3072',
        ]);
    }
}
