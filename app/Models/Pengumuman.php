<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'ringkasan',
        'isi',
        'lampiran',
        'penting',
        'tanggal',
        'is_active',
    ];

    protected $casts = [
        'penting'   => 'boolean',
        'tanggal'   => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Preview keterangan untuk daftar pengumuman.
     */
    public function preview(int $panjang = 110): string
    {
        $teks = $this->ringkasan ?: strip_tags((string) $this->isi);

        return Str::limit(trim($teks), $panjang);
    }
}
