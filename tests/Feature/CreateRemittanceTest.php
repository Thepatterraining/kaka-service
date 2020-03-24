<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Data\Auth\AccessToken;
use App\Data\Utils\DocNoMaker;

class CreateRemittanceTest extends TestCase
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

        //登陆
        // dump('正常登陆');
        // $user = '13263463444';
        // $pwd = '123qwe';
        // $user = $this->login($user,$token,$pwd);
        // dump($user);
        // $this->assertCount(4,$user);
        // $userid = $user['data']['id'];
        // $this->assertTrue(is_numeric($userid));
        // dump('用户id:'.$userid);

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
        $phone = 13263463442;
        $bankid = '34565478965432689';
        $desbankid = '110925871910602';
        $verify = 'KaKamfPwd8080';
        $bankNo = '1';
        $name = '周涛';
        $rachargeNo = $this->racharge($token, $bankid, $desbankid, $phone, $amount, $verify, $bankNo, $name);
        dump($rachargeNo);
        $this->assertCount(4, $rachargeNo);
        $this->assertEquals(0, $rachargeNo['code']);

        //充值
        dump('开始充值：');
        $amount = 2000;
        dump('充值金额：'.$amount);
        $phone = 13263463442;
        $bankid = '2345677658765464';
        $desbankid = '110925871910602';
        $verify = 'KaKamfPwd8080';
        $bankNo = '1';
        $name = '周涛v5';
        $rachargeNo = $this->racharge($token, $bankid, $desbankid, $phone, $amount, $verify, $bankNo, $name);
        dump($rachargeNo);
        $this->assertCount(4, $rachargeNo);
        $this->assertEquals(0, $rachargeNo['code']);

        //充值
        dump('开始充值：');
        $amount = 2000;
        dump('充值金额：'.$amount);
        $phone = 13263463442;
        $bankid = '2345677658765464889';
        $desbankid = '110925871910602';
        $verify = 'KaKamfPwd8080';
        $bankNo = '1';
        $name = '周涛v5';
        $rachargeNo = $this->racharge($token, $bankid, $desbankid, $phone, $amount, $verify, $bankNo, $name);
        dump($rachargeNo);
        $this->assertCount(4, $rachargeNo);
        $this->assertEquals(0, $rachargeNo['code']);
    }

    protected function racharge($token, $bankid, $desbankid, $phone, $amount, $verify, $bankNo, $name)
    {
        $response = $this->json(
            'POST', '/api/cash/createremittance', [
            "accessToken"=>$token,
            'amount'=>$amount,
            'bankid'=>$bankid,
            'desbankid'=>$desbankid,
            'phone'=>$phone,
            "bankNo"=>$bankNo,
            "name"=>$name,
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

    protected function login($user, $token, $pwd, $type = false)
    {
        //用户登陆
        //        $user  = 'kk970645';
        $response = $this->json(
            'POST', '/api/auth/login', array(
            "accessToken"=>$token,
            "userid"=>$user,
            "pwd"=>$pwd

            )
        );
        $response->assertStatus(200);

        return $response->json();
        $name = $response->json();
        dump('登陆成功');

        //        if ($type == 1) {
            dump($response->json());
            return $response->json()['data']['id'];
        //        }

        if ($type == false) {
            //            $user = $this->getUser($token);
            //            return $this->login($user,$token,1);
        }
    }

    protected function getUser($token)
    {
        $pageIndex = rand(1, 10);
        $pageSize = rand(10, 12);
        $index = rand(1, 9);
        $response = $this->json(
            'POST', '/api/admin/getuserlist', [
            "accessToken"=>$token,
            "pageIndex"=>$pageIndex,
            "pageSize"=>$pageSize,
            ]
        );
        $response
            ->assertStatus(200)
            ->assertJson(
                [
                'code' => 0,
                ]
            );

        $user = $response->json()['data']['items'][$index]['user'];
        return $user;
    }
}
