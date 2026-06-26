<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Pengumuman;
use App\Models\Pesan;
use App\Models\Prestasi;
use App\Models\RuangKelas;
use Illuminate\Support\Str;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'siswa'        => (int) RuangKelas::where('is_active', true)->sum('jumlah_siswa'),
            'guru'         => Guru::where('is_active', true)->count(),
            'berita'       => Berita::where('is_active', true)->count(),
            'pengumuman'   => Pengumuman::where('is_active', true)->count(),
        ];

        $aktivitas = $this->recentActivities();

        return view('admin.admin_dashboard', compact('stats', 'aktivitas'));
    }

    /**
     * Bangun feed "Aktivitas Terbaru" dari data nyata: gabungkan record
     * terbaru dari beberapa tabel konten, urutkan dari yang paling baru.
     */
    private function recentActivities(int $limit = 6): array
    {
        // Tiap sumber: model, ikon & warna (untuk badge di view), pembuat label,
        // pelaku ("oleh"), dan tautan tujuan saat baris diklik.
        $sources = [
            [
                'model' => Pesan::class,
                'icon'  => 'envelope-fill', 'warna' => 'primary',
                'label' => fn ($r) => 'Pesan masuk dari ' . Str::limit($r->nama, 40),
                'oleh'  => fn ($r) => 'Pengunjung',
                'link'  => fn ($r) => route('admin.pesan.show', $r),
            ],
            [
                'model' => Berita::class,
                'icon'  => 'newspaper', 'warna' => 'info',
                'label' => fn ($r) => 'Berita: ' . Str::limit($r->judul, 55),
                'oleh'  => fn ($r) => 'Admin',
                'link'  => fn ($r) => route('admin.berita.edit', $r),
            ],
            [
                'model' => Pengumuman::class,
                'icon'  => 'megaphone-fill', 'warna' => 'warning',
                'label' => fn ($r) => 'Pengumuman: ' . Str::limit($r->judul, 55),
                'oleh'  => fn ($r) => 'Admin',
                'link'  => fn ($r) => route('admin.pengumuman.edit', $r),
            ],
            [
                'model' => Galeri::class,
                'icon'  => 'images', 'warna' => 'success',
                'label' => fn ($r) => 'Foto galeri: ' . Str::limit($r->judul, 55),
                'oleh'  => fn ($r) => 'Admin',
                'link'  => fn ($r) => route('admin.galeri.edit', $r),
            ],
            [
                'model' => Prestasi::class,
                'icon'  => 'award-fill', 'warna' => 'warning',
                'label' => fn ($r) => 'Prestasi: ' . Str::limit($r->nama_kejuaraan, 55),
                'oleh'  => fn ($r) => 'Admin',
                'link'  => fn ($r) => route('admin.prestasi.edit', $r),
            ],
            [
                'model' => Guru::class,
                'icon'  => 'person-badge-fill', 'warna' => 'secondary',
                'label' => fn ($r) => 'Data guru/staf: ' . Str::limit($r->nama, 45),
                'oleh'  => fn ($r) => 'Admin',
                'link'  => fn ($r) => route('admin.guru.edit', $r),
            ],
            [
                'model' => Ekstrakurikuler::class,
                'icon'  => 'trophy-fill', 'warna' => 'info',
                'label' => fn ($r) => 'Ekstrakurikuler: ' . Str::limit($r->nama, 50),
                'oleh'  => fn ($r) => 'Admin',
                'link'  => fn ($r) => route('admin.ekskul.edit', $r),
            ],
        ];

        $items = collect();

        foreach ($sources as $src) {
            $src['model']::query()
                ->latest()                 // urut berdasarkan created_at terbaru
                ->take($limit)
                ->get()
                ->each(function ($r) use ($src, $items) {
                    if ($r->created_at === null) {
                        return;
                    }

                    $items->push([
                        'aksi'  => ($src['label'])($r),
                        'oleh'  => ($src['oleh'])($r),
                        'ikon'  => $src['icon'],
                        'warna' => $src['warna'],
                        'waktu' => $r->created_at->locale('id')->diffForHumans(),
                        'ts'    => $r->created_at,
                        'link'  => ($src['link'])($r),
                    ]);
                });
        }

        return $items
            ->sortByDesc('ts')
            ->take($limit)
            ->values()
            ->all();
    }
}
