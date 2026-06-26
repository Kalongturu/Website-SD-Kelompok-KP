<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KurikulumSetting extends Model
{
    protected $table = 'kurikulum_settings';

    protected $fillable = [
        'judul',
        'blok',
    ];

    protected $casts = [
        'blok' => 'array',
    ];

    /**
     * Ambil pengaturan kurikulum. Jika belum ada baris di DB, kembalikan
     * konten bawaan (default) agar halaman publik tetap tampil.
     */
    public static function getData(): self
    {
        return static::first() ?? new static([
            'judul' => 'KURIKULUM SDN DADAPSARI SEMARANG',
            'blok' => [
                ['tipe' => 'paragraf', 'isi' => 'Saat ini kami telah melaksanakan Kurikulum 2013 sejak Tahun Pelajaran 2017/2018.'],
                ['tipe' => 'subjudul', 'isi' => 'Prinsip Kurikulum'],
                ['tipe' => 'paragraf', 'isi' => 'Kurikulum SDN Dadapsari Semarang mengacu kepada Standar Nasional Pendidikan untuk mencapai tujuan pendidikan nasional. Standar Nasional Pendidikan terdiri dari :'],
                ['tipe' => 'ol', 'item' => ['Standar Isi', 'Standar Proses', 'Kompetensi Lulusan', 'Tenaga Pendidikan', 'Sarana Prasarana', 'Pengelolaan', 'Pembiayaan dan', 'Penilaian Pendidikan']],
                ['tipe' => 'paragraf', 'isi' => 'Pengembangan kurikulum disusun antara lain dapat memberi kesempatan peserta didik untuk :'],
                ['tipe' => 'ul', 'item' => [
                    'Menanamkan sikap religius melalui pembelajaran agama untuk keimanan dan ketakwaan terhadap Tuhan Yang Maha Esa;',
                    'Menanamkan kebiasaan peserta didik untuk beribadah sesuai dengan agamanya;',
                    'Membantu peserta didik untuk mengenali potensi dirinya sehingga dapat berkembang optimal;',
                    'Menumbuhkan semangat berprestasi, aktif, kreatif, kepada seluruh warga sekolah;',
                    'Meningkatkan kemampuan peserta didik dalam menciptakan lingkungan yang bersih, sehat, di lingkungan sekitar;',
                    'Menanamkan sikap nasionalisme dan cinta tanah air melalui nilai-nilai luhur yang berakar dari Pancasila.',
                ]],
                ['tipe' => 'paragraf', 'isi' => 'Pihak yang terlibat dalam penyusunan kurikulum :'],
                ['tipe' => 'ol', 'item' => ['Dinas Pendidikan', 'Guru', 'Kepala Sekolah', 'Pengawas Sekolah', 'Komite Sekolah', 'Paguyuban Orang tua/Wali Siswa']],
                ['tipe' => 'paragraf', 'isi' => 'Proses pembelajaran dilengkapi dengan :'],
                ['tipe' => 'ol', 'item' => ['Kurikulum 2013', 'Silabus', 'RPP', 'Buku Guru dan Siswa', 'Buku Referensi lain']],
                ['tipe' => 'subjudul', 'isi' => 'Sistem Pembelajaran'],
                ['tipe' => 'ol', 'item' => ['Daring dan luring', 'Penugasan', 'Sistem Proyek', 'Portofolio']],
                ['tipe' => 'subjudul', 'isi' => 'Penguatan Pendidikan Karakter (PPK)'],
                ['tipe' => 'ol', 'item' => ['PPK berbasis kelas', 'PPK berbasis budaya sekolah', 'PPK berbasis masyarakat']],
                ['tipe' => 'subjudul', 'isi' => 'Penilaian :'],
                ['tipe' => 'paragraf', 'isi' => 'Jenis ujian yang dilaksanakan di sekolah :'],
                ['tipe' => 'ul', 'item' => ['Ujian harian (praktek/teori)', 'Ujian tengah semester (teori)', 'Ujian akhir semester (teori)', 'Ujian tes kemampuan dasar (TKD)']],
                ['tipe' => 'paragraf', 'isi' => 'Penilaian hasil belajar memperhatikan hal-hal berikut :'],
                ['tipe' => 'ul', 'item' => [
                    'Penilaian hasil belajar dari Kemdikbud dengan penyesuaian masa darurat',
                    'mencakup aspek sikap, pengetahuan, keterampilan',
                    'Portofolio, penugasan, proyek, praktek, tulis',
                    'Hasil belajar antara lain berupa foto, gambar, video, animasi, karya seni dan bentuk lainnya tergantung jenis kegiatannya',
                ]],
                ['tipe' => 'paragraf', 'isi' => 'Kriteria Kenaikan dan Kelulusan :'],
                ['tipe' => 'ol', 'start' => 1, 'item' => ['Kriteria kenaikan kelas']],
                ['tipe' => 'ul', 'item' => [
                    'Penilaian akhir tahun (semester 2) dapat dilakukan dengan bentuk portofolio nilai rapor dan prestasi yang diperoleh',
                    'Menyelesaikan seluruh program pembelajaran pada dua semester di setiap kelas',
                    'Nilai sikap spiritual dan sikap sosial minimal Baik',
                    'Nilai di bawah KKM tidak lebih dari tiga (3) mata pelajaran',
                    'Ketidakhadiran siswa tanpa keterangan maksimal 15% dari jumlah hari efektif tatap muka ataupun Belajar Dari Rumah (BDR)',
                ]],
                ['tipe' => 'ol', 'start' => 2, 'item' => ['Kriteria kelulusan']],
                ['tipe' => 'ul', 'item' => [
                    'Menyelesaikan seluruh program pembelajaran',
                    'Memperoleh nilai minimal baik untuk seluruh kelompok mata pelajaran : Agama dan akhlak mulia, kewarganegaraan dan kepribadian, Estetika, Jasmani',
                    'Nilai sikap spiritual dan sikap sosial minimal Baik',
                    'Kelulusan ditentukan berdasarkan nilai lima semester terakhir (kelas 4, kelas 5, dan kelas 6 semester gasal). Nilai semester genap kelas 6 dapat digunakan sebagai tambahan nilai kelulusan',
                    'Hasil ujian sekolah dilakukan dalam bentuk portofolio, nilai rapor serta prestasi yang diperoleh sebelumnya',
                ]],
            ],
        ]);
    }
}
