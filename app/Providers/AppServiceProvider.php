<?php

namespace App\Providers;

use App\Domain\Strategy\MessageContext;
use App\Domain\Strategy\MessageStrategyInterface; 
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MessageStrategyInterface::class , MessageContext::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
