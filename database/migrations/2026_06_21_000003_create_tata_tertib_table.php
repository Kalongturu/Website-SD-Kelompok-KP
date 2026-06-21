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
        Schema::create('tata_tertib', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');                      // mis. "Kewajiban Siswa", "Larangan", "Sanksi"
            $table->string('icon')->nullable();              // emoji / ikon untuk kepala kelompok
            $table->text('isi');                             // satu butir aturan per baris
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
        Schema::dropIfExists('tata_tertib');
    }
};
