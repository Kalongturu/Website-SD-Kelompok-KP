<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::select(Berita::LIST_COLUMNS)
            ->orderByDesc('tanggal')->orderByDesc('id')->paginate(15);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        return view('admin.berita.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        unset($data['gambar']); // gambar disimpan sebagai biner di gambar_data, bukan path teks

        $data['is_active'] = $request->boolean('is_active');

        $berita = Berita::create($data);
        $this->saveGambar($request, $berita);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.form', ['item' => $berita]);
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $this->validateData($request);
        unset($data['gambar']); // gambar baru (bila ada) disimpan sebagai biner di gambar_data

        $data['is_active'] = $request->boolean('is_active');

        $berita->update($data);
        $this->saveGambar($request, $berita);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        // Gambar tersimpan sebagai biner di kolom gambar_data — ikut terhapus
        // otomatis saat record dihapus, jadi tak ada file disk yang perlu dibersihkan.
        $berita->delete();

        return back()->with('success', 'Berita berhasil dihapus.');
    }

    public function toggle(Berita $berita)
    {
        $berita->update(['is_active' => ! $berita->is_active]);
        return back()->with('success', 'Status berita diperbarui.');
    }

    /**
     * Simpan gambar yang diupload sebagai DATA BINER (bytea) langsung ke kolom
     * `gambar_data` di tabel berita — bukan path teks. Dengan begitu gambarnya ikut
     * tersimpan di database bersama dan tampil di semua sistem yang terhubung.
     */
    private function saveGambar(Request $request, Berita $berita): void
    {
        if (! $request->hasFile('gambar')) {
            return;
        }

        $file  = $request->file('gambar');
        $bytes = file_get_contents($file->getRealPath());
        $mime  = $file->getMimeType() ?: 'image/jpeg';

        // decode(?, 'base64') -> bytea. Parameter dikirim sebagai teks base64
        // (seluruhnya ASCII) sehingga aman dari masalah encoding koneksi.
        // gambar (path lama) dikosongkan agar URL gambar memakai route bytea.
        DB::update(
            "UPDATE berita SET gambar_data = decode(?, 'base64'), gambar_mime = ?, gambar = NULL, updated_at = ? WHERE id = ?",
            [base64_encode($bytes), $mime, now()->toDateTimeString(), $berita->id]
        );
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'nullable|string|max:80',
            'ringkasan' => 'nullable|string|max:500',
            'isi'       => 'required|string',
            'gambar'    => 'nullable|image|max:2048',
            'penulis'   => 'nullable|string|max:100',
            'tanggal'   => 'required|date',
            'is_active' => 'boolean',
        ]);
    }
}
