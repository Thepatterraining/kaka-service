<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class AddBonusTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @covers
     */
    public function testGetCurves()
    {
        dump('测试开始');
        dump("Require Token:");
        $response = $this->json('POST', '/api/auth/token/adminrequire', array());
        $response->assertStatus(200);
        $this->assertEquals(4, count($response->json()));
        $this->assertEquals(2, count($response->json()["data"]));
        $this->assertEquals(0, $response->json()['code']);
        $token = $response->json()["data"]["accessToken"];

        dump($token);

        dump('管理员登陆');
        $userid = 'kaka';
        $pwd = '123456';
        $response = $this->adminLogin($userid, $token, $pwd);
        dump($response);
        $this->assertCount(4, $response);
        $this->assertEquals(0, $response['code']);

        //发起分红
        dump('发起分红');
        $rightNo = 'phpunitRightNo';
        $amount = 10000;
        $planfee = 3000;
        $unit = 0.01;
        $starttime = date('Y-m-d H:i:s');
        $endtime = date('Y-m-d H:i:s');
        $coinType='KKC-BJ0001';
        $response = $this->create($token, $rightNo, $amount, $planfee, $unit, $starttime, $endtime, $coinType);
        dump($response);
        // $this->assertCount(4, $response);
        // $this->assertEquals(0, $response['code']);
    }

    protected function create($token, $rightNo, $amount, $planfee, $unit, $starttime, $endtime,$coinType)
    {
        $response = $this->json(
            'POST', '/api/admin/bonus/createBonus', array(
            "accessToken"=>$token,
            "rightNo"=>$rightNo,
            "amount"=>$amount,
            "planfee"=>$planfee,
            "unit"=>$unit,
            "starttime"=>$starttime,
            "endtime"=>$endtime,
            "coinType"=>$coinType,
            "authDate"=>date('2017-6-29'),
            "bonusInstalment" => "phpunit测试期",
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }

    protected function adminLogin($userid, $token, $pwd)
    {
        $response = $this->json(
            'POST', '/api/admin/login', array(
            "accessToken"=>$token,
            "userid"=>$userid,
            "pwd"=>$pwd
            )
        );
        $response->assertStatus(200);
        return $response->json();
    }
}
