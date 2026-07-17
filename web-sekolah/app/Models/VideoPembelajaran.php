<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VideoPembelajaran extends Model
{
    protected $table = 'video_pembelajaran';

    protected $fillable = [
        'judul',
        'mata_pelajaran',
        'kelas',
        'deskripsi',
        'url_video',
        'thumbnail',
        'thumbnail_mime',
        'urutan',
        'is_active',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON. */
    protected $hidden = ['thumbnail_data'];

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `thumbnail_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte gambar setiap record.
     * Byte gambar hanya diambil saat disajikan lewat route `video.thumbnail`.
     */
    public const LIST_COLUMNS = [
        'id', 'judul', 'mata_pelajaran', 'kelas', 'deskripsi', 'url_video',
        'thumbnail', 'thumbnail_mime', 'urutan', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * URL thumbnail KUSTOM yang diupload admin saja — TANPA fallback YouTube.
     * Dipakai form admin agar preview hanya muncul bila memang ada gambar kustom.
     * Null bila video ini tidak punya thumbnail kustom.
     */
    public function thumbnailKustomUrl(): ?string
    {
        if (! empty($this->thumbnail_mime)) {
            return route('video.thumbnail', $this) . '?v=' . optional($this->updated_at)->timestamp;
        }

        if (! empty($this->thumbnail)) {
            if (Str::startsWith($this->thumbnail, ['http://', 'https://'])) {
                return $this->thumbnail;
            }

            return asset('storage/' . $this->thumbnail);
        }

        return null;
    }

    /**
     * URL thumbnail video. Urutan prioritas:
     * 1. Thumbnail kustom biner (bytea) di kolom `thumbnail_data` — ditandai
     *    `thumbnail_mime`, disajikan lewat route `video.thumbnail`.
     * 2. Path/URL lama sebagai fallback untuk record yang belum dipindah.
     * 3. Thumbnail YouTube otomatis bila video-nya dari YouTube.
     */
    public function thumbnailUrl(): ?string
    {
        if ($kustom = $this->thumbnailKustomUrl()) {
            return $kustom;
        }

        // Ekstrak video ID dari berbagai format URL YouTube
        if (preg_match(
            '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $this->url_video,
            $m
        )) {
            return 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
        }

        return null;
    }

    /** Mendeteksi apakah URL adalah video YouTube. */
    public function isYoutube(): bool
    {
        return str_contains($this->url_video, 'youtube.com') ||
               str_contains($this->url_video, 'youtu.be');
    }
}
