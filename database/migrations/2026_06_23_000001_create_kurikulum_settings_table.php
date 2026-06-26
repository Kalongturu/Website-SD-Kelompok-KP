<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel milik website (mirip profil_settings) — aman dibuat di DB bersama.
        if (! Schema::hasTable('kurikulum_settings')) {
            Schema::create('kurikulum_settings', function (Blueprint $table) {
                $table->id();
                $table->string('judul', 200)->nullable();
                // Konten kurikulum disimpan sebagai array "blok" (paragraf/subjudul/ol/ul).
                $table->json('blok')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum_settings');
    }
};
