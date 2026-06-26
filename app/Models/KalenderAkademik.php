<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    protected $table = 'kalender_akademik_dokumen';

    protected $fillable = [
        'tahun_ajaran',
        'file_path',
        'file_name',
        'urutan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    public function fileUrl(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
