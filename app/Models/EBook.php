<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EBook extends Model
{
    protected $table = 'ebooks';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'mata_pelajaran',
        'kelas',
        'deskripsi',
        'link_url',
        'cover',
        'urutan',
        'is_active',
    ];

    public function coverUrl(): ?string
    {
        return $this->cover ? asset('storage/' . $this->cover) : null;
    }
}
