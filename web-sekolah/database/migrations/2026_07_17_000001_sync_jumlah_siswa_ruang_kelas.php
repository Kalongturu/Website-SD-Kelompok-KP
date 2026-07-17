<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Selaraskan kolom `jumlah_siswa` pada tiap ruang kelas dengan jumlah data
     * siswa nyata (mencocokkan `siswas.kelas` dengan `ruang_kelas.nama_kelas`).
     * Setelah ini, angka bersifat otomatis dan dijaga oleh event model.
     */
    public function up(): void
    {
        DB::statement('
            UPDATE ruang_kelas
            SET jumlah_siswa = (
                SELECT COUNT(*) FROM siswas
                WHERE siswas.kelas = ruang_kelas.nama_kelas
            )
        ');
    }

    public function down(): void
    {
        // Data angka lama tidak disimpan; tidak ada yang perlu dikembalikan.
    }
};
