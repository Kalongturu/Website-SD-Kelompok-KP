<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Menyimpan & menyajikan gambar sebagai DATA BINER (bytea) langsung di database,
 * mengikuti pola yang sudah dipakai berita/galeri/guru. Dengan begitu gambar ikut
 * tersimpan bersama datanya di Neon DB dan dapat dilihat SEMUA user — tidak
 * bergantung pada file di storage disk lokal yang hanya ada di satu mesin.
 */
trait HandlesDbImage
{
    /**
     * Simpan file yang diupload ke kolom biner `<field>_data` + `<field>_mime`.
     * Kolom path lama dikosongkan agar tidak ada dua sumber gambar yang bentrok.
     *
     * @param string $field nama input file sekaligus prefix kolom (mis. "foto")
     */
    protected function saveDbImage(Request $request, Model $model, string $field): void
    {
        if (! $request->hasFile($field)) {
            return;
        }

        $file  = $request->file($field);
        $bytes = file_get_contents($file->getRealPath());
        $mime  = $file->getMimeType() ?: 'image/jpeg';

        // decode(?, 'base64') -> bytea. Parameter dikirim sebagai teks base64
        // (ASCII penuh) sehingga aman dari masalah encoding koneksi PDO.
        DB::update(
            sprintf(
                'UPDATE %s SET %s_data = decode(?, \'base64\'), %s_mime = ?, %s = NULL, updated_at = ? WHERE id = ?',
                $model->getTable(),
                $field,
                $field,
                $field
            ),
            [base64_encode($bytes), $mime, now()->toDateTimeString(), $model->getKey()]
        );
    }

    /**
     * Sajikan gambar dari kolom biner sebagai HTTP response. Byte diambil sebagai
     * base64 lalu di-decode agar andal lintas driver PDO (tidak bergantung pada
     * cara PDO mengembalikan bytea sebagai stream/teks).
     */
    protected function serveDbImage(Model $model, string $field)
    {
        $row = DB::table($model->getTable())
            ->where('id', $model->getKey())
            ->selectRaw("encode({$field}_data, 'base64') as b64, {$field}_mime as mime")
            ->first();

        abort_if(! $row || empty($row->b64), 404);

        $bytes = base64_decode($row->b64);

        return response($bytes)
            ->header('Content-Type', $row->mime ?: 'image/jpeg')
            ->header('Content-Length', (string) strlen($bytes))
            ->header('Cache-Control', 'public, max-age=86400');
    }
}
