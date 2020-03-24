<?php

namespace Tests\Feature\CashRecharge;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class ThirdRechargeTest extends TestCase
{
    private $channelid = 2;
    private $openid = 'oql71w24Lx7OjqpvLsNKYqgQhgAs';
    private $appid = 'wx131f45fbf860026f';

    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testCashRecharge()
    {
        dump('测试开始');
        dump("Require Token:");
        $response = $this->json('POST', '/api/auth/token/require', array());
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];

        dump($token);

        dump('手机号登陆');
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        $response = $this->mobileLogin($phone, $token, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //充值
        dump('开始充值：');
        $amount = 2000;
        dump('充值金额：'.$amount);
        $response = $this->racharge($token, $amount);
        dump($response);
        if ($response['code'] === 0) {
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        }

        //充值
        // dump('开始充值：');
        // $amount = 2000;
        // dump('充值金额：'.$amount);
        // $response = $this->payRecharge($token, $amount);
        // dump($response);
        // if ($response['code'] === 0) {
        //     $this->assertCount(4, $response);
        //     $this->assertEquals(0, $response['code']);
        // }
        
    }

    protected function payRecharge($token, $amount, $channelid = 1)
    {
        $response = $this->json(
            'POST', '/api/3rdpay/gateway', [
            "accessToken"=>$token,
            "amount"=>$amount,
            "channelid"=>$this->channelid,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function racharge($token, $amount)
    {
        $response = $this->json(
            'POST', '/api/3rdpay/recharge', [
            "accessToken"=>$token,
            'amount'=>$amount,
            'channelid'=>$this->channelid,
            'appid'=>$this->appid,
            "openid"=>$this->openid,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function mobileLogin($phone, $token, $verify)
    {
        $response = $this->json(
            'POST', '/api/auth/mobilelogin', array(
            "accessToken"=>$token,
            "phone"=>$phone,
            "verify"=>$verify
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
