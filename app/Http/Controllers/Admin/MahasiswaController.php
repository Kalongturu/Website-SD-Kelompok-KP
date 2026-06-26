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
        $mahasiswa = Mahasiswa::latest()->paginate(15);
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('admin.mahasiswa.form', ['mahasiswa' => new Mahasiswa()]);
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        Mahasiswa::create($data);

        return redirect()->route('admin.mahasiswa.index')->with('sukses', 'Data mahasiswa ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.form', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $data = $this->validasi($request);

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        $mahasiswa->update($data);

        return redirect()->route('admin.mahasiswa.index')->with('sukses', 'Data mahasiswa diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->foto) {
            Storage::disk('public')->delete($mahasiswa->foto);
        }
        $mahasiswa->delete();

        return redirect()->route('admin.mahasiswa.index')->with('sukses', 'Data mahasiswa dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['nullable', 'string', 'max:50'],
            'jurusan' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
