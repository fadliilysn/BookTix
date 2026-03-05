<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share pending order count ke semua view yang pakai layouts.admin
        View::composer('layouts.admin', function ($view) {
            $view->with('pendingOrderCount', Order::where('status', 'pending')->count());
        });
    }
}