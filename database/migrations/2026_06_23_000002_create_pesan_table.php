<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pesan dari form kontak publik — tabel milik website.
        if (! Schema::hasTable('pesan')) {
            Schema::create('pesan', function (Blueprint $table) {
                $table->id();
                $table->string('nama', 150);
                $table->string('email', 191);
                $table->string('subjek', 200)->nullable();
                $table->text('pesan');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pesan');
    }
};
