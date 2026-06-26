<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::select(Pengumuman::LIST_COLUMNS)
            ->orderByDesc('tanggal')->orderByDesc('id')->paginate(15);
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        unset($data['lampiran']); // lampiran disimpan sebagai biner di lampiran_data, bukan path teks

        $data['penting']   = $request->boolean('penting');
        $data['is_active'] = $request->boolean('is_active');

        $pengumuman = Pengumuman::create($data);
        $this->saveLampiran($request, $pengumuman);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.form', ['item' => $pengumuman]);
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $this->validateData($request);
        unset($data['lampiran']); // lampiran baru (bila ada) disimpan sebagai biner di lampiran_data

        $data['penting']   = $request->boolean('penting');
        $data['is_active'] = $request->boolean('is_active');

        $pengumuman->update($data);
        $this->saveLampiran($request, $pengumuman);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        // Lampiran tersimpan sebagai biner di kolom lampiran_data — ikut terhapus
        // otomatis saat record dihapus, jadi tak ada file disk yang perlu dibersihkan.
        $pengumuman->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function toggle(Pengumuman $pengumuman)
    {
        $pengumuman->update(['is_active' => ! $pengumuman->is_active]);
        return back()->with('success', 'Status pengumuman diperbarui.');
    }

    /**
     * Simpan lampiran yang diupload sebagai DATA BINER (bytea) langsung ke kolom
     * `lampiran_data` di tabel pengumuman — bukan path teks. Dengan begitu berkasnya
     * ikut tersimpan di database bersama dan bisa diunduh dari semua sistem terhubung.
     */
    private function saveLampiran(Request $request, Pengumuman $pengumuman): void
    {
        if (! $request->hasFile('lampiran')) {
            return;
        }

        $file  = $request->file('lampiran');
        $bytes = file_get_contents($file->getRealPath());
        $mime  = $file->getMimeType() ?: 'application/octet-stream';
        $nama  = $file->getClientOriginalName();

        // decode(?, 'base64') -> bytea. Parameter dikirim sebagai teks base64
        // (seluruhnya ASCII) sehingga aman dari masalah encoding koneksi.
        // lampiran (path lama) dikosongkan agar URL lampiran memakai route bytea.
        DB::update(
            "UPDATE pengumuman SET lampiran_data = decode(?, 'base64'), lampiran_mime = ?, lampiran_nama = ?, lampiran = NULL, updated_at = ? WHERE id = ?",
            [base64_encode($bytes), $mime, $nama, now()->toDateTimeString(), $pengumuman->id]
        );
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'judul'     => 'required|string|max:255',
            'ringkasan' => 'nullable|string|max:500',
            'isi'       => 'required|string',
            'lampiran'  => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'penting'   => 'boolean',
            'tanggal'   => 'required|date',
            'is_active' => 'boolean',
        ]);
    }
}
