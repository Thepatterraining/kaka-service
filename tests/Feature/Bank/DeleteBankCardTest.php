<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class DeleteBankCardTest extends TestCase
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

        //开始解除绑卡
        dump('开始解除绑卡');
        $bankCard = '1234567887654377';
        $paypwd = '123qweA';
            $response = $this->getList($token, $bankCard, $paypwd);
            dump($response);
            $this->assertCount(4, $response);
            $this->assertEquals(0, $response['code']);
        
        
    }

    protected function getList($token, $bankCard, $paypwd)
    {
        $response = $this->json(
            'POST', '/api/user/deletecashbank', array(
            "accessToken"=>$token,
            "bankCard"=>$bankCard,
            "paypwd"=>$paypwd,
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
