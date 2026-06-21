<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'tempat',
        'deskripsi',
        'foto',
        'is_active',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'is_active' => 'boolean',
    ];

    public function fotoUrl(): ?string
    {
        if (! $this->foto) return null;
        if (Str::startsWith($this->foto, ['http://', 'https://'])) return $this->foto;
        return asset('storage/' . $this->foto);
    }
}
