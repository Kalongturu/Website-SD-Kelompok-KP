<?php

namespace Database\Seeders;

use App\Models\Konten;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin default
        User::updateOrCreate(
            ['email' => 'admin@kp.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Konten halaman yang dapat diedit admin
        $konten = [
            ['kunci' => 'beranda_badge', 'label' => 'Beranda — Badge', 'nilai' => 'Tahun Akademik 2026'],
            ['kunci' => 'beranda_judul', 'label' => 'Beranda — Judul Hero (boleh pakai HTML)', 'nilai' => 'Program <span class="accent">Kerja Praktik</span> untuk Mahasiswa Siap Kerja'],
            ['kunci' => 'beranda_lead', 'label' => 'Beranda — Teks Pembuka', 'nilai' => 'Membangun pengalaman kerja nyata di dunia industri dan meningkatkan kompetensi mahasiswa menuju jenjang profesional.'],
            ['kunci' => 'beranda_tentang', 'label' => 'Beranda — Tentang Program', 'nilai' => 'Program Kerja Praktik dirancang untuk memberikan pengalaman magang langsung di dunia kerja, sehingga mahasiswa memperoleh pengetahuan dan keterampilan profesional yang relevan dengan kebutuhan industri.'],
            ['kunci' => 'profil_sejarah', 'label' => 'Profil — Pengantar Sejarah', 'nilai' => 'Sejak didirikan, Program Kerja Praktik terus berkembang untuk menjawab tantangan dunia industri dan kebutuhan kompetensi mahasiswa.'],
            ['kunci' => 'profil_visi', 'label' => 'Profil — Visi', 'nilai' => 'Menjadi program kerja praktik unggulan yang menghasilkan lulusan profesional, kompeten, dan siap menghadapi tantangan dunia kerja global.'],
            ['kunci' => 'profil_misi', 'label' => 'Profil — Misi (satu baris per poin)', 'nilai' => "✔ Memberikan pengalaman kerja nyata di industri terkemuka\n✔ Meningkatkan kompetensi teknis dan non-teknis mahasiswa\n✔ Memperluas jaringan kemitraan dengan dunia industri\n✔ Mendukung implementasi kebijakan MBKM"],
        ];

        foreach ($konten as $k) {
            Konten::updateOrCreate(['kunci' => $k['kunci']], $k);
        }

        // Contoh data mahasiswa awal (dari halaman statis lama)
        if (Mahasiswa::count() === 0) {
            foreach ([
                ['nama' => 'Alif', 'nim' => '123456789', 'jurusan' => 'Teknik Komputer', 'deskripsi' => 'Fokus pada bidang networking dan infrastruktur jaringan.'],
                ['nama' => 'Rafi', 'nim' => '123456790', 'jurusan' => 'Teknik Komputer', 'deskripsi' => 'Aktif dalam pengembangan sistem dan administrasi jaringan.'],
                ['nama' => 'Farhan', 'nim' => '123456791', 'jurusan' => 'Teknik Komputer'],
                ['nama' => 'Zaid', 'nim' => '123456792', 'jurusan' => 'Teknik Komputer'],
            ] as $m) {
                Mahasiswa::create($m);
            }
        }
    }
}
