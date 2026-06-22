<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori')->nullable();          // Kegiatan, Ekstrakurikuler, Prestasi, Fasilitas
            $table->string('gambar')->nullable();            // path di storage atau URL gambar
            $table->text('keterangan')->nullable();          // keterangan yang tampil saat foto diklik
            $table->date('tanggal')->nullable();             // tanggal pengambilan foto
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
