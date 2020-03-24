<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class SmsCodeTest extends TestCase
{
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


        // 给用户发送验证码
        // dump('给用户发送验证码：');
        // $phone = 13263463400;
        // $type = 'SLT05'; //注册
        // $response = $this->addvoucher($token,$phone,$type);
        // dump($response);
        // $this->assertCount(3,$response);
        // $this->assertEquals(801013,$response['code']);


        // //给用户发送验证码
        // dump('给用户发送验证码：');
        // $phone = 13263463442;
        // $type = 'SLT08'; //注册
        // $response = $this->addvoucher($token,$phone,$type);
        // dump($response);
        // $this->assertCount(3,$response);
        // $this->assertEquals(801013,$response['code']);
    }

    protected function addvoucher($token, $phone, $type)
    {
        $response = $this->json(
            'POST', '/api/sms/sendcode', [
            "accessToken"=>$token,
            'phone'=>$phone,
            'type'=>$type,
            ]
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
