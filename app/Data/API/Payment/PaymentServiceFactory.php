<?php
namespace App\Data\API\Payment;

use App\Data\API\Payment\Ulpay\PayService ;
use App\Data\API\Payment\Ulpay\TestPayService ;
use APp\Data\API\Payment\IFastPaymentService;

class PaymentServiceFactory
{

    /**
     * 增加了环境的判断
     *
     * @author zhoutao
     * @date   2017.8.23
     */ 
    public function createService()
    {
        $env = config('app.env', null);

        $array = config('3rdpay.ulpayclass', []);
        
        if (array_key_exists($env, $array)) {
            $class = $array[$env];
            return (new $class);
        } else {
            return   (new TestPayService())  ;
        }
    }
}