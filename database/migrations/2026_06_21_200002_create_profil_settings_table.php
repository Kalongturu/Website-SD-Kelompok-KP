<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_settings', function (Blueprint $table) {
            $table->id();

            // Sejarah
            $table->text('sejarah_intro')->nullable();
            $table->json('sejarah_timeline')->nullable();
            $table->text('sejarah_komitmen')->nullable();

            // Visi & Misi
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();
            $table->json('tujuan')->nullable();
            $table->json('nilai')->nullable();

            // Transparansi Dana BOS
            $table->string('bos_tahun_anggaran', 20)->nullable();
            $table->string('bos_jumlah_siswa', 50)->nullable();
            $table->string('bos_dana_per_siswa', 80)->nullable();
            $table->string('bos_total_estimasi', 80)->nullable();
            $table->json('bos_komponen')->nullable();
            $table->text('bos_catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_settings');
    }
};
