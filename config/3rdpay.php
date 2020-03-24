<?php
return [
    "swift"=>[
        "appid"=>env("SWIFTAPPID","102541646412"),
        "key"=>env("SWIFTKEY","a476b6e6901f5f830fbc896b95137837"),
        "url"=>env("SWIFTURL","/api/3rdpay/confirm/swift"),
        "jsurl"=>env("SWIFTJSURL","/api/3rdpay/confirmjs/swift")
    ],
    "ulpay"=>[
        "signhost"=>env("ULPAY_SIGNHOST","http://localhost:8080/post"),
        "host"=>env("ULPAY_HOST","https://www.ulpay.com/")//http://103.25.21.46:11110/")
    ],
    "zkpay"=>[
        "signhost"=>env("ZKPAY_SIGNHOST","http://localhost:8080/zkpost"),
        "host"=>env("ZKPAY_HOST","https://pay.zkxinlong.com/api/pay.mt"),
        "url"=>env("ZKPAY_URL","/api/3rdpay/confirm/zk"),

    ],
    'ulpayclass'=>[
        'testing'=>"App\Data\API\Payment\Ulpay\PayService",
        'development'=>"App\Data\API\Payment\Ulpay\TestPayService",
        'production'=>"App\Data\API\Payment\Ulpay\PayService",
        'alpha'=>"App\Data\API\Payment\Ulpay\PayService"
    ]
];