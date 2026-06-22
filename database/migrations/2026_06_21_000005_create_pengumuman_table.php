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
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('ringkasan')->nullable();           // preview keterangan untuk daftar
            $table->longText('isi')->nullable();             // keterangan lengkap untuk modal
            $table->string('lampiran')->nullable();          // path berkas lampiran (opsional)
            $table->boolean('penting')->default(false);      // tandai pengumuman penting
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
        Schema::dropIfExists('pengumuman');
    }
};
