<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProvider extends ServiceProvider
{



    private function addValidator($exp, $validateclass)
    {
         Validator::extend($exp, $validateclass);
         Validator::replacer($exp, $validateclass);
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       
        $this->addValidator('doc', "App\Http\Validation\Document");
        $this->addValidator('dic', "App\Http\Validation\Dictionary");
        $this->addValidator("cashmulti", "App\Http\Validation\CheckCashMulti");
        $this->addValidator('idno', 'App\Http\Validation\Idno');
        $this->addValidator('pwd', 'App\Http\Validation\Pwd');
        $this->addValidator('paypwd', 'App\Http\Validation\PayPwd');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
