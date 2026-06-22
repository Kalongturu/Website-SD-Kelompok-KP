<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nama',
        'jabatan',
        'nip',
        'foto',
        'is_kepala',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_kepala' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function fotoUrl(): ?string
    {
        return $this->foto ? asset('storage/' . $this->foto) : null;
    }
}
