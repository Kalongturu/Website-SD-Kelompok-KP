<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
        'foto_mime',
        'is_kepala',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_kepala' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `foto_data`
     * (bytea, bisa besar) agar halaman daftar tidak menarik byte gambar setiap
     * record. Byte gambar hanya diambil saat disajikan lewat route `guru.foto`.
     */
    public const LIST_COLUMNS = [
        'id', 'nama', 'jabatan', 'nip', 'foto_mime',
        'is_kepala', 'urutan', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * URL gambar guru/staf. Foto disimpan sebagai DATA BINER (bytea) di kolom
     * `foto_data`; keberadaannya ditandai oleh `foto_mime`. Gambar disajikan
     * lewat route `guru.foto`. Null bila record belum punya foto.
     */
    public function fotoUrl(): ?string
    {
        if (empty($this->foto_mime)) {
            return null;
        }

        return route('guru.foto', $this) . '?v=' . optional($this->updated_at)->timestamp;
    }
}
