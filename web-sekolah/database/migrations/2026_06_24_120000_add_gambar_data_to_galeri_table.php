<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Foto galeri disimpan sebagai DATA BINER (bytea) langsung di tabel `galeri`,
     * mengikuti pola berita/guru. Dengan begitu gambar ikut tersimpan di database —
     * tidak bergantung pada folder storage di disk yang tidak persisten di hosting
     * dan butuh `storage:link`.
     *
     * - gambar_data : isi byte gambar (bytea)
     * - gambar_mime : tipe MIME gambar (mis. image/jpeg) untuk Content-Type
     *
     * Kolom lama `gambar` (varchar) DIPERTAHANKAN sebagai fallback untuk record
     * lama yang masih memakai path / URL eksternal.
     */
    public function up(): void
    {
        Schema::table('galeri', function (Blueprint $table) {
            if (! Schema::hasColumn('galeri', 'gambar_data')) {
                $table->binary('gambar_data')->nullable();      // -> bytea di PostgreSQL
            }
            if (! Schema::hasColumn('galeri', 'gambar_mime')) {
                $table->string('gambar_mime', 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('galeri', function (Blueprint $table) {
            foreach (['gambar_data', 'gambar_mime'] as $col) {
                if (Schema::hasColumn('galeri', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
