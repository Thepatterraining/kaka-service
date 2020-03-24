<?php
return [
    'ulpayclass'=>[
        'testing'=>"App\Data\API\Payment\Ulpay\TestPayService",
        'development'=>"App\Data\API\Payment\Ulpay\TestPayService",
        'production'=>"App\Data\API\Payment\Ulpay\PayService",
        'alpha'=>"App\Data\API\Payment\Ulpay\PayService"
    ]
];