<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel-tabel berikut masih menyimpan gambar sebagai PATH TEKS (varchar) yang
     * menunjuk ke file di storage disk lokal. Akibatnya gambar hanya tampil di
     * mesin yang menyimpan filenya — user lain (dan sistem lain yang memakai
     * database yang sama) hanya melihat teks path yang gambarnya tidak ada.
     *
     * Migrasi ini menyamakan tabel-tabel tsb dengan pola yang sudah dipakai
     * berita/galeri/guru: gambar disimpan sebagai DATA BINER (bytea) di database
     * sehingga ikut terbawa bersama datanya dan bisa dilihat SEMUA user.
     *
     * - <kolom>_data : isi byte gambar (bytea)
     * - <kolom>_mime : tipe MIME (mis. image/jpeg) untuk Content-Type + penanda
     *                  bahwa record punya gambar
     *
     * Kolom path lama DIPERTAHANKAN sebagai fallback untuk record lama yang
     * belum di-backfill (lihat command `images:to-db`).
     *
     * Guard hasColumn dipakai agar aman dijalankan ulang (idempoten).
     */
    private const TARGETS = [
        'ekstrakurikuler' => 'foto',
        'prestasi'        => 'foto',
        'sarpras'         => 'gambar',
        'ruang_kelas'     => 'gambar',
        'ebooks'          => 'cover',
        'siswas'          => 'foto',
    ];

    public function up(): void
    {
        foreach (self::TARGETS as $tabel => $kolom) {
            if (! Schema::hasTable($tabel)) {
                continue;
            }

            Schema::table($tabel, function (Blueprint $table) use ($tabel, $kolom) {
                if (! Schema::hasColumn($tabel, $kolom . '_data')) {
                    $table->binary($kolom . '_data')->nullable();   // -> bytea di PostgreSQL
                }
                if (! Schema::hasColumn($tabel, $kolom . '_mime')) {
                    $table->string($kolom . '_mime', 100)->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        foreach (self::TARGETS as $tabel => $kolom) {
            if (! Schema::hasTable($tabel)) {
                continue;
            }

            Schema::table($tabel, function (Blueprint $table) use ($tabel, $kolom) {
                foreach ([$kolom . '_data', $kolom . '_mime'] as $col) {
                    if (Schema::hasColumn($tabel, $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
