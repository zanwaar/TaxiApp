<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Carbon::macro('toFormattedDate', function () {
            return $this->format('d-M-Y / h:i A');
        });
        Carbon::macro('FormattedDate', function () {
            return $this->format('d-F-Y  h:i A');
        });
        Carbon::macro('toFormatted', function () {
            return $this->format('d F Y');
        });

        Carbon::macro('toFormattedTime', function () {
            return $this->format('h:i A');
        });

        Carbon::macro('todate', function () {
            return $this->format('Y-m-d');
        });
        Paginator::useBootstrap();
    }
}
