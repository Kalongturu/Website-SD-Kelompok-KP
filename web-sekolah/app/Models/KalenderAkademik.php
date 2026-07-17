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
        'file_mime',
        'urutan',
        'is_active',
    ];

    /** Jangan pernah ikut serialisasi byte file ke array/JSON. */
    protected $hidden = ['file_data'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    /** Apakah dokumen ini punya file (blob maupun path lama). */
    public function hasFile(): bool
    {
        return ! empty($this->file_mime) || ! empty($this->file_path);
    }

    /**
     * URL file kalender. Prioritas: file biner (bytea) di `file_data` yang
     * disajikan lewat route `kalender-akademik.file`; jatuh ke path/URL lama
     * sebagai fallback. Mengembalikan '#' bila tidak ada file.
     */
    public function fileUrl(): string
    {
        if (! empty($this->file_mime)) {
            return route('kalender-akademik.file', $this) . '?v=' . optional($this->updated_at)->timestamp;
        }

        if (! empty($this->file_path)) {
            if (\Illuminate\Support\Str::startsWith($this->file_path, ['http://', 'https://'])) {
                return $this->file_path;
            }

            return asset('storage/' . $this->file_path);
        }

        return '#';
    }
}
