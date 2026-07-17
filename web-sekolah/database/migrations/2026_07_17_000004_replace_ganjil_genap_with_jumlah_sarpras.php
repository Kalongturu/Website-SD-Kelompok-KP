<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sarana & prasarana kini cukup memakai SATU kolom `jumlah`, tidak lagi
     * dipisah per semester (ganjil/genap). Nilai awal `jumlah` diambil dari nilai
     * TERBESAR antara jumlah_ganjil/jumlah_genap (mewakili jumlah unit item yang
     * sama pada kedua semester). Admin dapat menyuntingnya bila perlu.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('sarpras', 'jumlah')) {
            Schema::table('sarpras', function (Blueprint $table) {
                $table->integer('jumlah')->default(0);
            });
        }

        if (Schema::hasColumn('sarpras', 'jumlah_ganjil') || Schema::hasColumn('sarpras', 'jumlah_genap')) {
            DB::statement('UPDATE sarpras SET jumlah = GREATEST(COALESCE(jumlah_ganjil, 0), COALESCE(jumlah_genap, 0))');
        }

        Schema::table('sarpras', function (Blueprint $table) {
            foreach (['jumlah_ganjil', 'jumlah_genap'] as $col) {
                if (Schema::hasColumn('sarpras', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('sarpras', function (Blueprint $table) {
            if (! Schema::hasColumn('sarpras', 'jumlah_ganjil')) {
                $table->integer('jumlah_ganjil')->default(0);
            }
            if (! Schema::hasColumn('sarpras', 'jumlah_genap')) {
                $table->integer('jumlah_genap')->default(0);
            }
        });

        // Kembalikan angka ke kedua kolom (nilai sama) sebisanya.
        if (Schema::hasColumn('sarpras', 'jumlah')) {
            DB::statement('UPDATE sarpras SET jumlah_ganjil = jumlah, jumlah_genap = jumlah');
            Schema::table('sarpras', function (Blueprint $table) {
                $table->dropColumn('jumlah');
            });
        }
    }
};
