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
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kejuaraan');                // mis. "Olimpiade Sains Nasional 2025"
            $table->string('kategori');                      // KSN, MAPSI, Siswa Berprestasi, dll.
            $table->string('tingkat')->nullable();           // Kecamatan, Kota, Provinsi, Nasional
            $table->string('peringkat')->nullable();         // Juara 1, Juara 2, Harapan 1
            $table->string('nama_siswa')->nullable();        // siswa yang mengikuti lomba
            $table->string('kelas')->nullable();
            $table->string('penyelenggara')->nullable();
            $table->date('tanggal')->nullable();             // waktu pelaksanaan
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
