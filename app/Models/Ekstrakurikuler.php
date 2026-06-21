<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ekstrakurikuler extends Model
{
    protected $table = 'ekstrakurikuler';

    protected $fillable = [
        'nama',
        'kategori',
        'icon',
        'foto',
        'deskripsi_singkat',
        'deskripsi',
        'jadwal',
        'lokasi',
        'pembina',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];
}
