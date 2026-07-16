<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Siswa extends Model
{
    protected $table = 'siswas';

    protected $fillable = [
        'nama',
        'nis',
        'kelas',
        'deskripsi',
        'foto',
        'foto_mime',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON. */
    protected $hidden = ['foto_data'];

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `foto_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte gambar setiap record.
     * Byte gambar hanya diambil saat disajikan lewat route `siswa.foto`.
     */
    public const LIST_COLUMNS = [
        'id', 'nama', 'nis', 'kelas', 'deskripsi',
        'foto', 'foto_mime', 'created_at', 'updated_at',
    ];

    /**
     * URL foto siswa. Foto disimpan sebagai DATA BINER (bytea) di kolom
     * `foto_data`; keberadaannya ditandai oleh `foto_mime` dan disajikan lewat
     * route `siswa.foto`. Bila record lama masih memakai path/URL, pakai itu
     * sebagai fallback. Null bila tidak ada foto.
     */
    public function fotoUrl(): ?string
    {
        if (! empty($this->foto_mime)) {
            return route('siswa.foto', $this) . '?v=' . optional($this->updated_at)->timestamp;
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
