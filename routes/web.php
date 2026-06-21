<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\KesiswaanController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('home');
});

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('fasilitas', function () {
        $sarpras = [
            ['jenis' => 'Ruang Kelas', 'ganjil' => 6, 'genap' => 6],
            ['jenis' => 'Ruang Perpustakaan', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Laboratorium', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Praktik', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang Pimpinan', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Guru', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Ibadah', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang UKS', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang Toilet', 'ganjil' => 5, 'genap' => 5],
            ['jenis' => 'Ruang Gudang', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Sirkulasi', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Tempat Bermain / Olahraga', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang TU', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang Konseling', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang OSIS', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang Bangunan', 'ganjil' => 1, 'genap' => 1],
        ];

        return view('Profil.fasilitas', compact('sarpras'));
    })->name('fasilitas');
});

Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::get('kalender', function () {
        // Data kalender akademik — nantinya bisa diambil dari database lewat dashboard admin.
        $kaldik = [
            ['judul' => 'KALDIK TP 2021/2022', 'link' => '#'],
            ['judul' => 'KALDIK TP 2020/2021', 'link' => '#'],
            ['judul' => 'KALDIK TP 2019/2020', 'link' => '#'],
            ['judul' => 'KALDIK TP 2018/2019', 'link' => '#'],
        ];

        return view('Akademik.kalender_akademik', [
            'judulKaldik' => 'KALDIK KOTA SEMARANG',
            'kaldik' => $kaldik,
        ]);
    })->name('kalender');

    Route::get('kurikulum', function () {
        // Konten kurikulum disusun sebagai blok — nantinya bisa diedit lewat dashboard admin.
        $blok = [
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
        ];

        return view('Akademik.kurikulum', [
            'judulKurikulum' => 'KURIKULUM SDN DADAPSARI SEMARANG',
            'blok' => $blok,
        ]);
    })->name('kurikulum');
});

Route::prefix('kesiswaan')->name('kesiswaan.')->group(function () {
    Route::get('ekstrakurikuler', [KesiswaanController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
    Route::get('prestasi', [KesiswaanController::class, 'prestasi'])->name('prestasi');
    Route::get('tata-tertib', [KesiswaanController::class, 'tataTertib'])->name('tata-tertib');
});

Route::prefix('informasi')->name('informasi.')->group(function () {
    // Halaman berita (kartu) + pengumuman (daftar/modal) dalam satu panel informasi.
    Route::get('berita', [InformasiController::class, 'index'])->name('index');
});

Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', function () {
        // 4 poin utama PPDB — nantinya bisa diisi/diubah lewat dashboard admin.
        $poin = [
            [
                'key' => 'pendaftaran',
                'icon' => '📝',
                'judul' => 'Pendaftaran Siswa Baru',
                'deskripsi' => 'Daftarkan calon siswa baru secara online melalui formulir pendaftaran resmi sekolah.',
                'tipe' => 'link',
                'cta' => 'Daftar Sekarang',
                'link' => '#', // ganti dengan tautan formulir pendaftaran online
            ],
            [
                'key' => 'pra-pendaftaran',
                'icon' => '📋',
                'judul' => 'Panduan Pra Pendaftaran',
                'deskripsi' => 'Hal-hal yang perlu disiapkan calon siswa dan orang tua sebelum melakukan pendaftaran.',
                'tipe' => 'panduan',
                'cta' => 'Lihat Panduan',
                'langkah' => [
                    'Siapkan Kartu Keluarga (KK) dan Akta Kelahiran calon siswa.',
                    'Pastikan usia calon siswa memenuhi syarat minimal sesuai ketentuan.',
                    'Siapkan pas foto terbaru calon siswa ukuran 3×4.',
                    'Siapkan alamat email aktif untuk menerima informasi pendaftaran.',
                    'Pelajari jadwal dan tahapan PPDB pada pengumuman resmi sekolah.',
                ],
            ],
            [
                'key' => 'pendaftaran-siswa',
                'icon' => '🖊️',
                'judul' => 'Panduan Pendaftaran',
                'deskripsi' => 'Langkah-langkah mengisi dan mengirimkan formulir pendaftaran siswa baru.',
                'tipe' => 'panduan',
                'cta' => 'Lihat Panduan',
                'langkah' => [
                    'Buka tautan formulir pendaftaran siswa baru.',
                    'Isi data diri calon siswa dan orang tua/wali dengan lengkap dan benar.',
                    'Unggah berkas persyaratan (KK, Akta Kelahiran, pas foto).',
                    'Periksa kembali seluruh data sebelum dikirim.',
                    'Kirim formulir dan simpan bukti pendaftaran.',
                ],
            ],
            [
                'key' => 'daftar-ulang',
                'icon' => '✅',
                'judul' => 'Daftar Ulang',
                'deskripsi' => 'Panduan daftar ulang bagi calon siswa yang dinyatakan diterima.',
                'tipe' => 'panduan',
                'cta' => 'Lihat Panduan',
                'langkah' => [
                    'Pastikan calon siswa dinyatakan diterima pada pengumuman PPDB.',
                    'Lengkapi dan serahkan berkas daftar ulang sesuai ketentuan sekolah.',
                    'Lakukan daftar ulang pada rentang waktu yang telah ditentukan.',
                    'Simpan bukti daftar ulang sebagai tanda telah resmi menjadi siswa.',
                ],
            ],
        ];

        return view('ppdb.index', [
            'judul' => 'Penerimaan Peserta Didik Baru',
            'poin' => $poin,
        ]);
    })->name('index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});
