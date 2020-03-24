<?php
namespace App\Data\API\Payment;

use App\Data\API\Payment\IPayment;

use App\Data\API\Payment\PayResult;
use App\Data\API\Payment\OpenSwiftPay;

class OpenSwiftWechat extends OpenSwiftPay
{
    
    protected $pay_method  = "pay.weixin.native";
    protected $pay_msg = "请用微信进行扫码支付";
}
