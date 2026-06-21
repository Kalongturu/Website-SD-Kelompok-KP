<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Pengumuman;
use Illuminate\Database\Seeder;

class InformasiSeeder extends Seeder
{
    /**
     * Contoh data berita & pengumuman agar panel informasi dapat langsung dilihat.
     * Jalankan: php artisan db:seed --class=InformasiSeeder
     */
    public function run(): void
    {
        // Bersihkan dulu agar tidak menumpuk bila di-seed berulang.
        Berita::truncate();
        Pengumuman::truncate();

        // ── BERITA ──
        $berita = [
            [
                'judul' => 'Peringatan Hari Pendidikan Nasional 2026',
                'kategori' => 'Kegiatan',
                'ringkasan' => 'SDN Dadapsari menggelar upacara dan beragam lomba dalam rangka memperingati Hari Pendidikan Nasional.',
                'isi' => "SDN Dadapsari memperingati Hari Pendidikan Nasional dengan menggelar upacara bendera khidmat yang diikuti seluruh siswa, guru, dan staf.\n\nUsai upacara, kegiatan dilanjutkan dengan berbagai lomba bertema pendidikan seperti cerdas cermat, baca puisi, dan menggambar. Acara berlangsung meriah dan menumbuhkan semangat belajar siswa.",
                'penulis' => 'Tim Humas Sekolah',
                'tanggal' => '2026-05-02',
            ],
            [
                'judul' => 'Siswa SDN Dadapsari Raih Juara 1 KSN Matematika Tingkat Kota',
                'kategori' => 'Prestasi',
                'ringkasan' => 'Aisyah Putri Ramadhani dari kelas 5A berhasil meraih juara 1 Kompetisi Sains Nasional bidang Matematika.',
                'isi' => "Kabar membanggakan datang dari ajang Kompetisi Sains Nasional (KSN) bidang Matematika tingkat kota.\n\nAisyah Putri Ramadhani, siswa kelas 5A, berhasil meraih Juara 1 dan berhak melaju ke tingkat provinsi. Prestasi ini merupakan hasil dari pembinaan rutin dan kerja keras siswa bersama para guru pembimbing.",
                'penulis' => 'Tim Humas Sekolah',
                'tanggal' => '2026-03-16',
            ],
            [
                'judul' => 'Kegiatan Jumat Bersih dan Penghijauan Sekolah',
                'kategori' => 'Kegiatan',
                'ringkasan' => 'Seluruh warga sekolah bergotong royong membersihkan lingkungan dan menanam pohon di area sekolah.',
                'isi' => "Dalam rangka menumbuhkan kepedulian terhadap lingkungan, SDN Dadapsari rutin mengadakan kegiatan Jumat Bersih.\n\nPekan ini kegiatan dilengkapi dengan penanaman pohon dan tanaman hias di sekitar halaman sekolah. Siswa diajak untuk menjaga kebersihan serta mencintai lingkungan sejak dini.",
                'penulis' => 'Tim Humas Sekolah',
                'tanggal' => '2026-04-25',
            ],
            [
                'judul' => 'Kunjungan Edukatif ke Museum Kota',
                'kategori' => 'Kegiatan',
                'ringkasan' => 'Siswa kelas 4 dan 5 mengikuti kunjungan edukatif untuk mengenal sejarah dan budaya daerah.',
                'isi' => "SDN Dadapsari mengadakan kunjungan edukatif ke Museum Kota bagi siswa kelas 4 dan 5.\n\nKegiatan ini bertujuan memperkenalkan sejarah dan budaya daerah secara langsung. Siswa tampak antusias mengamati koleksi museum sambil mencatat informasi yang diperoleh sebagai bahan pembelajaran.",
                'penulis' => 'Tim Humas Sekolah',
                'tanggal' => '2026-02-12',
            ],
        ];
        foreach ($berita as $b) {
            Berita::create($b);
        }

        // ── PENGUMUMAN ──
        $pengumuman = [
            [
                'judul' => 'Pendaftaran Peserta Didik Baru Tahun Ajaran 2026/2027 Dibuka',
                'ringkasan' => 'Pendaftaran siswa baru dibuka mulai 1 Juni 2026. Simak persyaratan dan tahapannya.',
                'isi' => "Diberitahukan kepada masyarakat bahwa pendaftaran peserta didik baru (PPDB) SDN Dadapsari Tahun Ajaran 2026/2027 resmi dibuka.\n\nPendaftaran dibuka mulai 1 Juni 2026 hingga kuota terpenuhi. Calon siswa dan orang tua diharapkan menyiapkan berkas persyaratan serta mengikuti tahapan pendaftaran sesuai panduan yang tersedia pada halaman PPDB.",
                'penting' => true,
                'tanggal' => '2026-05-20',
            ],
            [
                'judul' => 'Jadwal Penilaian Akhir Semester Genap',
                'ringkasan' => 'Penilaian Akhir Semester (PAS) genap dilaksanakan pada 9–14 Juni 2026.',
                'isi' => "Diberitahukan kepada seluruh siswa dan orang tua/wali bahwa Penilaian Akhir Semester (PAS) genap akan dilaksanakan pada tanggal 9 sampai 14 Juni 2026.\n\nSiswa diharapkan mempersiapkan diri dengan baik dan hadir tepat waktu. Jadwal lengkap per mata pelajaran dapat dilihat melalui wali kelas masing-masing.",
                'penting' => false,
                'tanggal' => '2026-06-02',
            ],
            [
                'judul' => 'Pembagian Rapor dan Libur Akhir Semester',
                'ringkasan' => 'Pembagian rapor dilaksanakan 20 Juni 2026, dilanjutkan libur akhir semester.',
                'isi' => "Pembagian rapor semester genap akan dilaksanakan pada hari Sabtu, 20 Juni 2026. Orang tua/wali diharapkan hadir untuk menerima rapor putra-putrinya.\n\nKegiatan belajar mengajar akan diliburkan setelah pembagian rapor, dan masuk kembali sesuai kalender pendidikan tahun ajaran berikutnya.",
                'penting' => false,
                'tanggal' => '2026-06-10',
            ],
            [
                'judul' => 'Libur Hari Raya Idul Adha',
                'ringkasan' => 'Sekolah diliburkan pada peringatan Hari Raya Idul Adha sesuai kalender pemerintah.',
                'isi' => "Sehubungan dengan peringatan Hari Raya Idul Adha, kegiatan belajar mengajar di SDN Dadapsari diliburkan sesuai ketetapan pemerintah.\n\nSeluruh warga sekolah diucapkan Selamat Hari Raya Idul Adha. Kegiatan belajar mengajar akan kembali normal pada hari berikutnya.",
                'penting' => false,
                'tanggal' => '2026-05-28',
            ],
        ];
        foreach ($pengumuman as $p) {
            Pengumuman::create($p);
        }
    }
}
