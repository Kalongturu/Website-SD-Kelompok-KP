<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    protected $table = 'kontens';
    protected $fillable = ['kunci', 'label', 'nilai'];

    /** Ambil nilai konten berdasarkan kunci (dipakai di halaman publik). */
    public static function get(string $kunci, string $default = ''): string
    {
        return static::where('kunci', $kunci)->value('nilai') ?? $default;
    }
}
