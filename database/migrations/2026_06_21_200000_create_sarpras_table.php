<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sarpras', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->integer('jumlah_ganjil')->default(0);
            $table->integer('jumlah_genap')->default(0);
            $table->text('keterangan')->nullable();
            $table->string('gambar')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sarpras');
    }
};
