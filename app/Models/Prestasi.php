<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'deskripsi',
        'foto',
        'is_active',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'is_active' => 'boolean',
    ];
}
