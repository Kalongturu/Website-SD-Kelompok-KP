<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jangan bungkus migrasi ini dalam transaksi. Koneksi Neon lewat endpoint
     * pooler (host "...-pooler...") menolak DDL (ALTER TABLE) di dalam blok
     * transaksi — error "current transaction is aborted". Tanpa transaksi,
     * tiap statement berjalan autocommit (seperti ALTER manual yang berhasil).
     * Guard hasColumn menjaga migrasi tetap idempoten meski tanpa rollback.
     */
    public $withinTransaction = false;

    /**
     * Menambah blok "Sejarah Singkat" pada halaman Profil > Sejarah:
     * - sejarah_singkat_judul : judul blok (mis. "Sejarah Singkat SDN Dadapsari")
     * - sejarah_singkat       : isi (boleh beberapa paragraf, dipisah baris kosong)
     */
    public function up(): void
    {
        if (! Schema::hasColumn('profil_settings', 'sejarah_singkat_judul')) {
            Schema::table('profil_settings', function (Blueprint $table) {
                $table->string('sejarah_singkat_judul', 150)->nullable();
            });
        }

        if (! Schema::hasColumn('profil_settings', 'sejarah_singkat')) {
            Schema::table('profil_settings', function (Blueprint $table) {
                $table->text('sejarah_singkat')->nullable();
            });
        }

        // Isi nilai awal pada baris yang SUDAH ada (hanya bila masih kosong),
        // agar teks langsung tampil tanpa perlu mengisi lewat admin lebih dulu.
        // Baris yang belum ada akan memakai default dari ProfilSetting::getData().
        $judul = 'Sejarah Singkat SDN Dadapsari';
        $isi = "Berdirinya SDN Dadapsari Semarang karena dilatarbelakangi oleh pemikiran bahwa kebutuhan manusia akan ilmu pengetahuan dan ilmu Agama adalah sangat penting, karena sebagai makhluk Allah SWT. yang paling sempurna, manusia hidup diciptakan di dunia mengemban tugas untuk beribadah kepada-Nya. Sedangkan orang yang beribadah haruslah disertai dengan ilmunya, selain itu juga mengembangkan tradisi keilmuan sains dan teknologi guna menghadapi kerasnya persaingan di era globalisasi juga tidak bisa dikesampingkan. SDN Dadapsari memadukan kedua aspek keilmuan tersebut yang diorientasikan untuk menjadikan manusia yang memiliki ilmu pengetahuan yang luas dengan diimbangi dasar ilmu Agama Islam yang kuat dengan disertai kepribadian yang mulia atau akhlak al-karimah merupakan cita-cita dan visi utama SDN Dadapsari didirikan.\n\nTahun 1965, SDN Dadapsari Semarang mulai didirikan dengan surat keputusan Dinas P dan K Propinsi Daerah Tingkat I Jawa Tengah dengan NSS: 1010301133008, NIS: 1180910001, NSB: 03111760312002, serta NPSN dengan nomor : 20329393. Pada awalnya bernama SDN Mlayu Darat, kemudian karena nama kelurahan diganti dengan kelurahan Dadapsari, maka nama SDN Mlayu Darat juga ikut berubah menjadi SDN Dadapsari hingga sekarang.";

        DB::table('profil_settings')
            ->whereNull('sejarah_singkat')
            ->update([
                'sejarah_singkat_judul' => $judul,
                'sejarah_singkat'       => $isi,
            ]);
    }

    public function down(): void
    {
        foreach (['sejarah_singkat_judul', 'sejarah_singkat'] as $col) {
            if (Schema::hasColumn('profil_settings', $col)) {
                Schema::table('profil_settings', function (Blueprint $table) use ($col) {
                    $table->dropColumn($col);
                });
            }
        }
    }
};
