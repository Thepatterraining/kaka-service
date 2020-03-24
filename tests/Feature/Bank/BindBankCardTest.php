<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class BindBankCardTest extends TestCase
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

        //开始绑卡
        dump('开始绑卡');
        $bankCard = '6214830177107611';
        $phone = '13263463442';
        $verify = 'KaKamfPwd8080';
        // $name = '周涛';
        // $idno = '421126199803263816';

        $bankNo = '5';
        $response = $this->getList($token, $bankCard, $phone, $verify, $bankNo);
        dump($response);
        // $this->assertCount(4, $response);
        // $this->assertEquals(0, $response['code']);
        
        
    }

    protected function getList($token, $bankCard, $phone, $verify, $bankNo)
    {
        $response = $this->json(
            'POST', '/api/login/bank/bindbankcard', array(
            "accessToken"=>$token,
            "bankCard"=>$bankCard,
            "phone"=>$phone,
            "verify"=>$verify,
            "bankNo"=>$bankNo,
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
