<?php
namespace App\Data\API\Payment;

class PaymentFactory
{

    private $mapArray = [

        "swift.wechat"=> OpenSwiftWechat::class,
        "swift.alipay"=> OpenSwiftAlipay::class,
        "swift.jspay"=>OpenSwiftJspay::class
    ];

    public function create($payment)
    {
        if (array_key_exists($payment, $this->mapArray)) {
            $payMethod = $this->mapArray[$payment];
            return new $payMethod();
        } else {
            return new OpenSwiftWechat();
        }
    }
}
