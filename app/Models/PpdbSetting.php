<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PpdbSetting extends Model
{
    protected $table = 'ppdb_settings';

    protected $fillable = [
        'tahun_ajaran',
        'is_open',
        'tanggal_buka',
        'tanggal_tutup',
        'link_daftar',
        'pengumuman',
    ];

    protected $casts = [
        'is_open'       => 'boolean',
        'tanggal_buka'  => 'date',
        'tanggal_tutup' => 'date',
    ];

    public static function getData(): self
    {
        return static::first() ?? new static([
            'tahun_ajaran' => '2026/2027',
            'is_open'      => false,
            'link_daftar'  => '#',
            'pengumuman'   => 'Bergabunglah bersama keluarga besar SDN Dadapsari. Kuota terbatas, daftarkan putra-putri Anda sekarang.',
        ]);
    }
}
