<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesDbImage;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    use HandlesDbImage;

    public function index()
    {
        $items = Siswa::select(Siswa::LIST_COLUMNS)->latest()->paginate(20);
        return view('admin.siswa.index', compact('items'));
    }

    public function create()
    {
        return view('admin.siswa.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validasi($request);

        unset($data['foto']); // foto disimpan sebagai biner di foto_data, bukan path teks

        $siswa = Siswa::create($data);
        $this->saveDbImage($request, $siswa, 'foto');

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa)
    {
        return view('admin.siswa.form', ['item' => $siswa]);
    }

    public function update(Request $request, Siswa $siswa)
    {
        $data = $this->validasi($request);

        unset($data['foto']); // foto baru (bila ada) disimpan sebagai biner di foto_data

        $siswa->update($data);
        $this->saveDbImage($request, $siswa, 'foto');

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        // Foto tersimpan sebagai biner di kolom foto_data — ikut terhapus.
        $siswa->delete();

        return back()->with('success', 'Data siswa berhasil dihapus.');
    }

    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama'      => 'required|string|max:255',
            'nis'       => 'nullable|string|max:50',
            'kelas'     => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'foto'      => 'nullable|image|max:3072',
        ]);
    }
}
