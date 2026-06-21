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
        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori')->nullable();          // Olahraga, Seni, Akademik, Keagamaan
            $table->string('icon')->nullable();              // emoji / ikon untuk fallback kartu
            $table->string('foto')->nullable();              // path gambar (opsional)
            $table->text('deskripsi_singkat')->nullable();   // ringkasan untuk kartu
            $table->longText('deskripsi')->nullable();       // keterangan lengkap untuk detail
            $table->string('jadwal')->nullable();            // mis. "Setiap Jumat, 14.00-16.00"
            $table->string('lokasi')->nullable();
            $table->string('pembina')->nullable();
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
        Schema::dropIfExists('ekstrakurikuler');
    }
};
