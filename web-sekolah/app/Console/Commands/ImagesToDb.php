<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Memindahkan gambar LAMA yang masih tersimpan sebagai PATH TEKS di database ke
 * kolom biner (bytea) sehingga gambarnya ikut tersimpan di database dan bisa
 * dilihat SEMUA user — bukan hanya di mesin yang punya file-nya.
 *
 * Aman dijalankan berulang: record yang sudah punya <kolom>_mime dilewati, dan
 * record yang file-nya sudah tidak ada di disk dilaporkan sebagai "hilang"
 * tanpa menggagalkan proses.
 *
 * Jalankan: php artisan images:to-db
 *           php artisan images:to-db --dry-run   (lihat rencananya saja)
 */
class ImagesToDb extends Command
{
    protected $signature = 'images:to-db {--dry-run : Tampilkan apa yang akan dipindah tanpa mengubah database}';

    protected $description = 'Pindahkan gambar lama dari path file (teks) ke kolom biner (bytea) di database';

    /** tabel => kolom gambar */
    private const TARGETS = [
        'ekstrakurikuler'    => 'foto',
        'prestasi'           => 'foto',
        'sarpras'            => 'gambar',
        'ruang_kelas'        => 'gambar',
        'ebooks'             => 'cover',
        'siswas'             => 'foto',
        'video_pembelajaran' => 'thumbnail',
    ];

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        if ($dryRun) {
            $this->warn('Mode --dry-run: tidak ada perubahan yang disimpan.');
        }

        $totalPindah = $totalHilang = 0;

        foreach (self::TARGETS as $tabel => $kolom) {
            $rows = DB::table($tabel)
                ->whereNotNull($kolom)
                ->where($kolom, '!=', '')
                ->whereNull($kolom . '_mime')      // yang sudah biner dilewati
                ->get(['id', $kolom]);

            if ($rows->isEmpty()) {
                $this->line("• {$tabel}: tidak ada yang perlu dipindah.");
                continue;
            }

            $pindah = $hilang = 0;

            foreach ($rows as $row) {
                $path = $row->$kolom;

                // URL eksternal dibiarkan apa adanya — accessor sudah memakainya langsung.
                if (Str::startsWith($path, ['http://', 'https://'])) {
                    continue;
                }

                if (! Storage::disk('public')->exists($path)) {
                    $this->warn("  - {$tabel}#{$row->id}: file hilang di disk → {$path}");
                    $hilang++;
                    continue;
                }

                if ($dryRun) {
                    $this->line("  - {$tabel}#{$row->id}: akan dipindah ← {$path}");
                    $pindah++;
                    continue;
                }

                $bytes = Storage::disk('public')->get($path);
                $mime  = Storage::disk('public')->mimeType($path) ?: 'image/jpeg';

                // decode(?, 'base64') -> bytea, sama seperti alur upload.
                DB::update(
                    "UPDATE {$tabel} SET {$kolom}_data = decode(?, 'base64'), {$kolom}_mime = ?, {$kolom} = NULL WHERE id = ?",
                    [base64_encode($bytes), $mime, $row->id]
                );

                $pindah++;
            }

            $this->info("• {$tabel}: {$pindah} dipindah, {$hilang} file hilang.");
            $totalPindah += $pindah;
            $totalHilang += $hilang;
        }

        $this->newLine();
        $this->info("Selesai. Total {$totalPindah} gambar dipindah ke database, {$totalHilang} file tidak ditemukan.");

        if ($totalHilang > 0) {
            $this->warn('Record dengan file hilang tetap menyimpan path lamanya — gambarnya perlu diupload ulang lewat dashboard admin.');
        }

        return self::SUCCESS;
    }
}
