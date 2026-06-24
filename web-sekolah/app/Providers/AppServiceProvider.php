<?php

namespace App\Providers;

use App\Models\Pesan;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan jumlah pesan belum dibaca ke layout admin (badge notifikasi).
        // Cukup di 'layouts.admin' — sidebar di-@include sehingga mewarisi $unreadPesan,
        // jadi query hanya jalan sekali per request.
        View::composer('layouts.admin', function ($view) {
            $unread = (auth()->check() && Schema::hasTable('pesan'))
                ? Pesan::where('is_read', false)->count()
                : 0;

            $view->with('unreadPesan', $unread);
        });
    }
}
