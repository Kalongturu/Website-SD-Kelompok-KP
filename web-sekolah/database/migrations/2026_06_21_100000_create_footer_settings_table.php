<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah', 100)->default('SDN Dadapsari');
            $table->text('deskripsi')->nullable();
            $table->string('alamat', 200)->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('jam_weekday', 50)->nullable();
            $table->string('jam_sabtu', 50)->nullable();
            $table->string('copyright', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
