<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSetting extends Model
{
    protected $table = 'profil_settings';

    protected $fillable = [
        'sejarah_intro',
        'sejarah_timeline',
        'sejarah_komitmen',
        'visi',
        'misi',
        'tujuan',
        'nilai',
        'bos_tahun_anggaran',
        'bos_jumlah_siswa',
        'bos_dana_per_siswa',
        'bos_total_estimasi',
        'bos_komponen',
        'bos_catatan',
    ];

    protected $casts = [
        'sejarah_timeline' => 'array',
        'misi'             => 'array',
        'tujuan'           => 'array',
        'nilai'            => 'array',
        'bos_komponen'     => 'array',
    ];

    public static function getData(): self
    {
        return static::first() ?? new static([
            'sejarah_intro' => "SDN Dadapsari merupakan salah satu sekolah dasar negeri yang berdiri sejak tahun 1985 di bawah naungan Dinas Pendidikan Kota Semarang. Sejak awal berdiri, sekolah ini telah menjadi tempat belajar yang dipercaya oleh masyarakat sekitar dalam mendidik generasi penerus bangsa.\n\nBermula dari sebuah gedung sederhana dengan beberapa ruang kelas, SDN Dadapsari terus berkembang seiring bertambahnya kepercayaan masyarakat dan dukungan pemerintah.",
            'sejarah_timeline' => [
                ['tahun' => '1985', 'judul' => 'Pendirian SDN Dadapsari',        'deskripsi' => 'Sekolah resmi berdiri dengan beberapa ruang kelas dan tenaga pengajar pertama yang penuh dedikasi.'],
                ['tahun' => '1995', 'judul' => 'Pengembangan Fasilitas Pertama', 'deskripsi' => 'Penambahan perpustakaan sekolah dan ruang olahraga sebagai sarana penunjang pendidikan.'],
                ['tahun' => '2005', 'judul' => 'Renovasi Gedung Utama',          'deskripsi' => 'Renovasi besar-besaran gedung sekolah untuk memenuhi standar bangunan pendidikan nasional.'],
                ['tahun' => '2013', 'judul' => 'Implementasi Kurikulum 2013',    'deskripsi' => 'SDN Dadapsari menjadi salah satu sekolah percontohan penerapan Kurikulum 2013 di Kota Semarang.'],
                ['tahun' => '2017', 'judul' => 'Pengembangan Era Digital',       'deskripsi' => 'Penambahan laboratorium komputer dan akses internet untuk mendukung pembelajaran berbasis teknologi.'],
                ['tahun' => '2024', 'judul' => 'Peluncuran Website Resmi',       'deskripsi' => 'SDN Dadapsari resmi meluncurkan portal website untuk meningkatkan transparansi dan komunikasi.'],
            ],
            'sejarah_komitmen' => "Selama lebih dari empat dekade, SDN Dadapsari berkomitmen untuk terus meningkatkan kualitas pendidikan. Dengan tenaga pendidik yang berpengalaman dan berdedikasi, sekolah ini telah menghasilkan ribuan lulusan yang tersebar di berbagai bidang.\n\nVisi kami tidak hanya mencerdaskan, tetapi juga membentuk karakter siswa yang beriman, bertakwa, dan memiliki kepedulian terhadap lingkungan sekitar.",
            'visi' => 'Terwujudnya sekolah yang unggul dalam prestasi, beriman, bertakwa, berkarakter mulia, berwawasan luas, dan peduli terhadap lingkungan berdasarkan Pancasila.',
            'misi' => [
                'Menyelenggarakan pendidikan yang berkualitas dan berorientasi pada pengembangan kecerdasan intelektual, emosional, dan spiritual peserta didik.',
                'Membentuk karakter siswa yang beriman, bertakwa, jujur, disiplin, dan bertanggung jawab dalam kehidupan sehari-hari.',
                'Meningkatkan prestasi akademik dan non-akademik melalui proses pembelajaran yang inovatif, kreatif, dan menyenangkan.',
                'Membangun budaya sekolah yang kondusif, inklusif, dan ramah anak sehingga setiap siswa dapat berkembang secara optimal.',
                'Menjalin kemitraan yang harmonis antara sekolah, orang tua, dan masyarakat dalam mendukung tujuan pendidikan.',
                'Mewujudkan sekolah yang berwawasan lingkungan dengan membiasakan perilaku hidup bersih, sehat, dan peduli alam.',
            ],
            'tujuan' => [
                'Menghasilkan lulusan yang menguasai kompetensi dasar sesuai Standar Kompetensi Lulusan (SKL) yang ditetapkan.',
                'Meningkatkan rata-rata nilai ujian sekolah dan mempertahankan angka kelulusan 100% setiap tahunnya.',
                'Mengembangkan potensi siswa dalam bidang seni, olahraga, dan ilmu pengetahuan melalui kegiatan ekstrakurikuler yang terprogram.',
                'Meraih prestasi di tingkat kecamatan, kota, provinsi, maupun nasional dalam berbagai lomba dan kompetisi.',
            ],
            'nilai' => [
                ['icon' => '🙏', 'nama' => 'Religius'],
                ['icon' => '⏰', 'nama' => 'Disiplin'],
                ['icon' => '🤝', 'nama' => 'Integritas'],
                ['icon' => '🌱', 'nama' => 'Peduli Lingkungan'],
                ['icon' => '🎓', 'nama' => 'Berprestasi'],
                ['icon' => '❤️', 'nama' => 'Gotong Royong'],
            ],
            'bos_tahun_anggaran'  => '2023 / 2024',
            'bos_jumlah_siswa'    => '± 520 Siswa',
            'bos_dana_per_siswa'  => 'Rp 900.000 / tahun',
            'bos_total_estimasi'  => '± Rp 468.000.000',
            'bos_komponen' => [
                ['nama' => 'Pengembangan Perpustakaan',              'persen' => '5%',  'estimasi' => '23.400.000',  'status' => 'Terlaksana'],
                ['nama' => 'Kegiatan Penerimaan Peserta Didik',      'persen' => '2%',  'estimasi' => '9.360.000',   'status' => 'Terlaksana'],
                ['nama' => 'Kegiatan Pembelajaran & Ekstrakurikuler','persen' => '15%', 'estimasi' => '70.200.000',  'status' => 'Berjalan'],
                ['nama' => 'Kegiatan Evaluasi Pembelajaran',         'persen' => '8%',  'estimasi' => '37.440.000',  'status' => 'Terlaksana'],
                ['nama' => 'Pengelolaan Sekolah',                    'persen' => '5%',  'estimasi' => '23.400.000',  'status' => 'Berjalan'],
                ['nama' => 'Pengembangan Profesi Guru & Tendik',     'persen' => '10%', 'estimasi' => '46.800.000',  'status' => 'Berjalan'],
                ['nama' => 'Langganan Daya & Jasa',                  'persen' => '4%',  'estimasi' => '18.720.000',  'status' => 'Berjalan'],
                ['nama' => 'Pemeliharaan Sarana & Prasarana',        'persen' => '15%', 'estimasi' => '70.200.000',  'status' => 'Berjalan'],
                ['nama' => 'Pembayaran Honor',                       'persen' => '30%', 'estimasi' => '140.400.000', 'status' => 'Berjalan'],
                ['nama' => 'Pembelian & Perawatan Alat Multimedia',  'persen' => '4%',  'estimasi' => '18.720.000',  'status' => 'Direncanakan'],
                ['nama' => 'Biaya Lainnya',                          'persen' => '2%',  'estimasi' => '9.360.000',   'status' => 'Direncanakan'],
            ],
            'bos_catatan' => 'Data di atas merupakan rencana penggunaan Dana BOS dan dapat berubah sesuai kebutuhan nyata sekolah dengan tetap mengacu pada Peraturan Menteri Pendidikan dan Kebudayaan yang berlaku. Realisasi penggunaan dana akan dipublikasikan setiap akhir triwulan.',
        ]);
    }
}
