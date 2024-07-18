<?php

namespace App\Providers;

use App\Models\Allocation;
use App\Observers\AllocationObserver;
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
        Allocation::observe(AllocationObserver::class);
    }
}
