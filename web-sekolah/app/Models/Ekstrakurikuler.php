<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function fotoUrl(): ?string
    {
        if (! $this->foto) return null;
        if (Str::startsWith($this->foto, ['http://', 'https://'])) return $this->foto;
        return asset('storage/' . $this->foto);
    }
}
