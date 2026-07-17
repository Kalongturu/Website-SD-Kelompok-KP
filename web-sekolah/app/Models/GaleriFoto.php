<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GaleriFoto extends Model
{
    protected $table = 'galeri_foto';

    protected $fillable = [
        'galeri_id',
        'gambar_mime',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON. */
    protected $hidden = ['gambar_data'];

    /**
     * Kolom ringan untuk query DAFTAR/eager-load. Sengaja TIDAK menyertakan
     * `gambar_data` (bytea) agar daftar album tidak menarik byte semua foto.
     */
    public const LIST_COLUMNS = [
        'id', 'galeri_id', 'gambar_mime', 'urutan',
    ];

    public function galeri(): BelongsTo
    {
        return $this->belongsTo(Galeri::class);
    }

    /** URL foto ini, disajikan lewat route biner `galeri-foto.gambar`. Null bila kosong. */
    public function gambarUrl(): ?string
    {
        if (empty($this->gambar_mime)) {
            return null;
        }

        return route('galeri-foto.gambar', $this) . '?v=' . optional($this->updated_at)->timestamp;
    }
}
