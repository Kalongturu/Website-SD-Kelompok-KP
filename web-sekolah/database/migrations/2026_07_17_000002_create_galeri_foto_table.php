<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sebuah record `galeri` kini berperan sebagai ALBUM yang dapat memuat banyak
     * foto. Tiap foto disimpan sebagai DATA BINER (bytea) di tabel `galeri_foto`,
     * mengikuti pola gambar biner yang sudah dipakai di tabel lain.
     *
     * Foto lama yang tersimpan di kolom `galeri.gambar_data` disalin menjadi baris
     * pertama album agar semua album seragam memakai `galeri_foto`. Kolom lama
     * dipertahankan sebagai fallback untuk keamanan.
     */
    public function up(): void
    {
        Schema::create('galeri_foto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('galeri_id')->constrained('galeri')->cascadeOnDelete();
            $table->binary('gambar_data')->nullable();   // -> bytea di PostgreSQL
            $table->string('gambar_mime', 100)->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->index(['galeri_id', 'urutan']);
        });

        // Salin foto tunggal lama menjadi foto pertama pada album masing-masing.
        DB::statement("
            INSERT INTO galeri_foto (galeri_id, gambar_data, gambar_mime, urutan, created_at, updated_at)
            SELECT id, gambar_data, gambar_mime, 0, now(), now()
            FROM galeri
            WHERE gambar_data IS NOT NULL
        ");

        // Setelah disalin, kosongkan byte lama di tabel `galeri` agar sumber foto
        // hanya satu (tabel `galeri_foto`). Mencegah foto "sisa" tetap muncul saat
        // seluruh foto album dihapus. Kolom dipertahankan (nullable) untuk fallback.
        DB::statement("UPDATE galeri SET gambar_data = NULL, gambar_mime = NULL WHERE gambar_data IS NOT NULL");
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri_foto');
    }
};
