<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuangKelas extends Model
{
    protected $table = 'ruang_kelas';

    protected $fillable = [
        'nama_kelas',
        'jumlah_siswa',
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
