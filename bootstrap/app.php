<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use App\Http\Middleware\NoCacheHeaders;
use App\Http\Middleware\RedirectAdminToPanel;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(fn () => route('admin.login'));

        $middleware->alias([
            'nocache'        => NoCacheHeaders::class,
            'redirect.admin' => RedirectAdminToPanel::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 419 Page Expired — redirect ke login dengan pesan yang jelas
        $exceptions->render(function (TokenMismatchException $e, $request) {
            if ($request->is('admin/login') || $request->expectsJson()) {
                return null;
            }

            return redirect()->route('admin.login')
                ->withInput($request->except(['password', '_token']))
                ->with('error', 'Sesi formulir telah kedaluwarsa. Silakan coba lagi.');
        });
    })->create();
