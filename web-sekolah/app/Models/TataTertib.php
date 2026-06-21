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
        'dokumen',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    public function butir(): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $this->isi))
            ->map(fn ($baris) => trim($baris))
            ->filter()
            ->values()
            ->all();
    }

    public function dokumenUrl(): ?string
    {
        if (! $this->dokumen) return null;
        return asset('storage/' . $this->dokumen);
    }
}
