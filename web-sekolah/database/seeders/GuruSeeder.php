<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        // Kepala Sekolah — sorotan utama.
        Guru::firstOrCreate(
            ['nama' => 'Siti Lestari, S.Pd.SD', 'jabatan' => 'Kepala Sekolah'],
            ['is_kepala' => true, 'urutan' => 0, 'is_active' => true],
        );

        // Guru & staf — urut sesuai jenjang kelas.
        $daftar = [
            'Lidya Eko RumiNingsih, S.Pd' => 'Guru Kelas 1A',
            'Sutrisniyati, S.Pd'         => 'Guru Kelas 1B',
            'Ismiatun Azizah, S.Pd'      => 'Guru Kelas 2A',
            'Nur Hidayati, S.Pd'         => 'Guru Kelas 2B',
            'Endang Sulistyowati, S.Pd'  => 'Guru Kelas 3A',
            'Wahyu Setiawan, S.Pd'       => 'Guru Kelas 3B',
            'Dwi Astuti, S.Pd'           => 'Guru Kelas 4A',
            'Bambang Prasetyo, S.Pd'     => 'Guru Kelas 4B',
            'Retno Wulandari, S.Pd'      => 'Guru Kelas 5A',
            'Agus Santoso, S.Pd'         => 'Guru Kelas 5B',
            'Sri Mulyani, S.Pd'          => 'Guru Kelas 6A',
            'Hartono, S.Pd'              => 'Guru Kelas 6B',
            'Muhammad Yusuf, S.Pd.I'     => 'Guru PAI',
            'Rina Marlina, S.Pd'         => 'Guru PJOK',
            'Eko Prasetyo'               => 'Operator Sekolah',
            'Slamet Riyadi'              => 'Penjaga Sekolah',
        ];

        $urutan = 1;
        foreach ($daftar as $nama => $jabatan) {
            Guru::firstOrCreate(
                ['nama' => $nama, 'jabatan' => $jabatan],
                ['is_kepala' => false, 'urutan' => $urutan++, 'is_active' => true],
            );
        }
    }
}
