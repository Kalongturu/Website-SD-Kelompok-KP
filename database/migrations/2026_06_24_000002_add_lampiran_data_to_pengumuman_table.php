<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Simpan lampiran pengumuman sebagai DATA BINER (bytea) langsung di database —
     * bukan lagi path file di disk lokal. Dengan begitu berkas ikut tersimpan di
     * Neon DB bersama dan bisa diunduh dari semua sistem yang terhubung ke database
     * yang sama. Kolom `lampiran` (path lama) dibiarkan untuk fallback data lama.
     */
    public function up(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            if (! Schema::hasColumn('pengumuman', 'lampiran_data')) {
                $table->binary('lampiran_data')->nullable();        // isi berkas (bytea)
            }
            if (! Schema::hasColumn('pengumuman', 'lampiran_mime')) {
                $table->string('lampiran_mime', 100)->nullable();   // penanda ada lampiran + Content-Type
            }
            if (! Schema::hasColumn('pengumuman', 'lampiran_nama')) {
                $table->string('lampiran_nama', 255)->nullable();   // nama berkas asli untuk diunduh
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengumuman', function (Blueprint $table) {
            foreach (['lampiran_data', 'lampiran_mime', 'lampiran_nama'] as $col) {
                if (Schema::hasColumn('pengumuman', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
