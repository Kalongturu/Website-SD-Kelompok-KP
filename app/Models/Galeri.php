<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'judul',
        'kategori',
        'gambar',
        'keterangan',
        'tanggal',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'urutan'    => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * URL gambar — dukung path storage maupun URL eksternal.
     * Mengembalikan null bila tidak ada gambar (kartu memakai placeholder).
     */
    public function gambarUrl(): ?string
    {
        if (! $this->gambar) {
            return null;
        }

        if (Str::startsWith($this->gambar, ['http://', 'https://'])) {
            return $this->gambar;
        }

        return asset('storage/' . $this->gambar);
    }
}
