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
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori')->nullable();          // Kegiatan, Prestasi, Pengumuman Dinas, dll.
            $table->text('ringkasan')->nullable();           // preview untuk kartu
            $table->longText('isi')->nullable();             // konten lengkap untuk modal
            $table->string('gambar')->nullable();            // path gambar (opsional)
            $table->string('penulis')->nullable();
            $table->date('tanggal')->nullable();             // tanggal terbit
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
