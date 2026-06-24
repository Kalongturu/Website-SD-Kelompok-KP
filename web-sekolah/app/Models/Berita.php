<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'kategori',
        'ringkasan',
        'isi',
        'gambar',
        'gambar_mime',
        'penulis',
        'tanggal',
        'is_active',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'is_active' => 'boolean',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON (mis. payload modal). */
    protected $hidden = ['gambar_data'];

    /** Selalu sertakan URL gambar saat di-serialisasi ke JSON (dipakai modal di frontend). */
    protected $appends = ['gambar_url'];

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `gambar_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte gambar setiap record.
     * Byte gambar hanya diambil saat disajikan lewat route `berita.gambar`.
     */
    public const LIST_COLUMNS = [
        'id', 'judul', 'kategori', 'ringkasan', 'isi', 'gambar', 'gambar_mime',
        'penulis', 'tanggal', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * URL gambar berita. Gambar disimpan sebagai DATA BINER (bytea) di kolom
     * `gambar_data`; keberadaannya ditandai oleh `gambar_mime` dan disajikan lewat
     * route `berita.gambar`. Bila record lama masih memakai path file, pakai itu
     * sebagai fallback. Null bila tidak ada gambar (kartu memakai placeholder).
     */
    public function getGambarUrlAttribute(): ?string
    {
        if (! empty($this->gambar_mime)) {
            return route('berita.gambar', $this) . '?v=' . optional($this->updated_at)->timestamp;
        }

        if (! empty($this->gambar)) {
            return asset('storage/' . $this->gambar);
        }

        return null;
    }

    /**
     * Ringkasan untuk kartu — pakai kolom ringkasan bila ada, jika tidak potong dari isi.
     */
    public function preview(int $panjang = 120): string
    {
        $teks = $this->ringkasan ?: strip_tags((string) $this->isi);

        return Str::limit(trim($teks), $panjang);
    }
}
