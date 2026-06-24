<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::select(Galeri::LIST_COLUMNS)
            ->orderBy('urutan')->orderByDesc('tanggal')->orderByDesc('id')->paginate(20);
        return view('admin.galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('admin.galeri.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'kategori'   => 'nullable|string|max:80',
            'keterangan' => 'nullable|string|max:1000',
            'gambar'     => 'required|image|max:3072',
            'tanggal'    => 'nullable|date',
            'urutan'     => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        unset($data['gambar']); // gambar disimpan sebagai biner di gambar_data, bukan path teks
        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $galeri = Galeri::create($data);
        $this->saveGambar($request, $galeri);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.form', ['item' => $galeri]);
    }

    public function update(Request $request, Galeri $galeri)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'kategori'   => 'nullable|string|max:80',
            'keterangan' => 'nullable|string|max:1000',
            'gambar'     => 'nullable|image|max:3072',
            'tanggal'    => 'nullable|date',
            'urutan'     => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        unset($data['gambar']); // gambar baru (bila ada) disimpan sebagai biner di gambar_data
        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $galeri->update($data);
        $this->saveGambar($request, $galeri);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        // Gambar tersimpan sebagai biner di kolom gambar_data — ikut terhapus.
        $galeri->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }

    public function toggle(Galeri $galeri)
    {
        $galeri->update(['is_active' => ! $galeri->is_active]);
        return back()->with('success', 'Status foto diperbarui.');
    }

    /**
     * Simpan gambar yang diupload sebagai DATA BINER (bytea) langsung ke kolom
     * `gambar_data` — bukan path teks. Dengan begitu gambarnya ikut tersimpan di
     * database bersama dan terbaca sebagai berkas gambar.
     */
    private function saveGambar(Request $request, Galeri $galeri): void
    {
        if (! $request->hasFile('gambar')) {
            return;
        }

        $file  = $request->file('gambar');
        $bytes = file_get_contents($file->getRealPath());
        $mime  = $file->getMimeType() ?: 'image/jpeg';

        // decode(?, 'base64') -> bytea. Parameter dikirim sebagai teks base64
        // (ASCII penuh) sehingga aman dari masalah encoding koneksi PDO.
        DB::update(
            "UPDATE galeri SET gambar_data = decode(?, 'base64'), gambar_mime = ?, gambar = NULL, updated_at = ? WHERE id = ?",
            [base64_encode($bytes), $mime, now()->toDateTimeString(), $galeri->id]
        );
    }
}
