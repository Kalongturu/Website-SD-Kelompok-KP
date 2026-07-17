<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * File kalender akademik (PDF/gambar) masih tersimpan sebagai PATH TEKS di
     * kolom `file_path`. Samakan dengan pola situs lainnya: simpan sebagai DATA
     * BINER (bytea) di database agar ikut tersimpan bersama datanya dan bisa
     * diakses semua user tanpa bergantung file di disk lokal.
     *
     *  - file_data : isi byte file (bytea)
     *  - file_mime : tipe MIME (mis. application/pdf) untuk Content-Type
     *
     * Kolom lama `file_path` dipertahankan (nullable) sebagai fallback.
     */
    public function up(): void
    {
        Schema::table('kalender_akademik_dokumen', function (Blueprint $table) {
            if (! Schema::hasColumn('kalender_akademik_dokumen', 'file_data')) {
                $table->binary('file_data')->nullable();      // -> bytea di PostgreSQL
            }
            if (! Schema::hasColumn('kalender_akademik_dokumen', 'file_mime')) {
                $table->string('file_mime', 100)->nullable();
            }
        });

        // Kolom path lama tidak lagi wajib (record baru memakai blob).
        DB::statement('ALTER TABLE kalender_akademik_dokumen ALTER COLUMN file_path DROP NOT NULL');

        // Pindahkan file yang masih ada di disk menjadi blob; yang menggantung
        // (file sudah tidak ada) path-nya dikosongkan agar tampilan bersih.
        $rows = DB::table('kalender_akademik_dokumen')
            ->whereNotNull('file_path')->where('file_path', '!=', '')
            ->whereNull('file_data')
            ->get(['id', 'file_path']);

        foreach ($rows as $row) {
            if (preg_match('#^https?://#i', $row->file_path)) {
                continue; // URL eksternal — biarkan.
            }

            $full = storage_path('app/public/' . ltrim($row->file_path, '/'));

            if (is_file($full) && is_readable($full)) {
                $bytes = file_get_contents($full);
                $mime  = mime_content_type($full) ?: 'application/octet-stream';

                DB::update(
                    "UPDATE kalender_akademik_dokumen
                     SET file_data = decode(?, 'base64'), file_mime = ?, file_path = NULL
                     WHERE id = ?",
                    [base64_encode($bytes), $mime, $row->id]
                );
            } else {
                DB::table('kalender_akademik_dokumen')->where('id', $row->id)->update(['file_path' => null]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('kalender_akademik_dokumen', function (Blueprint $table) {
            foreach (['file_data', 'file_mime'] as $col) {
                if (Schema::hasColumn('kalender_akademik_dokumen', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
