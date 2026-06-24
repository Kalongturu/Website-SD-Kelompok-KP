<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Foto guru/staf kini sepenuhnya disimpan sebagai DATA BINER (bytea) di kolom
     * `foto_data` (+ `foto_mime`). Kolom lama `foto` (varchar path teks) sudah
     * tidak dipakai lagi, jadi dihapus agar tidak ada penyimpanan ganda.
     *
     * Catatan: `foto` adalah kolom yang dulu ditambahkan oleh website ini sendiri
     * (lihat 2026_06_22_110000_add_website_fields_to_guru_table), bukan milik
     * backend lain, sehingga aman dihapus. Guard hasColumn membuat migrasi ini
     * idempoten (aman bila kolom sudah terlanjur hilang).
     */
    public function up(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            if (Schema::hasColumn('guru', 'foto')) {
                $table->dropColumn('foto');
            }
        });
    }

    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            if (! Schema::hasColumn('guru', 'foto')) {
                $table->string('foto')->nullable()->after('jabatan');
            }
        });
    }
};
