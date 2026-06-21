<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TataTertib extends Model
{
    protected $table = 'tata_tertib';

    protected $fillable = [
        'kategori',
        'icon',
        'isi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    /**
     * Pecah kolom "isi" menjadi daftar butir aturan (satu baris = satu butir).
     *
     * @return array<int, string>
     */
    public function butir(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->isi))
            ->map(fn ($baris) => trim($baris))
            ->filter()
            ->values()
            ->all();
    }
}
