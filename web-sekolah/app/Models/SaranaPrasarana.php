<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SaranaPrasarana extends Model
{
    protected $table = 'sarpras';

    protected $fillable = [
        'jenis',
        'jumlah_ganjil',
        'jumlah_genap',
        'keterangan',
        'gambar',
        'gambar_mime',
        'urutan',
        'is_active',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON. */
    protected $hidden = ['gambar_data'];

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `gambar_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte gambar setiap record.
     * Byte gambar hanya diambil saat disajikan lewat route `sarpras.gambar`.
     */
    public const LIST_COLUMNS = [
        'id', 'jenis', 'jumlah_ganjil', 'jumlah_genap', 'keterangan',
        'gambar', 'gambar_mime', 'urutan', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * URL gambar sarana prasarana. Gambar disimpan sebagai DATA BINER (bytea) di
     * kolom `gambar_data`; keberadaannya ditandai oleh `gambar_mime` dan disajikan
     * lewat route `sarpras.gambar`. Bila record lama masih memakai path/URL, pakai
     * itu sebagai fallback. Null bila tidak ada gambar.
     */
    public function gambarUrl(): ?string
    {
        if (! empty($this->gambar_mime)) {
            return route('sarpras.gambar', $this) . '?v=' . optional($this->updated_at)->timestamp;
        }

        if (! empty($this->gambar)) {
            if (Str::startsWith($this->gambar, ['http://', 'https://'])) {
                return $this->gambar;
            }

            return asset('storage/' . $this->gambar);
        }

        return null;
    }
}
