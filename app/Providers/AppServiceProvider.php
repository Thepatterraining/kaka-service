<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Observers\ModelObserver;
use App\Loader\ObserverLoader;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        

        //注册事件  

        $obLoader = new ObserverLoader();
        $obLoader -> load();
        DB::listen(
            function ($query) {
                $sql =  strtolower($query->sql);
                if($query->time > 100) {
                    Log::info('the query time is :'.$query->time);
                    Log::info($sql);
                }
                else if ($sql == 'SELECT /*!40001 SQL_NO_CACHE */ * FROM `settlement_user_cash`') {
               
                }
            }
        );
  
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
