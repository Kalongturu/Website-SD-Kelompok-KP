<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penulis')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('mata_pelajaran')->nullable();
            $table->string('kelas', 50)->nullable();  // e.g. "Kelas 1", "Semua Kelas"
            $table->text('deskripsi')->nullable();
            $table->string('link_url');               // Link Google Drive, archive.org, dsb.
            $table->string('cover')->nullable();       // Path gambar cover
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
