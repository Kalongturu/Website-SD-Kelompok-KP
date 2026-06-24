<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel `guru`. Kalau tabel sudah dibuat sistem lain (mis. di
     * lingkungan produksi bersama), migrasi ini dilewati supaya tidak bentrok.
     */
    public function up(): void
    {
        if (Schema::hasTable('guru')) {
            return;
        }

        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('nip')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_kepala')->default(false);
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
