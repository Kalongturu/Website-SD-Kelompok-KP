<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas';

    protected $fillable = [
        'nama',
        'nim',
        'jurusan',
        'deskripsi',
        'foto',
    ];

    public function fotoUrl(): ?string
    {
        if (! $this->foto) return null;
        if (Str::startsWith($this->foto, ['http://', 'https://'])) return $this->foto;
        return asset('storage/' . $this->foto);
    }
}
