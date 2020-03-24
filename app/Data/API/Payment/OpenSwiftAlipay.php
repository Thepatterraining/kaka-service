<?php
namespace App\Data\API\Payment;

use App\Data\API\Payment\IPayment;
use App\Data\Utils\DocNoMaker;
use App\Data\Utils\XmlHelper;
use App\Data\API\Payment\PayResult;
use App\Data\API\Payment\OpenSwiftPay;

class OpenSwiftAlipay extends OpenSwiftPay
{

    protected $pay_method = "pay.alipay.native";
    protected $pay_msg = "请用支付宝进行扫码支付";
}
