<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\KontenController;
use App\Http\Controllers\Admin\PesanController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Publik (pengunjung)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'beranda'])->name('beranda');
Route::get('/profil', [PublicController::class, 'profil'])->name('profil');
Route::get('/mahasiswa', [PublicController::class, 'mahasiswa'])->name('mahasiswa');
Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri');
Route::get('/kontak', [PublicController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [PublicController::class, 'kirimPesan'])->name('kontak.kirim');

/*
|--------------------------------------------------------------------------
| Login Admin
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('login.proses');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Panel Admin (wajib login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('galeri', GaleriController::class)->except(['show']);
    Route::resource('mahasiswa', MahasiswaController::class)->except(['show']);

    Route::get('konten', [KontenController::class, 'index'])->name('konten.index');
    Route::put('konten', [KontenController::class, 'update'])->name('konten.update');

    Route::get('pesan', [PesanController::class, 'index'])->name('pesan.index');
    Route::get('pesan/{pesan}', [PesanController::class, 'show'])->name('pesan.show');
    Route::delete('pesan/{pesan}', [PesanController::class, 'destroy'])->name('pesan.destroy');
});
