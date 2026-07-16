<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\HandlesDbImage;
use App\Http\Controllers\Controller;
use App\Models\RuangKelas;
use Illuminate\Http\Request;

class RuangKelasController extends Controller
{
    use HandlesDbImage;

    public function index()
    {
        $items = RuangKelas::select(RuangKelas::LIST_COLUMNS)
            ->orderBy('urutan')->orderBy('id')->paginate(20);
        return view('admin.ruang_kelas.index', compact('items'));
    }

    public function create()
    {
        return view('admin.ruang_kelas.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kelas'   => 'required|string|max:100',
            'jumlah_siswa' => 'required|integer|min:0',
            'keterangan'   => 'nullable|string|max:2000',
            'gambar'       => 'nullable|image|max:3072',
            'urutan'       => 'integer|min:0',
            'is_active'    => 'boolean',
        ]);

        unset($data['gambar']); // gambar disimpan sebagai biner di gambar_data, bukan path teks

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $ruangKelas = RuangKelas::create($data);
        $this->saveDbImage($request, $ruangKelas, 'gambar');

        return redirect()->route('admin.ruang-kelas.index')
            ->with('success', 'Data ruang kelas berhasil ditambahkan.');
    }

    public function edit(RuangKelas $ruangKelas)
    {
        return view('admin.ruang_kelas.form', ['item' => $ruangKelas]);
    }

    public function update(Request $request, RuangKelas $ruangKelas)
    {
        $data = $request->validate([
            'nama_kelas'   => 'required|string|max:100',
            'jumlah_siswa' => 'required|integer|min:0',
            'keterangan'   => 'nullable|string|max:2000',
            'gambar'       => 'nullable|image|max:3072',
            'urutan'       => 'integer|min:0',
            'is_active'    => 'boolean',
        ]);

        unset($data['gambar']); // gambar baru (bila ada) disimpan sebagai biner di gambar_data

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $ruangKelas->update($data);
        $this->saveDbImage($request, $ruangKelas, 'gambar');

        return redirect()->route('admin.ruang-kelas.index')
            ->with('success', 'Data ruang kelas berhasil diperbarui.');
    }

    public function destroy(RuangKelas $ruangKelas)
    {
        // Gambar tersimpan sebagai biner di kolom gambar_data — ikut terhapus.
        $ruangKelas->delete();

        return back()->with('success', 'Data ruang kelas berhasil dihapus.');
    }

    public function toggle(RuangKelas $ruangKelas)
    {
        $ruangKelas->update(['is_active' => ! $ruangKelas->is_active]);
        return back()->with('success', 'Status ruang kelas diperbarui.');
    }
}
