<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EBook extends Model
{
    protected $table = 'ebooks';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'mata_pelajaran',
        'kelas',
        'deskripsi',
        'link_url',
        'cover',
        'cover_mime',
        'urutan',
        'is_active',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON. */
    protected $hidden = ['cover_data'];

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `cover_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte gambar setiap record.
     * Byte gambar hanya diambil saat disajikan lewat route `ebook.cover`.
     */
    public const LIST_COLUMNS = [
        'id', 'judul', 'penulis', 'penerbit', 'mata_pelajaran', 'kelas',
        'deskripsi', 'link_url', 'cover', 'cover_mime',
        'urutan', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * URL cover e-book. Cover disimpan sebagai DATA BINER (bytea) di kolom
     * `cover_data`; keberadaannya ditandai oleh `cover_mime` dan disajikan lewat
     * route `ebook.cover`. Bila record lama masih memakai path/URL, pakai itu
     * sebagai fallback. Null bila tidak ada cover (kartu memakai placeholder).
     */
    public function coverUrl(): ?string
    {
        if (! empty($this->cover_mime)) {
            return route('ebook.cover', $this) . '?v=' . optional($this->updated_at)->timestamp;
        }

        if (! empty($this->cover)) {
            if (Str::startsWith($this->cover, ['http://', 'https://'])) {
                return $this->cover;
            }

            return asset('storage/' . $this->cover);
        }

        return null;
    }
}
