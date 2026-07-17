<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'judul',
        'kategori',
        'gambar',
        'gambar_mime',
        'keterangan',
        'tanggal',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'urutan'    => 'integer',
        'is_active' => 'boolean',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON. */
    protected $hidden = ['gambar_data'];

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `gambar_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte gambar setiap record.
     * Byte gambar hanya diambil saat disajikan lewat route `galeri.gambar`.
     */
    public const LIST_COLUMNS = [
        'id', 'judul', 'kategori', 'gambar', 'gambar_mime', 'keterangan',
        'tanggal', 'urutan', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * Foto-foto pada album ini (urut sesuai `urutan`). Sebuah galeri berperan
     * sebagai ALBUM yang dapat memuat banyak foto.
     */
    public function fotos(): HasMany
    {
        return $this->hasMany(GaleriFoto::class)->orderBy('urutan')->orderBy('id');
    }

    /**
     * Daftar URL semua foto album (untuk carousel). Memakai relasi `fotos` bila
     * sudah dimuat; jatuh ke gambar tunggal lama sebagai fallback bila album belum
     * punya baris foto (record lama). Selalu mengembalikan array (bisa kosong).
     *
     * @return array<int, string>
     */
    public function fotoUrls(): array
    {
        $urls = $this->fotos
            ->map(fn (GaleriFoto $f) => $f->gambarUrl())
            ->filter()
            ->values()
            ->all();

        if (! empty($urls)) {
            return $urls;
        }

        $legacy = $this->gambarUrl();
        return $legacy ? [$legacy] : [];
    }

    /** URL foto sampul album (foto pertama) untuk kartu grid. Null bila kosong. */
    public function coverUrl(): ?string
    {
        return $this->fotoUrls()[0] ?? null;
    }

    /**
     * URL gambar galeri. Gambar disimpan sebagai DATA BINER (bytea) di kolom
     * `gambar_data`; keberadaannya ditandai oleh `gambar_mime` dan disajikan lewat
     * route `galeri.gambar`. Bila record lama masih memakai path/URL, pakai itu
     * sebagai fallback. Null bila tidak ada gambar (kartu memakai placeholder).
     */
    public function gambarUrl(): ?string
    {
        if (! empty($this->gambar_mime)) {
            return route('galeri.gambar', $this) . '?v=' . optional($this->updated_at)->timestamp;
        }

        if (! empty($this->gambar)) {
            if (Str::startsWith($this->gambar, ['http://', 'https://'])) {
                return $this->gambar;
            }

            return asset('storage/' . $this->gambar);
        }

        return null;
    }
}
