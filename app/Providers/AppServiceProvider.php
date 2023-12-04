<?php

namespace App\Providers;

use App\Services\Discount\CartTotalStrategy;
use App\Services\Discount\CombinedStrategy;
use App\Services\Discount\ProductStrategy;
use Illuminate\Contracts\Routing\UrlGenerator;
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
    public function boot(UrlGenerator $url)
    {
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }

        $this->app->when(CombinedStrategy::class)
            ->needs('$strategies')
            ->give([
                $this->app->make(ProductStrategy::class),
                $this->app->make(CartTotalStrategy::class)
           ]);
    }
}
