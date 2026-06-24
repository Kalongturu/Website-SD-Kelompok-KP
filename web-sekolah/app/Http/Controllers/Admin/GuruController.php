<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index()
    {
        $items = Guru::select(Guru::LIST_COLUMNS)
            ->orderByDesc('is_kepala')->orderBy('urutan')->orderBy('id')->paginate(24);
        return view('admin.guru.index', compact('items'));
    }

    public function create()
    {
        return view('admin.guru.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        unset($data['foto']); // foto disimpan sebagai biner di foto_data, bukan path teks

        $data['is_kepala'] = $request->boolean('is_kepala');
        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        // Hanya boleh ada satu Kepala Sekolah yang menjadi sorotan utama.
        if ($data['is_kepala']) {
            Guru::where('is_kepala', true)->update(['is_kepala' => false]);
        }

        $guru = Guru::create($data);
        $this->saveFoto($request, $guru);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru / staf berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('admin.guru.form', ['item' => $guru]);
    }

    public function update(Request $request, Guru $guru)
    {
        $data = $this->validateData($request);
        unset($data['foto']); // foto baru (bila ada) disimpan sebagai biner di foto_data

        $data['is_kepala'] = $request->boolean('is_kepala');
        $data['urutan']    = $request->input('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');

        // Hanya boleh ada satu Kepala Sekolah — turunkan status yang lain.
        if ($data['is_kepala']) {
            Guru::where('is_kepala', true)->where('id', '!=', $guru->id)->update(['is_kepala' => false]);
        }

        $guru->update($data);
        $this->saveFoto($request, $guru);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru / staf berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        // Foto tersimpan sebagai biner di kolom foto_data — ikut terhapus
        // otomatis saat record dihapus, jadi tak ada file disk yang perlu dibersihkan.
        $guru->delete();

        return back()->with('success', 'Data guru / staf berhasil dihapus.');
    }

    public function toggle(Guru $guru)
    {
        $guru->update(['is_active' => ! $guru->is_active]);
        return back()->with('success', 'Status guru / staf diperbarui.');
    }

    /**
     * Simpan foto yang diupload sebagai DATA BINER (bytea) langsung ke kolom
     * `foto_data` di tabel guru — bukan path teks. Dengan begitu gambarnya ikut
     * tersimpan di database bersama dan terbaca sistem lain sebagai berkas gambar.
     */
    private function saveFoto(Request $request, Guru $guru): void
    {
        if (! $request->hasFile('foto')) {
            return;
        }

        $file  = $request->file('foto');
        $bytes = file_get_contents($file->getRealPath());
        $mime  = $file->getMimeType() ?: 'image/jpeg';

        // decode(?, 'base64') -> bytea. Parameter dikirim sebagai teks base64
        // (seluruhnya ASCII) sehingga aman dari masalah encoding koneksi.
        DB::update(
            "UPDATE guru SET foto_data = decode(?, 'base64'), foto_mime = ?, updated_at = ? WHERE id = ?",
            [base64_encode($bytes), $mime, now()->toDateTimeString(), $guru->id]
        );
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama'      => 'required|string|max:150',
            'jabatan'   => 'required|string|max:150',
            'nip'       => 'nullable|string|max:50',
            'foto'      => 'nullable|image|max:3072',
            'is_kepala' => 'boolean',
            'urutan'    => 'integer|min:0',
            'is_active' => 'boolean',
        ]);
    }
}
