<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;
use App\Data\Trade\TranactionSellData;

class UlpaymentTest extends TestCase
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
        $count = 1;
        $sellData = new TranactionSellData;
        $where['sell_status'] = TranactionSellData::PARTIAL_TRANSACTION_STATUS;
        $product = $sellData->find($where);
        if (!empty($product)) {
            $productNo = $product->sell_no;
            $response = $this->getList($token, $count, $channelid, $productNo);
            dump($response);
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        }
        
        
    }

    protected function getList($token, $count, $channelid, $productNo)
    {
        $response = $this->json(
            'POST', '/api/login/ulpay/ulpayment', array(
            "accessToken"=>$token,
            "count"=>$count,
            "no"=>$productNo,
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
