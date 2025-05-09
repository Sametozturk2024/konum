<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit; // Ekleyin
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request; // Ekleyin
use Illuminate\Support\Facades\RateLimiter; // Ekleyin
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting(); // Bu satır zaten var olmalı veya ekleyin

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        // Adres kaydetme işlemi için özel bir rate limiter tanımlayalım
        RateLimiter::for('address_store', function (Request $request) {
            // Dakikada 5 istek, kullanıcı IP'sine göre
            return Limit::perMinute(5)->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Çok fazla istek gönderdiniz. Lütfen biraz bekleyin.'
                    ], 429, $headers);
                });
        });
    }
}
