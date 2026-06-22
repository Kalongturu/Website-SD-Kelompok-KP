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
        // Kolom "tanggal" sudah dibuat di migrasi create_berita_table; lewati bila sudah ada.
        if (! Schema::hasColumn('berita', 'tanggal')) {
            Schema::table('berita', function (Blueprint $table) {
                $table->date('tanggal')->nullable()->after('penulis');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('berita', 'tanggal')) {
            Schema::table('berita', function (Blueprint $table) {
                $table->dropColumn('tanggal');
            });
        }
    }
};
