<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Libs\NotifyHelper;

class NotifyHelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register result builder services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'notifyhelper', function () {
                return new NotifyHelper;
            }
        );
    }
}
