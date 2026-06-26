<?php

namespace App\Http\Controllers;

use App\Models\PpdbSetting;

class PpdbController extends Controller
{
    public function index()
    {
        $ppdb = PpdbSetting::getData();

        // 4 poin utama PPDB — panduan statis. Tautan "Daftar Sekarang"
        // memakai link_daftar yang diatur admin (PpdbSetting).
        $poin = [
            [
                'key' => 'pendaftaran',
                'icon' => '📝',
                'judul' => 'Pendaftaran Siswa Baru',
                'deskripsi' => 'Daftarkan calon siswa baru secara online melalui formulir pendaftaran resmi sekolah.',
                'tipe' => 'link',
                'cta' => 'Daftar Sekarang',
                'link' => $ppdb->link_daftar ?: '#',
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
    }
}
