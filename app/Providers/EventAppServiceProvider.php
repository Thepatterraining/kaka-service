<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

use App\Observers\EventObserver;
use App\Loader\EventObserverLoader;

class EventAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            

        //注册事件  

        $obLoader = new EventObserverLoader();
        $obLoader -> load();
 
  
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
