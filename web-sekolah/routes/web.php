<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }

    return view('home');
});

Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('fasilitas', function () {
        $sarpras = [
            ['jenis' => 'Ruang Kelas', 'ganjil' => 6, 'genap' => 6],
            ['jenis' => 'Ruang Perpustakaan', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Laboratorium', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Praktik', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang Pimpinan', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Guru', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Ibadah', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang UKS', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang Toilet', 'ganjil' => 5, 'genap' => 5],
            ['jenis' => 'Ruang Gudang', 'ganjil' => 1, 'genap' => 1],
            ['jenis' => 'Ruang Sirkulasi', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Tempat Bermain / Olahraga', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang TU', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang Konseling', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang OSIS', 'ganjil' => 0, 'genap' => 0],
            ['jenis' => 'Ruang Bangunan', 'ganjil' => 1, 'genap' => 1],
        ];

        return view('Profil.fasilitas', compact('sarpras'));
    })->name('fasilitas');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', function () {
        return view('admin.auth_admin');
    })->name('login');

    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});