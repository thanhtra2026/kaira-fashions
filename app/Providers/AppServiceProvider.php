<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        // Phân trang dùng giao diện Bootstrap 5 (khớp với Kaira) thay vì Tailwind mặc định
        Paginator::useBootstrapFive();
    }
}
