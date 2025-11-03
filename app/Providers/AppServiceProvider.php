<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Midtrans SDK is optional; guard with class_exists

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
        if (class_exists(\Midtrans\Config::class)) {
            $midtrans = config('services.midtrans');
            if (!empty($midtrans['server_key'])) {
                \Midtrans\Config::$serverKey = $midtrans['server_key'];
                \Midtrans\Config::$isProduction = (bool) ($midtrans['is_production'] ?? false);
                \Midtrans\Config::$isSanitized = (bool) ($midtrans['is_sanitized'] ?? true);
                \Midtrans\Config::$is3ds = (bool) ($midtrans['is_3ds'] ?? true);
            }
        }
    }
}
