<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Simpan gambar berita sebagai DATA BINER (bytea) langsung di database — bukan
     * lagi path file di disk lokal. Dengan begitu gambar ikut tersimpan di Neon DB
     * bersama dan tampil di semua sistem yang terhubung ke database yang sama.
     * Kolom `gambar` (path lama) sengaja dibiarkan untuk fallback data lama.
     */
    public function up(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            if (! Schema::hasColumn('berita', 'gambar_data')) {
                $table->binary('gambar_data')->nullable();      // isi file gambar (bytea)
            }
            if (! Schema::hasColumn('berita', 'gambar_mime')) {
                $table->string('gambar_mime', 100)->nullable();  // penanda ada gambar + Content-Type
            }
        });
    }

    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            foreach (['gambar_data', 'gambar_mime'] as $col) {
                if (Schema::hasColumn('berita', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
