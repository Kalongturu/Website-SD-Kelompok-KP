<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel `guru` sudah ada (dipakai bersama sistem lain). Migrasi ini hanya
     * MENAMBAH kolom yang dibutuhkan halaman website + admin konten, tanpa
     * mengganggu kolom milik sistem lain.
     */
    public function up(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            if (! Schema::hasColumn('guru', 'foto'))      $table->string('foto')->nullable()->after('jabatan');
            if (! Schema::hasColumn('guru', 'is_kepala')) $table->boolean('is_kepala')->default(false);
            if (! Schema::hasColumn('guru', 'urutan'))    $table->integer('urutan')->default(0);
            if (! Schema::hasColumn('guru', 'is_active')) $table->boolean('is_active')->default(true);
        });

        // NIP dijadikan opsional untuk pengisian dari website (form publik hanya
        // mewajibkan nama, foto, jabatan). DROP NOT NULL bersifat backward-compatible.
        DB::statement('ALTER TABLE guru ALTER COLUMN nip DROP NOT NULL');
    }

    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            foreach (['foto', 'is_kepala', 'urutan', 'is_active'] as $col) {
                if (Schema::hasColumn('guru', $col)) $table->dropColumn($col);
            }
        });
    }
};
