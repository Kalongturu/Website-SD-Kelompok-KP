<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Avatar admin disimpan sebagai DATA BINER (bytea) langsung di tabel `users`,
     * mengikuti pola foto guru (lihat add_foto_blob_to_guru_table). Dengan begitu
     * gambar ikut tersimpan di database — tidak bergantung pada folder storage di
     * disk yang tidak selalu persisten di hosting dan butuh `storage:link`.
     *
     * - avatar_data : isi byte gambar (bytea)
     * - avatar_mime : tipe MIME gambar (mis. image/jpeg) untuk Content-Type
     *
     * Kolom lama `avatar` (varchar) DIPERTAHANKAN agar tetap bisa menyimpan URL
     * avatar eksternal (http/https) bila suatu saat dibutuhkan.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'avatar_data')) {
                $table->binary('avatar_data')->nullable();      // -> bytea di PostgreSQL
            }
            if (! Schema::hasColumn('users', 'avatar_mime')) {
                $table->string('avatar_mime', 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['avatar_data', 'avatar_mime'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
