<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\GaleriFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::select(Galeri::LIST_COLUMNS)
            ->with(['fotos' => fn ($q) => $q->select(GaleriFoto::LIST_COLUMNS)])
            ->withCount('fotos')
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
            'gambar'     => 'required|array|min:1',   // album: minimal 1 foto
            'gambar.*'   => 'image|max:3072',
            'tanggal'    => 'nullable|date',
            'urutan'     => 'integer|min:0',
            'is_active'  => 'boolean',
        ], [
            'gambar.required' => 'Unggah minimal satu foto untuk album.',
        ]);

        unset($data['gambar']); // foto disimpan sebagai biner di tabel galeri_foto
        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $galeri = Galeri::create($data);
        $this->saveFotos($request, $galeri);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Album berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri)
    {
        $galeri->load(['fotos' => fn ($q) => $q->select(GaleriFoto::LIST_COLUMNS)]);
        return view('admin.galeri.form', ['item' => $galeri]);
    }

    public function update(Request $request, Galeri $galeri)
    {
        $data = $request->validate([
            'judul'      => 'required|string|max:255',
            'kategori'   => 'nullable|string|max:80',
            'keterangan' => 'nullable|string|max:1000',
            'gambar'     => 'nullable|array',         // foto tambahan (opsional)
            'gambar.*'   => 'image|max:3072',
            'tanggal'    => 'nullable|date',
            'urutan'     => 'integer|min:0',
            'is_active'  => 'boolean',
        ]);

        unset($data['gambar']); // foto baru (bila ada) ditambahkan ke tabel galeri_foto
        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        $galeri->update($data);
        $this->saveFotos($request, $galeri);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        // Foto album (galeri_foto) ikut terhapus lewat cascade on delete.
        $galeri->delete();

        return back()->with('success', 'Album berhasil dihapus.');
    }

    public function toggle(Galeri $galeri)
    {
        $galeri->update(['is_active' => ! $galeri->is_active]);
        return back()->with('success', 'Status album diperbarui.');
    }

    /** Hapus satu foto dari album. */
    public function destroyFoto(GaleriFoto $galeriFoto)
    {
        $galeriFoto->delete();

        return back()->with('success', 'Foto berhasil dihapus dari album.');
    }

    /**
     * Simpan setiap foto yang diupload sebagai DATA BINER (bytea) langsung ke
     * tabel `galeri_foto`. Foto ditambahkan ke urutan setelah foto yang sudah ada
     * sehingga urutan album terjaga. Mendukung banyak file sekaligus (album).
     */
    private function saveFotos(Request $request, Galeri $galeri): void
    {
        if (! $request->hasFile('gambar')) {
            return;
        }

        $urutan = (int) $galeri->fotos()->max('urutan');

        foreach ($request->file('gambar') as $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            $bytes = file_get_contents($file->getRealPath());
            $mime  = $file->getMimeType() ?: 'image/jpeg';
            $urutan++;

            $foto = $galeri->fotos()->create([
                'gambar_mime' => $mime,
                'urutan'      => $urutan,
            ]);

            // decode(?, 'base64') -> bytea. Parameter dikirim sebagai teks base64
            // (ASCII penuh) sehingga aman dari masalah encoding koneksi PDO.
            DB::update(
                "UPDATE galeri_foto SET gambar_data = decode(?, 'base64') WHERE id = ?",
                [base64_encode($bytes), $foto->id]
            );
        }
    }
}
