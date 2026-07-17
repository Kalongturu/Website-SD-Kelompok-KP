<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Sebagian record E-Book (cover) & Video Pembelajaran (thumbnail kustom) masih
     * menyimpan gambar sebagai PATH TEKS di kolom string, bukan sebagai DATA BINER
     * (bytea) seperti pola situs lainnya.
     *
     * Migration ini menyeragamkannya:
     *  - Bila berkas gambar masih ada di disk → dibaca lalu disimpan sebagai blob
     *    di kolom `<field>_data` + `<field>_mime`, kolom path dikosongkan.
     *  - Bila berkas sudah tidak ada (menggantung) → kolom path dikosongkan saja,
     *    supaya tampilan jatuh ke placeholder / thumbnail YouTube dengan benar.
     */
    public function up(): void
    {
        $this->migrateTable('ebooks', 'cover');
        $this->migrateTable('video_pembelajaran', 'thumbnail');
    }

    private function migrateTable(string $table, string $field): void
    {
        $rows = DB::table($table)
            ->whereNotNull($field)
            ->where($field, '!=', '')
            ->whereNull($field . '_data')
            ->get(['id', $field]);

        foreach ($rows as $row) {
            $path = $row->$field;

            // Lewati path yang sudah berupa URL http(s) eksternal — biarkan apa adanya.
            if (preg_match('#^https?://#i', $path)) {
                continue;
            }

            $full = storage_path('app/public/' . ltrim($path, '/'));

            if (is_file($full) && is_readable($full)) {
                $bytes = file_get_contents($full);
                $mime  = mime_content_type($full) ?: 'image/jpeg';

                DB::update(
                    sprintf(
                        'UPDATE %s SET %s_data = decode(?, \'base64\'), %s_mime = ?, %s = NULL WHERE id = ?',
                        $table, $field, $field, $field
                    ),
                    [base64_encode($bytes), $mime, $row->id]
                );
            } else {
                // Berkas hilang → kosongkan path menggantung agar tampilan bersih.
                DB::table($table)->where('id', $row->id)->update([$field => null]);
            }
        }
    }

    public function down(): void
    {
        // Tidak dapat memulihkan path lama; tidak ada yang dikembalikan.
    }
};
