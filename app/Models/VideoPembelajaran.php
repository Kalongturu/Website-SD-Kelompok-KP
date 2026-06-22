<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'urutan',
        'is_active',
    ];

    /** Thumbnail otomatis dari YouTube bila tidak ada gambar custom. */
    public function thumbnailUrl(): ?string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
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
