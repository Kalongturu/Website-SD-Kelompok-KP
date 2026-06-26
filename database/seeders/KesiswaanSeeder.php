<?php

namespace Database\Seeders;

use App\Models\Ekstrakurikuler;
use App\Models\Prestasi;
use App\Models\TataTertib;
use Illuminate\Database\Seeder;

class KesiswaanSeeder extends Seeder
{
    /**
     * Contoh data kesiswaan agar tampilan dapat langsung dilihat.
     * Jalankan: php artisan db:seed --class=KesiswaanSeeder
     */
    public function run(): void
    {
        // Bersihkan dulu agar tidak menumpuk bila di-seed berulang.
        Ekstrakurikuler::truncate();
        Prestasi::truncate();
        TataTertib::truncate();

        // ── EKSTRAKURIKULER ──
        $ekskul = [
            [
                'nama' => 'Pramuka', 'kategori' => 'Wajib', 'icon' => '🏕️',
                'deskripsi_singkat' => 'Membentuk karakter mandiri, disiplin, dan cinta alam melalui kegiatan kepramukaan.',
                'deskripsi' => "Gerakan Pramuka adalah ekstrakurikuler wajib yang membina kemandirian, kedisiplinan, kepemimpinan, dan kepedulian sosial siswa.\n\nKegiatan meliputi tali-temali, baris-berbaris, sandi, P3K, hingga perkemahan akhir semester (Persami).",
                'jadwal' => 'Setiap Jumat, 14.00 – 16.00', 'lokasi' => 'Lapangan Sekolah', 'pembina' => 'Kak Budi Santoso', 'urutan' => 1,
            ],
            [
                'nama' => 'Futsal', 'kategori' => 'Olahraga', 'icon' => '⚽',
                'deskripsi_singkat' => 'Mengembangkan kerja sama tim, sportivitas, dan kebugaran jasmani siswa.',
                'deskripsi' => "Ekstrakurikuler futsal melatih teknik dasar sepak bola, strategi bermain, serta kerja sama tim.\n\nTim futsal sekolah rutin mengikuti turnamen antar-SD tingkat kecamatan dan kota.",
                'jadwal' => 'Setiap Selasa, 15.00 – 17.00', 'lokasi' => 'Lapangan Futsal', 'pembina' => 'Pak Andi Pratama', 'urutan' => 2,
            ],
            [
                'nama' => 'Seni Tari', 'kategori' => 'Seni', 'icon' => '💃',
                'deskripsi_singkat' => 'Melestarikan budaya melalui tari tradisional dan kreasi modern.',
                'deskripsi' => "Ekstrakurikuler Seni Tari memperkenalkan beragam tarian daerah Nusantara serta tari kreasi.\n\nSiswa tampil dalam acara sekolah, lomba seni, dan peringatan hari besar nasional.",
                'jadwal' => 'Setiap Rabu, 14.00 – 15.30', 'lokasi' => 'Ruang Kesenian', 'pembina' => 'Bu Sinta Dewi', 'urutan' => 3,
            ],
            [
                'nama' => 'Paduan Suara', 'kategori' => 'Seni', 'icon' => '🎤',
                'deskripsi_singkat' => 'Melatih olah vokal, harmoni, dan kepercayaan diri tampil di depan umum.',
                'deskripsi' => "Paduan suara melatih teknik vokal, pernapasan, dan harmonisasi suara.\n\nMembawakan lagu wajib nasional dan daerah pada upacara serta berbagai event sekolah.",
                'jadwal' => 'Setiap Kamis, 14.00 – 15.30', 'lokasi' => 'Aula', 'pembina' => 'Bu Maria Ulfa', 'urutan' => 4,
            ],
            [
                'nama' => 'Robotik & Coding', 'kategori' => 'Akademik', 'icon' => '🤖',
                'deskripsi_singkat' => 'Mengenalkan logika pemrograman dan robotika sejak dini.',
                'deskripsi' => "Ekstrakurikuler robotik mengajarkan dasar coding, logika, dan perakitan robot sederhana.\n\nMengasah kemampuan berpikir komputasional dan pemecahan masalah secara menyenangkan.",
                'jadwal' => 'Setiap Sabtu, 09.00 – 11.00', 'lokasi' => 'Lab Komputer', 'pembina' => 'Pak Rizky Hidayat', 'urutan' => 5,
            ],
            [
                'nama' => 'Tahfidz Al-Qur\'an', 'kategori' => 'Keagamaan', 'icon' => '📖',
                'deskripsi_singkat' => 'Membimbing siswa menghafal dan mencintai Al-Qur\'an.',
                'deskripsi' => "Program tahfidz membimbing siswa menghafal juz 30 dengan bacaan yang benar (tajwid).\n\nMenumbuhkan akhlak mulia dan kecintaan terhadap Al-Qur'an.",
                'jadwal' => 'Setiap Senin & Rabu, 13.00 – 14.00', 'lokasi' => 'Mushola', 'pembina' => 'Ustadz Fauzan', 'urutan' => 6,
            ],
        ];
        foreach ($ekskul as $e) {
            Ekstrakurikuler::create($e);
        }

        // ── PRESTASI SISWA ──
        $prestasi = [
            [
                'nama_kejuaraan' => 'Kompetisi Sains Nasional (KSN) Bidang Matematika', 'kategori' => 'KSN',
                'tingkat' => 'Kota', 'peringkat' => 'Juara 1', 'nama_siswa' => 'Aisyah Putri Ramadhani', 'kelas' => 'Kelas 5A',
                'penyelenggara' => 'Dinas Pendidikan Kota', 'tanggal' => '2025-03-15',
                'deskripsi' => 'Meraih juara 1 KSN Matematika tingkat kota dan lolos ke tingkat provinsi.',
            ],
            [
                'nama_kejuaraan' => 'KSN Bidang IPA', 'kategori' => 'KSN',
                'tingkat' => 'Kecamatan', 'peringkat' => 'Juara 2', 'nama_siswa' => 'Bagas Dwi Saputra', 'kelas' => 'Kelas 6B',
                'penyelenggara' => 'Dinas Pendidikan Kecamatan', 'tanggal' => '2025-02-20',
                'deskripsi' => 'Juara 2 bidang IPA pada seleksi tingkat kecamatan.',
            ],
            [
                'nama_kejuaraan' => 'MAPSI Cabang Tilawah Al-Qur\'an', 'kategori' => 'MAPSI',
                'tingkat' => 'Kota', 'peringkat' => 'Juara 1', 'nama_siswa' => 'Fatimah Az-Zahra', 'kelas' => 'Kelas 4C',
                'penyelenggara' => 'Kantor Kemenag Kota', 'tanggal' => '2025-04-10',
                'deskripsi' => 'Juara 1 cabang Tilawah pada Lomba MAPSI tingkat kota.',
            ],
            [
                'nama_kejuaraan' => 'MAPSI Cabang Adzan', 'kategori' => 'MAPSI',
                'tingkat' => 'Kecamatan', 'peringkat' => 'Juara 3', 'nama_siswa' => 'Muhammad Rafa Alfarizi', 'kelas' => 'Kelas 5B',
                'penyelenggara' => 'KKG PAI Kecamatan', 'tanggal' => '2024-11-05',
                'deskripsi' => 'Juara 3 cabang Adzan pada Lomba MAPSI tingkat kecamatan.',
            ],
            [
                'nama_kejuaraan' => 'Pemilihan Siswa Berprestasi', 'kategori' => 'Siswa Berprestasi',
                'tingkat' => 'Provinsi', 'peringkat' => 'Harapan 1', 'nama_siswa' => 'Nadia Salsabila', 'kelas' => 'Kelas 6A',
                'penyelenggara' => 'Dinas Pendidikan Provinsi', 'tanggal' => '2025-05-18',
                'deskripsi' => 'Meraih Harapan 1 ajang Siswa Berprestasi tingkat provinsi.',
            ],
            [
                'nama_kejuaraan' => 'Lomba Siswa Berprestasi', 'kategori' => 'Siswa Berprestasi',
                'tingkat' => 'Kota', 'peringkat' => 'Juara 1', 'nama_siswa' => 'Kevin Adi Nugroho', 'kelas' => 'Kelas 5A',
                'penyelenggara' => 'Dinas Pendidikan Kota', 'tanggal' => '2024-09-22',
                'deskripsi' => 'Juara 1 ajang Siswa Berprestasi tingkat kota tahun 2024.',
            ],
            [
                'nama_kejuaraan' => 'Turnamen Futsal Antar-SD', 'kategori' => 'Olahraga',
                'tingkat' => 'Kota', 'peringkat' => 'Juara 2', 'nama_siswa' => 'Tim Futsal SDN Dadapsari', 'kelas' => 'Kelas 5 & 6',
                'penyelenggara' => 'KONI Kota', 'tanggal' => '2025-01-30',
                'deskripsi' => 'Tim futsal sekolah meraih juara 2 turnamen antar-SD se-kota.',
            ],
            [
                'nama_kejuaraan' => 'Festival Lomba Seni Siswa Nasional (FLS2N) Tari', 'kategori' => 'Seni',
                'tingkat' => 'Provinsi', 'peringkat' => 'Juara 3', 'nama_siswa' => 'Sanggar Tari SDN Dadapsari', 'kelas' => 'Kelas 4 – 6',
                'penyelenggara' => 'Dinas Pendidikan Provinsi', 'tanggal' => '2024-10-12',
                'deskripsi' => 'Juara 3 cabang Tari Kreasi pada FLS2N tingkat provinsi.',
            ],
        ];
        foreach ($prestasi as $p) {
            Prestasi::create($p);
        }

        // ── TATA TERTIB ──
        $tatib = [
            [
                'kategori' => 'Kewajiban Siswa', 'icon' => '✅', 'urutan' => 1,
                'isi' => "Hadir di sekolah paling lambat pukul 06.45 WIB.\nMengikuti upacara bendera setiap hari Senin dengan tertib.\nMengenakan seragam lengkap sesuai jadwal yang ditentukan.\nMenjaga kebersihan kelas dan lingkungan sekolah.\nMengerjakan dan mengumpulkan tugas tepat waktu.\nBersikap sopan dan hormat kepada guru, staf, dan sesama teman.",
            ],
            [
                'kategori' => 'Larangan', 'icon' => '⛔', 'urutan' => 2,
                'isi' => "Tidak membawa atau bermain gawai/HP saat jam pelajaran tanpa izin.\nTidak membawa senjata tajam atau benda berbahaya.\nTidak berkata kasar, mengejek, atau melakukan perundungan (bullying).\nTidak merusak fasilitas dan sarana sekolah.\nTidak meninggalkan sekolah tanpa izin guru.\nTidak membawa atau mengonsumsi makanan/minuman terlarang.",
            ],
            [
                'kategori' => 'Pakaian Seragam', 'icon' => '👕', 'urutan' => 3,
                'isi' => "Senin – Selasa: seragam merah putih lengkap dengan atribut.\nRabu – Kamis: seragam batik sekolah.\nJumat: seragam pramuka.\nSepatu hitam dan kaus kaki putih.\nRambut rapi; siswa putra tidak gondrong, siswa putri rambut panjang diikat rapi.",
            ],
            [
                'kategori' => 'Sanksi Pelanggaran', 'icon' => '⚠️', 'urutan' => 4,
                'isi' => "Pelanggaran ringan: teguran lisan dari guru.\nPelanggaran berulang: pencatatan poin pelanggaran dan pemanggilan siswa.\nPelanggaran sedang: pemanggilan orang tua/wali.\nPelanggaran berat: skorsing sesuai keputusan rapat dewan guru.",
            ],
        ];
        foreach ($tatib as $t) {
            TataTertib::create($t);
        }
    }
}
