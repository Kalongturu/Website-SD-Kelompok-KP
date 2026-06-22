<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranaPrasarana extends Model
{
    protected $table = 'sarpras';

    protected $fillable = [
        'jenis',
        'jumlah_ganjil',
        'jumlah_genap',
        'keterangan',
        'gambar',
        'urutan',
        'is_active',
    ];

    public function gambarUrl(): ?string
    {
        return $this->gambar ? asset('storage/' . $this->gambar) : null;
    }
}
