<?php

namespace Illusi03\LaraSearch;
use Illuminate\Support\ServiceProvider;

class LaraSearchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Illusi03\LaraSearch\LaraSearch');
    }
}
