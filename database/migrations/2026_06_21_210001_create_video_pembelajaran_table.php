<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('video_pembelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('mata_pelajaran')->nullable();
            $table->string('kelas', 50)->nullable();  // e.g. "Kelas 3", "Semua Kelas"
            $table->text('deskripsi')->nullable();
            $table->string('url_video');              // URL YouTube, Google Drive, dsb.
            $table->string('thumbnail')->nullable();  // Override thumbnail (jika bukan YouTube)
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_pembelajaran');
    }
};
