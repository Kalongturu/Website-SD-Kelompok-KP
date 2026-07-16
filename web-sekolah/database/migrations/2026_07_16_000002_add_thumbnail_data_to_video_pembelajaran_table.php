<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Thumbnail kustom video pembelajaran juga masih tersimpan sebagai PATH TEKS.
     * Samakan dengan tabel lain: simpan sebagai DATA BINER (bytea) di database
     * agar bisa dilihat SEMUA user, tidak bergantung file di disk lokal.
     *
     * Video tanpa thumbnail kustom tetap memakai thumbnail YouTube otomatis
     * (lihat VideoPembelajaran::thumbnailUrl()).
     */
    public function up(): void
    {
        if (! Schema::hasTable('video_pembelajaran')) {
            return;
        }

        Schema::table('video_pembelajaran', function (Blueprint $table) {
            if (! Schema::hasColumn('video_pembelajaran', 'thumbnail_data')) {
                $table->binary('thumbnail_data')->nullable();      // -> bytea di PostgreSQL
            }
            if (! Schema::hasColumn('video_pembelajaran', 'thumbnail_mime')) {
                $table->string('thumbnail_mime', 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('video_pembelajaran')) {
            return;
        }

        Schema::table('video_pembelajaran', function (Blueprint $table) {
            foreach (['thumbnail_data', 'thumbnail_mime'] as $col) {
                if (Schema::hasColumn('video_pembelajaran', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
