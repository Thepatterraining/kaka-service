<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class UlpayRechargeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetProductInfo()
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

        //开始登陆
        dump('手机号登陆');
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        $response = $this->mobileLogin($phone, $token, $verify);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //开始充值
        dump('开始充值');
        $channelid = 5;
        $amount = 999.9;
        $response = $this->getList($token, $amount, $channelid);
        dump($response);
        $this->assertCount(3, $response);
        $this->assertEquals(903001, $response['code']);

        //开始充值
        dump('开始充值');
        $channelid = 5;
        $amount = 1000;
        $response = $this->getList($token, $amount, $channelid);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);
        
        
    }

    protected function getList($token, $amount, $channelid)
    {
        $response = $this->json(
            'POST', '/api/login/ulpay/recharge', array(
            "accessToken"=>$token,
            "amount"=>$amount,
            "channelid"=>$channelid,
            )
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
