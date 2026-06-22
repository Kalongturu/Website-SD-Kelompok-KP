<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RuangKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RuangKelasController extends Controller
{
    public function index()
    {
        $items = RuangKelas::orderBy('urutan')->orderBy('id')->paginate(20);
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

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('ruang_kelas', 'public');
        }

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        RuangKelas::create($data);

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

        if ($request->hasFile('gambar')) {
            if ($ruangKelas->gambar) Storage::disk('public')->delete($ruangKelas->gambar);
            $data['gambar'] = $request->file('gambar')->store('ruang_kelas', 'public');
        } else {
            unset($data['gambar']);
        }

        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $ruangKelas->update($data);

        return redirect()->route('admin.ruang-kelas.index')
            ->with('success', 'Data ruang kelas berhasil diperbarui.');
    }

    public function destroy(RuangKelas $ruangKelas)
    {
        if ($ruangKelas->gambar) Storage::disk('public')->delete($ruangKelas->gambar);
        $ruangKelas->delete();

        return back()->with('success', 'Data ruang kelas berhasil dihapus.');
    }

    public function toggle(RuangKelas $ruangKelas)
    {
        $ruangKelas->update(['is_active' => ! $ruangKelas->is_active]);
        return back()->with('success', 'Status ruang kelas diperbarui.');
    }
}
