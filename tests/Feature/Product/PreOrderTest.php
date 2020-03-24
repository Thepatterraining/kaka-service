<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class PreOrderTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testPreOrder()
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


        //微信购买产品
        /*   dump('微信购买产品');
        $infoData = new \App\Data\Product\PreOrderData;
        $productNo = 'PRO2017051008373486737';
        $count = 2;
        $voucherNo = 'null';
        $res = $infoData->wechatBuyPreProduct($productNo,$count,$voucherNo);
        dd($res);*/
        // $pageIndex = 1;
        // $pageSize = 10;
        // $response = $this->getList($token,$pageIndex,$pageSize);
        // dump($response);
        // $this->assertCount(4,$response);
        // $this->assertEquals(0,$response['code']);
        // $this->assert(true);
    }

    protected function getList($token, $pageIndex, $pageSize)
    {
        $response = $this->json(
            'POST', '/api/product/getproductinfolist', array(
            "accessToken"=>$token,
            "pageIndex"=>$pageIndex,
            "pageSize"=>$pageSize,
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
