<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Middleware\NoCacheHeaders;
use App\Http\Middleware\RedirectAdminToPanel;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Di hosting seperti Vercel, HTTPS diterminasi di edge/proxy lalu request
        // diteruskan ke PHP sebagai HTTP biasa + header X-Forwarded-Proto: https.
        // Tanpa mempercayai proxy, Laravel mengira koneksinya http:// dan membuat
        // URL http:// di halaman https:// — CSS/JS diblokir browser (mixed content).
        // Laravel hanya auto-trust untuk Laravel Cloud/Forge/Vapor, bukan Vercel.
        //
        // Aman untuk lokal: tanpa header X-Forwarded-*, baris ini tidak berefek.
        $middleware->trustProxies(at: '*');

        $middleware->redirectGuestsTo(fn () => route('admin.login'));

        $middleware->alias([
            'nocache'        => NoCacheHeaders::class,
            'redirect.admin' => RedirectAdminToPanel::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 419 Page Expired — redirect ke login dengan pesan yang jelas.
        //
        // PENTING: callback ini HARUS menargetkan HttpException, bukan
        // TokenMismatchException. Handler::render() memanggil prepareException()
        // — yang memetakan TokenMismatchException menjadi HttpException(419) —
        // SEBELUM renderViaCallbacks(). Callback bertipe TokenMismatchException
        // karena itu tidak pernah cocok dan 419 mentah tetap tampil.
        $exceptions->render(function (HttpException $e, $request) {
            $isCsrf = $e->getStatusCode() === 419
                && $e->getPrevious() instanceof TokenMismatchException;

            if (! $isCsrf || $request->expectsJson()) {
                return null; // biarkan Laravel menangani seperti biasa
            }

            // Penyebab tersering: tombol "Masuk" tertekan dua kali saat halaman
            // lambat — submit pertama berhasil dan me-regenerasi sesi, sehingga
            // token pada submit kedua tidak cocok lagi. Kalau sesinya ternyata
            // sudah login, antar ke dashboard alih-alih menampilkan layar 419.
            if (auth()->check()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('admin.login')
                ->withInput($request->except(['password', '_token']))
                ->with('error', 'Sesi formulir telah kedaluwarsa. Silakan masuk kembali.');
        });
    })->create();
