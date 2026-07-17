<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KalenderAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KalenderAkademikController extends Controller
{
    public function index()
    {
        $items = KalenderAkademik::query()
            ->orderBy('urutan')
            ->orderByDesc('tahun_ajaran')
            ->paginate(20);

        return view('admin.kalender_akademik.index', compact('items'));
    }

    public function create()
    {
        return view('admin.kalender_akademik.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'tahun_ajaran' => str_replace([' ', '-'], ['', '/'], (string) $request->input('tahun_ajaran')),
        ]);

        $data = $request->validate([
            'tahun_ajaran' => ['required', 'string', 'max:20', 'regex:/^\d{4}\s*[\/-]\s*\d{4}$/', 'unique:kalender_akademik_dokumen,tahun_ajaran'],
            'file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ], [
            'tahun_ajaran.regex' => 'Tahun ajaran harus menggunakan format seperti 2026/2027.',
            'tahun_ajaran.unique' => 'Tahun ajaran tersebut sudah tersedia.',
            'file.required' => 'File kalender wajib diunggah.',
            'file.mimes' => 'File kalender harus berformat PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file kalender maksimal 10 MB.',
        ]);

        $data['file_name'] = $request->file('file')->getClientOriginalName();
        $data['urutan'] = $request->integer('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');
        unset($data['file']);

        $kalender = KalenderAkademik::create($data);
        $this->simpanFileBlob($request, $kalender);

        return redirect()->route('admin.kalender-akademik.index')
            ->with('success', 'Kalender akademik berhasil ditambahkan.');
    }

    public function edit(KalenderAkademik $kalenderAkademik)
    {
        return view('admin.kalender_akademik.form', ['item' => $kalenderAkademik]);
    }

    public function update(Request $request, KalenderAkademik $kalenderAkademik)
    {
        $request->merge([
            'tahun_ajaran' => str_replace([' ', '-'], ['', '/'], (string) $request->input('tahun_ajaran')),
        ]);

        $data = $request->validate([
            'tahun_ajaran' => [
                'required',
                'string',
                'max:20',
                'regex:/^\d{4}\s*[\/-]\s*\d{4}$/',
                Rule::unique('kalender_akademik_dokumen', 'tahun_ajaran')->ignore($kalenderAkademik->id),
            ],
            'file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:10240'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ], [
            'tahun_ajaran.regex' => 'Tahun ajaran harus menggunakan format seperti 2026/2027.',
            'tahun_ajaran.unique' => 'Tahun ajaran tersebut sudah tersedia.',
            'file.mimes' => 'File kalender harus berformat PDF, JPG, JPEG, atau PNG.',
            'file.max' => 'Ukuran file kalender maksimal 10 MB.',
        ]);

        if ($request->hasFile('file')) {
            $data['file_name'] = $request->file('file')->getClientOriginalName();
        }

        $data['urutan'] = $request->integer('urutan', 0);
        $data['is_active'] = $request->boolean('is_active');
        unset($data['file']);

        $kalenderAkademik->update($data);
        $this->simpanFileBlob($request, $kalenderAkademik);

        return redirect()->route('admin.kalender-akademik.index')
            ->with('success', 'Kalender akademik berhasil diperbarui.');
    }

    public function destroy(KalenderAkademik $kalenderAkademik)
    {
        // File tersimpan sebagai biner di kolom file_data — ikut terhapus.
        $kalenderAkademik->delete();

        return back()->with('success', 'Kalender akademik berhasil dihapus.');
    }

    public function toggle(KalenderAkademik $kalenderAkademik)
    {
        $kalenderAkademik->update(['is_active' => ! $kalenderAkademik->is_active]);

        return back()->with('success', 'Status kalender akademik berhasil diperbarui.');
    }

    /**
     * Simpan file yang diupload sebagai DATA BINER (bytea) ke kolom `file_data`
     * + `file_mime`, dan kosongkan path lama agar sumber file hanya satu.
     */
    private function simpanFileBlob(Request $request, KalenderAkademik $kalender): void
    {
        if (! $request->hasFile('file')) {
            return;
        }

        $file  = $request->file('file');
        $bytes = file_get_contents($file->getRealPath());
        $mime  = $file->getMimeType() ?: 'application/octet-stream';

        // decode(?, 'base64') -> bytea. Parameter dikirim sebagai teks base64
        // (ASCII penuh) sehingga aman dari masalah encoding koneksi PDO.
        DB::update(
            "UPDATE kalender_akademik_dokumen
             SET file_data = decode(?, 'base64'), file_mime = ?, file_path = NULL, updated_at = ?
             WHERE id = ?",
            [base64_encode($bytes), $mime, now()->toDateTimeString(), $kalender->id]
        );
    }
}
