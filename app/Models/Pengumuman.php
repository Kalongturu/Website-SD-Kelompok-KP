<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'judul',
        'ringkasan',
        'isi',
        'lampiran',
        'lampiran_mime',
        'lampiran_nama',
        'penting',
        'tanggal',
        'is_active',
    ];

    protected $casts = [
        'penting'   => 'boolean',
        'tanggal'   => 'date',
        'is_active' => 'boolean',
    ];

    /** Jangan pernah ikut serialisasi byte lampiran ke array/JSON (mis. payload modal). */
    protected $hidden = ['lampiran_data'];

    /** Selalu sertakan URL lampiran saat di-serialisasi ke JSON (dipakai modal di frontend). */
    protected $appends = ['lampiran_url'];

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `lampiran_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte berkas setiap record.
     * Byte berkas hanya diambil saat disajikan lewat route `pengumuman.lampiran`.
     */
    public const LIST_COLUMNS = [
        'id', 'judul', 'ringkasan', 'isi', 'lampiran', 'lampiran_mime', 'lampiran_nama',
        'penting', 'tanggal', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * URL lampiran pengumuman. Berkas disimpan sebagai DATA BINER (bytea) di kolom
     * `lampiran_data`; keberadaannya ditandai oleh `lampiran_mime` dan disajikan
     * lewat route `pengumuman.lampiran`. Bila record lama masih memakai path file,
     * pakai itu sebagai fallback. Null bila tidak ada lampiran.
     */
    public function getLampiranUrlAttribute(): ?string
    {
        if (! empty($this->lampiran_mime)) {
            return route('pengumuman.lampiran', $this) . '?v=' . optional($this->updated_at)->timestamp;
        }

        if (! empty($this->lampiran)) {
            return asset('storage/' . $this->lampiran);
        }

        return null;
    }

    /**
     * Preview keterangan untuk daftar pengumuman.
     */
    public function preview(int $panjang = 110): string
    {
        $teks = $this->ringkasan ?: strip_tags((string) $this->isi);

        return Str::limit(trim($teks), $panjang);
    }
}
