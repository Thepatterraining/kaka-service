<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));

        foreach ($this->_maproutes as $prefix => $path) {
            Route::prefix($prefix)
             ->middleware('admin')
             ->namespace($this->namespace)
             ->group(base_path($path));
        }

        foreach ($this->_maptokenroutes as $prefix => $path) {
            Route::prefix($prefix)
             ->middleware('token')
             ->namespace($this->namespace)
             ->group(base_path($path));
        }

        foreach ($this->_maploginroutes as $prefix => $path) {
            Route::prefix($prefix)
             ->middleware('login')
             ->namespace($this->namespace)
             ->group(base_path($path));
        }
        foreach ($this->_mapwithoutmidroutes as $prefix => $path) {
            Route::prefix($prefix)
            
             ->group(base_path($path));
        }

        foreach ($this->_module_route as $prefix => $path){
            Route::prefix($prefix)
           // ->namespace($this->namespace)
            ->group(base_path($path));
        }
	Route::prefix("api/application")
	   ->middleware('token')
	   ->group(base_path("routes/api/withoutmid/app.php"));	
    }

    private $_module_route = [
        "resource"=>"routes/api/resource.php",
        ];
    private $_maproutes = [
        "api/v2/admin/act"=>"routes/api/admin/act.php",
        "api/v2/admin/payment"=>"routes/api/admin/payment.php",
        "api/v2/admin/product"=>"routes/api/admin/product.php",
        "api/v2/admin/cash"     =>"routes/api/admin/cash.php",
        "api/v2/admin/wechat"   =>"routes/api/admin/wechat.php",
        "api/v2/admin/schedule" =>"routes/api/admin/schedule.php",
        "api/v2/admin/activity"=>"routes/api/admin/activity.php",
        "api/v2/admin/report"=>"routes/api/admin/report.php",
        "api/v2/admin/profile"=>"routes/api/admin/profile.php",
        "api/v2/admin/bonus"=>"routes/api/admin/bonus.php",
        "api/v2/admin/voucher"=>"routes/api/admin/voucher.php",
        "api/v2/admin/invitation"=>"routes/api/admin/invitation.php",
        "api/v2/admin/resource"=>"routes/api/admin/resource.php",
        "api/admin"=>"routes/api/admin/wechat.php",
        "api/admin/cash"=>"routes/api/admin/cash.php",
        "api/admin/product"=>"routes/api/admin/product.php",
        "api/admin/user"=>"routes/api/admin/user.php",
        "api/admin/activity"=>"routes/api/admin/activity.php",
        "api/admin/project"=>"routes/api/admin/project.php",
        "api/admin/pay"=>"routes/api/admin/pay.php",
        "api/admin/bonus"=>"routes/api/admin/bonus.php",
        "api/admin/auth"=>"routes/api/admin/auth.php",
        "api/v2/admin/notify"=>"routes/api/admin/notify.php",
        "api/v2/admin/region"=>"routes/api/admin/region.php",
        "api/v2/admin/user"=>"routes/api/admin/user.php",
        "api/v2/admin/sys"=>"routes/api/admin/sys.php",
        "api/v2/admin/kyc"=>"routes/api/admin/kyc.php",
        
    ];

    private $_maptokenroutes = [
        "api/token/project"=>"routes/api/token/project.php",
        "api/token/3rdpay"=>"routes/api/token/3rdpay.php",
        "api/token/auth"=>"routes/api/token/auth.php",
        "api/token/user"=>"routes/api/token/user.php",
        "api/token/trade"=>"routes/api/token/trade.php",
        "api/token/resource"=>"routes/api/token/resource.php",
        "api/token/survey"=>"routes/api/token/survey.php",
        "api/token/sys"=>"routes/api/token/sys.php",
    ];

    private $_maploginroutes = [
        "api/login/project"=>"routes/api/login/project.php",
        "api/login/user"=>"routes/api/login/user.php",
        "api/login/ulpay"=>"routes/api/login/ulpay.php",
        "api/login/bank"=>"routes/api/login/bank.php",
        "api/login/trade"=>"routes/api/login/trade.php",
    ];

    private $_mapwithoutmidroutes = [
        "api/withoutmid/queue"=>"routes/api/withoutmid/queue.php",
        
    ];
}
