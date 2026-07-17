<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prestasi extends Model
{
    protected $table = 'prestasi';

    protected $fillable = [
        'nama_kejuaraan',
        'kategori',
        'tingkat',
        'peringkat',
        'nama_siswa',
        'kelas',
        'penyelenggara',
        'tanggal',
        'tempat',
        'deskripsi',
        'foto',
        'foto_mime',
        'is_active',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'is_active' => 'boolean',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON. */
    protected $hidden = ['foto_data'];

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `foto_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte gambar setiap record.
     * Byte gambar hanya diambil saat disajikan lewat route `prestasi.foto`.
     */
    public const LIST_COLUMNS = [
        'id', 'nama_kejuaraan', 'kategori', 'tingkat', 'peringkat', 'nama_siswa',
        'kelas', 'penyelenggara', 'tanggal', 'tempat', 'deskripsi',
        'foto', 'foto_mime', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * URL foto prestasi. Foto disimpan sebagai DATA BINER (bytea) di kolom
     * `foto_data`; keberadaannya ditandai oleh `foto_mime` dan disajikan lewat
     * route `prestasi.foto`. Bila record lama masih memakai path/URL, pakai itu
     * sebagai fallback. Null bila tidak ada foto.
     */
    public function fotoUrl(): ?string
    {
        if (! empty($this->foto_mime)) {
            return route('prestasi.foto', $this) . '?v=' . optional($this->updated_at)->timestamp;
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
