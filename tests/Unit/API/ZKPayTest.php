<?php
namespace Tests\Unit\API;
use App\Data\API\Wechat\Wechat;
use App\Data\Auth\WechatMsg;
use Tests\TestCase;
use  App\Data\API\Payment\ZKXinlong\PayService;

class ZKPayTest extends TestCase
{

    
    public function testZKPay()
    {

        $pay = new PayService();
        $amount = "4.00";
        $jobno = "dsadf900002";
        $openid = "oHGcAwzeF7C3LECR8o4EragVTyAM";
        $timeout  = "121";
        $res = $pay ->reqPay($amount, $jobno, $openid, $timeout);
        dump($res);
    }
}