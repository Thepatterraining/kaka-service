<?php

namespace App\Providers;

use App\Http\Utils\Session;

use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
 
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
 
    }
 

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
 
            $this->app->singleton(
                'App\Http\Utils\Session', function ($app) {
                    return new   Session;
                }
            );
    }
}
