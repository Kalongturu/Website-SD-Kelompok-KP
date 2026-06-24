<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel `guru` dipakai bersama sistem lain. Migrasi ini hanya MENAMBAH kolom
     * untuk menyimpan FOTO sebagai DATA BINER (bytea) langsung di database —
     * bukan sekadar path teks yang menunjuk ke file di disk website. Dengan
     * begitu gambarnya ikut tersimpan di DB bersama dan terbaca sistem lain
     * sebagai berkas gambar (jpg/png), bukan teks.
     *
     * - foto_data : isi byte gambar (bytea)
     * - foto_mime : tipe MIME gambar (mis. image/jpeg) untuk Content-Type
     *
     * Guard hasColumn dipakai agar aman dijalankan ulang (idempoten) bila kolom
     * sudah terlanjur ada di database.
     */
    public function up(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            if (! Schema::hasColumn('guru', 'foto_data')) {
                $table->binary('foto_data')->nullable();        // -> bytea di PostgreSQL
            }
            if (! Schema::hasColumn('guru', 'foto_mime')) {
                $table->string('foto_mime', 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            foreach (['foto_data', 'foto_mime'] as $col) {
                if (Schema::hasColumn('guru', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
