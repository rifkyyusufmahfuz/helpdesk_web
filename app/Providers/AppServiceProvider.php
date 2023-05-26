<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $notifikasi = $user ? $user->allNotifications : null;
            $totalnotifikasi = $user ? $user->unreadNotifications->count() : 0;

            $view->with('notifikasi', $notifikasi);
            $view->with('totalnotifikasi', $totalnotifikasi);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
