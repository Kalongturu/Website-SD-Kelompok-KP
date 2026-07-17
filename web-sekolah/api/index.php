<?php

/**
 * Entry point khusus VERCEL (serverless).
 *
 * File ini HANYA dipakai saat aplikasi berjalan di Vercel. Pengembangan lokal
 * (php artisan serve / XAMPP) tetap memakai `public/index.php` seperti biasa dan
 * TIDAK terpengaruh file ini.
 *
 * Kenapa perlu file terpisah? Filesystem Vercel bersifat READ-ONLY kecuali
 * direktori /tmp. Laravel butuh menulis (mis. cache view Blade yang dikompilasi),
 * jadi seluruh storage path diarahkan ke /tmp sebelum framework di-boot.
 *
 * Catatan: /tmp bersifat SEMENTARA dan tidak dibagi antar-instance. Karena itu
 * data yang harus permanen TIDAK boleh ditaruh di sana — gambar sudah aman
 * karena tersimpan sebagai biner di database (lihat HandlesDbImage).
 */

$storage = '/tmp/storage';

// Laravel 12 menghormati LARAVEL_STORAGE_PATH lewat $_ENV/$_SERVER, sehingga
// semua storage_path() (view terkompilasi, log, cache file) menunjuk ke /tmp.
$_ENV['LARAVEL_STORAGE_PATH'] = $_SERVER['LARAVEL_STORAGE_PATH'] = $storage;

// Folder aplikasi (termasuk bootstrap/cache) READ-ONLY di serverless. Bila manifest
// paket belum sempat dibuat saat build, Laravel akan mencoba menulisnya saat runtime
// dan gagal. Arahkan semua cache bootstrap ke /tmp yang bisa ditulis.
foreach ([
    'APP_PACKAGES_CACHE' => $storage . '/bootstrap/packages.php',
    'APP_SERVICES_CACHE' => $storage . '/bootstrap/services.php',
    'APP_CONFIG_CACHE'   => $storage . '/bootstrap/config.php',
    'APP_ROUTES_CACHE'   => $storage . '/bootstrap/routes.php',
    'APP_EVENTS_CACHE'   => $storage . '/bootstrap/events.php',
] as $kunci => $nilai) {
    $_ENV[$kunci] = $_SERVER[$kunci] = $nilai;
}

// Direktori harus SUDAH ADA sebelum config dimuat: config/view.php memakai
// realpath() yang mengembalikan false bila foldernya belum ada.
foreach ([
    $storage . '/framework/views',
    $storage . '/framework/cache/data',
    $storage . '/framework/sessions',
    $storage . '/logs',
    $storage . '/bootstrap',
] as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Jalankan Laravel seperti biasa lewat entry point standarnya.
require __DIR__ . '/../public/index.php';
