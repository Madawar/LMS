<?php

namespace App\Providers;

use App\Models\Staff;
use App\Observers\StaffObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Staff::observe(StaffObserver::class);
    }
}
