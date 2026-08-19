<?php

namespace App\Providers;

use App\Models\services_img;
use App\Policies\ServicesImgPolicy;
use Illuminate\Support\Facades\Gate;
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
        // The services_img model's snake_case name doesn't match Laravel's
        // PascalCase policy auto-discovery convention, so register it explicitly.
        Gate::policy(services_img::class, ServicesImgPolicy::class);
    }
}
