<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RuangKelas extends Model
{
    protected $table = 'ruang_kelas';

    protected $fillable = [
        'nama_kelas',
        'jumlah_siswa',
        'keterangan',
        'gambar',
        'gambar_mime',
        'urutan',
        'is_active',
    ];

    /** Jangan pernah ikut serialisasi byte gambar ke array/JSON. */
    protected $hidden = ['gambar_data'];

    protected static function booted(): void
    {
        // `jumlah_siswa` bersifat OTOMATIS: selalu dihitung dari data siswa nyata
        // yang kelasnya cocok dengan `nama_kelas`. Dijalankan setiap kali record
        // ruang kelas disimpan (mis. dibuat baru atau namanya diganti), sehingga
        // angka pada kelas selalu terintegrasi dengan data siswa yang dimasukkan.
        static::saving(function (RuangKelas $kelas) {
            $kelas->jumlah_siswa = Siswa::where('kelas', $kelas->nama_kelas)->count();
        });
    }

    /**
     * Hitung ulang `jumlah_siswa` untuk kelas dengan nama tertentu berdasarkan
     * jumlah data siswa nyata. Dipakai oleh event model Siswa agar penambahan/
     * penghapusan siswa langsung tercermin pada kelas tujuan. Memakai query
     * update langsung (bukan save model) agar tidak memicu ulang event `saving`.
     */
    public static function syncCountFor(?string $namaKelas): void
    {
        $namaKelas = trim((string) $namaKelas);
        if ($namaKelas === '') {
            return;
        }

        $jumlah = Siswa::where('kelas', $namaKelas)->count();
        static::where('nama_kelas', $namaKelas)->update(['jumlah_siswa' => $jumlah]);
    }

    /**
     * Kolom ringan untuk query DAFTAR. Sengaja TIDAK menyertakan `gambar_data`
     * (bytea, bisa besar) agar daftar tidak menarik byte gambar setiap record.
     * Byte gambar hanya diambil saat disajikan lewat route `ruang-kelas.gambar`.
     */
    public const LIST_COLUMNS = [
        'id', 'nama_kelas', 'jumlah_siswa', 'keterangan',
        'gambar', 'gambar_mime', 'urutan', 'is_active', 'created_at', 'updated_at',
    ];

    /**
     * URL gambar ruang kelas. Gambar disimpan sebagai DATA BINER (bytea) di kolom
     * `gambar_data`; keberadaannya ditandai oleh `gambar_mime` dan disajikan lewat
     * route `ruang-kelas.gambar`. Bila record lama masih memakai path/URL, pakai
     * itu sebagai fallback. Null bila tidak ada gambar.
     */
    public function gambarUrl(): ?string
    {
        if (! empty($this->gambar_mime)) {
            return route('ruang-kelas.gambar', $this) . '?v=' . optional($this->updated_at)->timestamp;
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
