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
        'penulis',
        'tanggal',
        'is_active',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Ringkasan untuk kartu — pakai kolom ringkasan bila ada, jika tidak potong dari isi.
     */
    public function preview(int $panjang = 120): string
    {
        $teks = $this->ringkasan ?: strip_tags((string) $this->isi);

        return Str::limit(trim($teks), $panjang);
    }
}
