<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'nama',
        'kategori',
        'icon',
        'foto',
        'foto_mime',
        'deskripsi_singkat',
        'deskripsi',
        'jadwal',
        'lokasi',
        'pembina',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON. */
    protected $hidden = ['foto_data'];

    /**
     * `foto_url` ikut serta saat model di-serialisasi ke JSON (dipakai panel
     * detail ekskul di sisi JavaScript). Tanpa ini JS tidak tahu URL gambar,
     * karena kolom `foto` sudah NULL untuk record yang gambarnya biner.
     */
    protected $appends = ['foto_url'];

    public function getFotoUrlAttribute(): ?string
    {
        return $this->fotoUrl();
    }

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `foto_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte gambar setiap record.
     * Byte gambar hanya diambil saat disajikan lewat route `ekskul.foto`.
     */
    public const LIST_COLUMNS = [
        'id', 'nama', 'kategori', 'icon', 'foto', 'foto_mime',
        'deskripsi_singkat', 'deskripsi', 'jadwal', 'lokasi', 'pembina',
        'urutan', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * URL foto ekstrakurikuler. Foto disimpan sebagai DATA BINER (bytea) di kolom
     * `foto_data`; keberadaannya ditandai oleh `foto_mime` dan disajikan lewat
     * route `ekskul.foto`. Bila record lama masih memakai path/URL, pakai itu
     * sebagai fallback. Null bila tidak ada foto (kartu memakai ikon/placeholder).
     */
    public function fotoUrl(): ?string
    {
        if (! empty($this->foto_mime)) {
            return route('ekskul.foto', $this) . '?v=' . optional($this->updated_at)->timestamp;
        }

        if (! empty($this->foto)) {
            if (Str::startsWith($this->foto, ['http://', 'https://'])) {
                return $this->foto;
            }

            return asset('storage/' . $this->foto);
        }

        return null;
    }
}
