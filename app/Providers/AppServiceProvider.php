<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        Carbon::macro('ToFormattedData',function()
        {
            return $this->format('Y-m-d');
        });
        //formate Time
        Carbon::macro('ToFormattedTime',function()
        {
            return $this->format('H:i:s');
        });
    }
}
