<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\KontakController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\PpdbController;
use App\Http\Controllers\Admin\EkstrakurikulerController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\TataTertibController;
use App\Http\Controllers\Admin\SarprasController;
use App\Http\Controllers\Admin\RuangKelasController;
use App\Http\Controllers\Admin\ProfilSettingController;
use App\Http\Controllers\Admin\EBookController;
use App\Http\Controllers\Admin\VideoPembelajaranController;
use App\Http\Controllers\Admin\KalenderAkademikController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\KesiswaanController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\AkademikController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Models\PpdbSetting;

// Semua route publik — admin yang masih login diarahkan kembali ke dashboard
Route::middleware('redirect.admin')->group(function () {

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('sejarah',              [ProfilController::class, 'sejarah'])->name('sejarah');
    Route::get('visi-misi',            [ProfilController::class, 'visiMisi'])->name('visi-misi');
    Route::get('transparansi-dana-bos',[ProfilController::class, 'transparansiDanaBos'])->name('transparansi-dana-bos');
    Route::get('fasilitas',            [ProfilController::class, 'fasilitas'])->name('fasilitas');
});

Route::prefix('akademik')->name('akademik.')->group(function () {
    Route::get('kalender', function () {
        // Data kalender akademik — nantinya bisa diambil dari database lewat dashboard admin.
        return app(AkademikController::class)->kalender();
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

    // Guru & Staf — data dikelola lewat dashboard admin.
    Route::get('guru', [AkademikController::class, 'guru'])->name('guru');
});

Route::prefix('kesiswaan')->name('kesiswaan.')->group(function () {
    Route::get('ekstrakurikuler', [KesiswaanController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
    Route::get('prestasi', [KesiswaanController::class, 'prestasi'])->name('prestasi');
    Route::get('tata-tertib', [KesiswaanController::class, 'tataTertib'])->name('tata-tertib');
});

Route::prefix('informasi')->name('informasi.')->group(function () {
    // Halaman berita (kartu) + pengumuman (daftar/modal) dalam satu panel informasi.
    Route::get('berita', [InformasiController::class, 'index'])->name('index');
    // Galeri foto — kartu foto yang menampilkan keterangan saat diklik.
    Route::get('galeri', [InformasiController::class, 'galeri'])->name('galeri');
});

Route::prefix('ppdb')->name('ppdb.')->group(function () {
    Route::get('/', function () {
        $ppdb = PpdbSetting::getData();

        // 4 poin utama PPDB — template panduan statis.
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
            'poin'  => $poin,
            'ppdb'  => $ppdb,
        ]);
    })->name('index');
});

}); // end redirect.admin group

Route::prefix('admin')->name('admin.')->middleware('nocache')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Profil Admin — edit data akun (nama, email, avatar) & ganti password
        Route::get('profile',           [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile',           [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password',  [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::delete('profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

        // Akademik - Kalender Akademik
        Route::prefix('kalender-akademik')->name('kalender-akademik.')->group(function () {
            Route::get('/',                            [KalenderAkademikController::class, 'index'])->name('index');
            Route::get('/create',                     [KalenderAkademikController::class, 'create'])->name('create');
            Route::post('/',                          [KalenderAkademikController::class, 'store'])->name('store');
            Route::get('/{kalenderAkademik}/edit',    [KalenderAkademikController::class, 'edit'])->name('edit');
            Route::put('/{kalenderAkademik}',         [KalenderAkademikController::class, 'update'])->name('update');
            Route::delete('/{kalenderAkademik}',      [KalenderAkademikController::class, 'destroy'])->name('destroy');
            Route::patch('/{kalenderAkademik}/toggle',[KalenderAkademikController::class, 'toggle'])->name('toggle');
        });

        // Akademik - Guru & Staf
        Route::prefix('guru')->name('guru.')->group(function () {
            Route::get('/',                 [GuruController::class, 'index'])->name('index');
            Route::get('/create',           [GuruController::class, 'create'])->name('create');
            Route::post('/',                [GuruController::class, 'store'])->name('store');
            Route::get('/{guru}/edit',      [GuruController::class, 'edit'])->name('edit');
            Route::put('/{guru}',           [GuruController::class, 'update'])->name('update');
            Route::delete('/{guru}',        [GuruController::class, 'destroy'])->name('destroy');
            Route::patch('/{guru}/toggle',  [GuruController::class, 'toggle'])->name('toggle');
        });

        // Profil — Konten (Sejarah / Visi Misi / Dana BOS)
        Route::get('profil-setting',  [ProfilSettingController::class, 'edit'])->name('profil-setting.edit');
        Route::put('profil-setting',  [ProfilSettingController::class, 'update'])->name('profil-setting.update');

        // Kontak & Footer
        Route::get('kontak', [KontakController::class, 'edit'])->name('kontak');
        Route::put('kontak', [KontakController::class, 'update'])->name('kontak.update');

        // Berita
        Route::get('berita',                  [BeritaController::class, 'index'])->name('berita.index');
        Route::get('berita/create',           [BeritaController::class, 'create'])->name('berita.create');
        Route::post('berita',                 [BeritaController::class, 'store'])->name('berita.store');
        Route::get('berita/{berita}/edit',    [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('berita/{berita}',         [BeritaController::class, 'update'])->name('berita.update');
        Route::delete('berita/{berita}',      [BeritaController::class, 'destroy'])->name('berita.destroy');
        Route::patch('berita/{berita}/toggle',[BeritaController::class, 'toggle'])->name('berita.toggle');

        // Pengumuman
        Route::get('pengumuman',                        [PengumumanController::class, 'index'])->name('pengumuman.index');
        Route::get('pengumuman/create',                 [PengumumanController::class, 'create'])->name('pengumuman.create');
        Route::post('pengumuman',                       [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::get('pengumuman/{pengumuman}/edit',      [PengumumanController::class, 'edit'])->name('pengumuman.edit');
        Route::put('pengumuman/{pengumuman}',           [PengumumanController::class, 'update'])->name('pengumuman.update');
        Route::delete('pengumuman/{pengumuman}',        [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
        Route::patch('pengumuman/{pengumuman}/toggle',  [PengumumanController::class, 'toggle'])->name('pengumuman.toggle');

        // Galeri
        Route::get('galeri',                  [GaleriController::class, 'index'])->name('galeri.index');
        Route::get('galeri/create',           [GaleriController::class, 'create'])->name('galeri.create');
        Route::post('galeri',                 [GaleriController::class, 'store'])->name('galeri.store');
        Route::get('galeri/{galeri}/edit',    [GaleriController::class, 'edit'])->name('galeri.edit');
        Route::put('galeri/{galeri}',         [GaleriController::class, 'update'])->name('galeri.update');
        Route::delete('galeri/{galeri}',      [GaleriController::class, 'destroy'])->name('galeri.destroy');
        Route::patch('galeri/{galeri}/toggle',[GaleriController::class, 'toggle'])->name('galeri.toggle');

        // PPDB Settings
        Route::get('ppdb',  [PpdbController::class, 'index'])->name('ppdb.index');
        Route::put('ppdb',  [PpdbController::class, 'update'])->name('ppdb.update');

        // Kesiswaan — Ekstrakurikuler
        Route::prefix('ekskul')->name('ekskul.')->group(function () {
            Route::get('/',                             [EkstrakurikulerController::class, 'index'])->name('index');
            Route::get('/create',                       [EkstrakurikulerController::class, 'create'])->name('create');
            Route::post('/',                            [EkstrakurikulerController::class, 'store'])->name('store');
            Route::get('/{ekstrakurikuler}/edit',       [EkstrakurikulerController::class, 'edit'])->name('edit');
            Route::put('/{ekstrakurikuler}',            [EkstrakurikulerController::class, 'update'])->name('update');
            Route::delete('/{ekstrakurikuler}',         [EkstrakurikulerController::class, 'destroy'])->name('destroy');
            Route::patch('/{ekstrakurikuler}/toggle',   [EkstrakurikulerController::class, 'toggle'])->name('toggle');
        });

        // Kesiswaan — Prestasi
        Route::prefix('prestasi')->name('prestasi.')->group(function () {
            Route::get('/',                             [PrestasiController::class, 'index'])->name('index');
            Route::get('/create',                       [PrestasiController::class, 'create'])->name('create');
            Route::post('/',                            [PrestasiController::class, 'store'])->name('store');
            Route::get('/{prestasi}/edit',              [PrestasiController::class, 'edit'])->name('edit');
            Route::put('/{prestasi}',                   [PrestasiController::class, 'update'])->name('update');
            Route::delete('/{prestasi}',                [PrestasiController::class, 'destroy'])->name('destroy');
            Route::patch('/{prestasi}/toggle',          [PrestasiController::class, 'toggle'])->name('toggle');
        });

        // Profil — Sarana & Prasarana
        Route::prefix('sarpras')->name('sarpras.')->group(function () {
            Route::get('/',                     [SarprasController::class, 'index'])->name('index');
            Route::get('/create',               [SarprasController::class, 'create'])->name('create');
            Route::post('/',                    [SarprasController::class, 'store'])->name('store');
            Route::get('/{sarpra}/edit',        [SarprasController::class, 'edit'])->name('edit');
            Route::put('/{sarpra}',             [SarprasController::class, 'update'])->name('update');
            Route::delete('/{sarpra}',          [SarprasController::class, 'destroy'])->name('destroy');
            Route::patch('/{sarpra}/toggle',    [SarprasController::class, 'toggle'])->name('toggle');
        });

        // Profil — Ruang Kelas
        Route::prefix('ruang-kelas')->name('ruang-kelas.')->group(function () {
            Route::get('/',                         [RuangKelasController::class, 'index'])->name('index');
            Route::get('/create',                   [RuangKelasController::class, 'create'])->name('create');
            Route::post('/',                        [RuangKelasController::class, 'store'])->name('store');
            Route::get('/{ruangKelas}/edit',        [RuangKelasController::class, 'edit'])->name('edit');
            Route::put('/{ruangKelas}',             [RuangKelasController::class, 'update'])->name('update');
            Route::delete('/{ruangKelas}',          [RuangKelasController::class, 'destroy'])->name('destroy');
            Route::patch('/{ruangKelas}/toggle',    [RuangKelasController::class, 'toggle'])->name('toggle');
        });

        // Profil — E-Book Pembelajaran
        Route::prefix('ebook')->name('ebook.')->group(function () {
            Route::get('/',                 [EBookController::class, 'index'])->name('index');
            Route::get('/create',           [EBookController::class, 'create'])->name('create');
            Route::post('/',                [EBookController::class, 'store'])->name('store');
            Route::get('/{ebook}/edit',     [EBookController::class, 'edit'])->name('edit');
            Route::put('/{ebook}',          [EBookController::class, 'update'])->name('update');
            Route::delete('/{ebook}',       [EBookController::class, 'destroy'])->name('destroy');
            Route::patch('/{ebook}/toggle', [EBookController::class, 'toggle'])->name('toggle');
        });

        // Profil — Video Pembelajaran
        Route::prefix('video')->name('video.')->group(function () {
            Route::get('/',                 [VideoPembelajaranController::class, 'index'])->name('index');
            Route::get('/create',           [VideoPembelajaranController::class, 'create'])->name('create');
            Route::post('/',                [VideoPembelajaranController::class, 'store'])->name('store');
            Route::get('/{video}/edit',     [VideoPembelajaranController::class, 'edit'])->name('edit');
            Route::put('/{video}',          [VideoPembelajaranController::class, 'update'])->name('update');
            Route::delete('/{video}',       [VideoPembelajaranController::class, 'destroy'])->name('destroy');
            Route::patch('/{video}/toggle', [VideoPembelajaranController::class, 'toggle'])->name('toggle');
        });

        // Kesiswaan — Tata Tertib
        Route::prefix('tata-tertib')->name('tata-tertib.')->group(function () {
            Route::get('/',                             [TataTertibController::class, 'index'])->name('index');
            Route::get('/create',                       [TataTertibController::class, 'create'])->name('create');
            Route::post('/',                            [TataTertibController::class, 'store'])->name('store');
            Route::get('/{tataTertib}/edit',            [TataTertibController::class, 'edit'])->name('edit');
            Route::put('/{tataTertib}',                 [TataTertibController::class, 'update'])->name('update');
            Route::delete('/{tataTertib}',              [TataTertibController::class, 'destroy'])->name('destroy');
            Route::patch('/{tataTertib}/toggle',        [TataTertibController::class, 'toggle'])->name('toggle');
        });
    });
});
